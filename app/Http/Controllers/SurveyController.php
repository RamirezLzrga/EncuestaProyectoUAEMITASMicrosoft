<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\SurveyResponse;
use App\Models\ActivityLog;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Survey::with('user')->where('user_id', Auth::id());

        // Obtener todas las fechas donde hay encuestas (para el calendario)
        $surveyDates = Survey::where('user_id', Auth::id())
            ->pluck('start_date')
            ->map(function ($date) {
                // Asegurarse de tener solo la parte de fecha Y-m-d
                return \Carbon\Carbon::parse($date)->format('Y-m-d');
            })
            ->unique()
            ->values()
            ->toArray();

        // Filtro por Fecha de Inicio (Desde)
        if ($request->has('start_date') && !empty($request->start_date)) {
            $query->where('start_date', '>=', $request->start_date);
        }

        if ($request->has('status') && $request->status != 'Todas') {
            $isActive = $request->status == 'Activas';
            $query->where('is_active', $isActive);
        }

        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $surveys = $query->orderBy('created_at', 'desc')->get();

        $user = Auth::user();
        $view = $user && $user->role === 'admin'
            ? 'surveys.index'
            : 'editor.encuestas.index';

        return view($view, compact('surveys', 'surveyDates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('surveys.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'header_image' => 'nullable|string',
            'year' => 'required|integer',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'settings' => 'array',
            'questions' => 'required|array|min:1',
            'questions.*.text' => 'required|string',
            'questions.*.type' => 'required|string',
            'questions.*.options' => 'nullable|array',
            'questions.*.required' => 'nullable',
            'questions.*.description' => 'nullable|string',
            'questions.*.image_url' => 'nullable|string',
            'questions.*.video_url' => 'nullable|string',
        ]);

        // Asegurar que questions sea un array indexado (lista) y procesar checkboxes
        $questions = array_values($validated['questions']);
        foreach ($questions as &$question) {
            $question['required'] = isset($question['required']); // Convertir "on" a boolean
        }
        $validated['questions'] = $questions;

        // Procesar settings (checkboxes no enviados si no están marcados)
        $defaultSettings = [
            'anonymous' => false,
            'collect_names' => false,
            'collect_emails' => false,
            'allow_multiple' => false,
            'one_response_per_ip' => false,
            'max_responses' => null,
        ];
        $rawSettings = $request->input('settings', []);
        $mergedSettings = array_merge($defaultSettings, $rawSettings);

        $booleanKeys = ['anonymous', 'collect_names', 'collect_emails', 'allow_multiple', 'one_response_per_ip'];
        foreach ($booleanKeys as $key) {
            $mergedSettings[$key] = !empty($mergedSettings[$key]);
        }

        if (isset($mergedSettings['max_responses']) && $mergedSettings['max_responses'] !== null && $mergedSettings['max_responses'] !== '') {
            $mergedSettings['max_responses'] = (int) $mergedSettings['max_responses'];
            if ($mergedSettings['max_responses'] <= 0) {
                $mergedSettings['max_responses'] = null;
            }
        } else {
            $mergedSettings['max_responses'] = null;
        }

        $validated['settings'] = $mergedSettings;

        $survey = new Survey($validated);
        $survey->user_id = Auth::id();
        $survey->is_active = false;
        $survey->approval_status = 'pending';
        $survey->save();

        // Log Activity
        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_email' => Auth::user()->email,
            'action' => 'create',
            'description' => 'Creó nueva encuesta: ' . $survey->title,
            'type' => 'survey',
            'ip_address' => $request->ip(),
            'details' => ['survey_id' => $survey->id]
        ]);

        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'role' => 'admin',
                'title' => 'Nueva encuesta creada',
                'message' => Auth::user()->name . ' creó la encuesta "' . $survey->title . '"',
                'type' => 'survey_created',
                'data' => [
                    'survey_id' => (string) $survey->id,
                    'creator_id' => (string) Auth::id(),
                ],
            ]);
        }

        return redirect()->route('surveys.index')->with('success', 'Encuesta creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Survey $survey)
    {
        return view('surveys.show', compact('survey'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Survey $survey)
    {
        return view('surveys.edit', compact('survey'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Survey $survey)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'header_image' => 'nullable|string',
            'year' => 'required|integer',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'settings' => 'array',
            'questions' => 'required|array|min:1',
            'questions.*.text' => 'required|string',
            'questions.*.type' => 'required|string',
            'questions.*.options' => 'nullable|array',
            'questions.*.required' => 'nullable',
            'questions.*.description' => 'nullable|string',
            'questions.*.image_url' => 'nullable|string',
            'questions.*.video_url' => 'nullable|string',
        ]);

        // Asegurar que questions sea un array indexado (lista) y procesar checkboxes
        $questions = array_values($validated['questions']);
        foreach ($questions as &$question) {
            $question['required'] = isset($question['required']); // Convertir "on" a boolean
        }
        $validated['questions'] = $questions;

        // Procesar settings
        $defaultSettings = [
            'anonymous' => false,
            'collect_names' => false,
            'collect_emails' => false,
            'allow_multiple' => false,
            'one_response_per_ip' => false,
            'max_responses' => null,
        ];
        $rawSettings = $request->input('settings', []);
        $mergedSettings = array_merge($defaultSettings, $rawSettings);

        $booleanKeys = ['anonymous', 'collect_names', 'collect_emails', 'allow_multiple', 'one_response_per_ip'];
        foreach ($booleanKeys as $key) {
            $mergedSettings[$key] = !empty($mergedSettings[$key]);
        }

        if (isset($mergedSettings['max_responses']) && $mergedSettings['max_responses'] !== null && $mergedSettings['max_responses'] !== '') {
            $mergedSettings['max_responses'] = (int) $mergedSettings['max_responses'];
            if ($mergedSettings['max_responses'] <= 0) {
                $mergedSettings['max_responses'] = null;
            }
        } else {
            $mergedSettings['max_responses'] = null;
        }

        $validated['settings'] = $mergedSettings;

        $survey->update($validated);
        $survey->approval_status = 'pending';
        $survey->approval_comment = null;
        $survey->approved_by = null;
        $survey->approved_at = null;
        $survey->save();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_email' => Auth::user()->email,
            'action' => 'update',
            'description' => 'Actualizó encuesta: ' . $survey->title,
            'type' => 'survey',
            'ip_address' => $request->ip(),
            'details' => ['survey_id' => $survey->id]
        ]);

        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'role' => 'admin',
                'title' => 'Encuesta actualizada',
                'message' => Auth::user()->name . ' actualizó la encuesta "' . $survey->title . '"',
                'type' => 'survey_updated',
                'data' => [
                    'survey_id' => (string) $survey->id,
                    'editor_id' => (string) Auth::id(),
                ],
            ]);
        }

        return redirect()->route('surveys.index')->with('success', 'Encuesta actualizada exitosamente.');
    }

    /**
     * Toggle status (Habilitar/Inhabilitar)
     */
    public function toggleStatus(Request $request, Survey $survey)
    {
        if (!Auth::user() || Auth::user()->role !== 'admin') {
            abort(403, 'Solo los administradores pueden cambiar el estado de las encuestas.');
        }

        $survey->is_active = !$survey->is_active;
        $survey->save();

        $status = $survey->is_active ? 'habilitada' : 'inhabilitada';

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_email' => Auth::user()->email,
            'action' => 'toggle_status',
            'description' => "Cambió estado de encuesta '{$survey->title}' a {$status}",
            'type' => 'survey',
            'ip_address' => $request->ip(),
            'details' => ['survey_id' => $survey->id, 'new_status' => $status]
        ]);

        return back()->with('success', "Encuesta {$status} correctamente.");    
    }

    public function duplicate(Request $request, Survey $survey)
    {
        $copy = $survey->replicate();
        $copy->title = $survey->title . ' (copia)';
        $copy->approval_status = 'pending';
        $copy->approval_comment = null;
        $copy->approved_by = null;
        $copy->approved_at = null;
        $copy->is_active = false;
        $copy->created_at = now();
        $copy->updated_at = now();
        $copy->save();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_email' => Auth::user()->email,
            'action' => 'duplicate',
            'description' => 'Duplicó encuesta: ' . $survey->title . ' → ' . $copy->title,
            'type' => 'survey',
            'ip_address' => $request->ip(),
            'details' => [
                'source_survey_id' => $survey->id,
                'new_survey_id' => $copy->id,
            ],
        ]);

        return redirect()->route('surveys.edit', $copy->id)
            ->with('success', 'Encuesta duplicada. Ahora puedes ajustar la copia.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Survey $survey)
    {
        $title = $survey->title;
        $id = $survey->id;
        $survey->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_email' => Auth::user()->email,
            'action' => 'delete',
            'description' => 'Eliminó encuesta: ' . $title,
            'type' => 'survey',
            'ip_address' => $request->ip(),
            'details' => ['survey_id' => $id]
        ]);

        return redirect()->route('surveys.index')->with('success', 'Encuesta eliminada.');
    }

    // --- Métodos Públicos para Responder ---

    public function showPublic($id)
    {
        $survey = Survey::findOrFail($id);
        
        if (!$survey->is_active) {
            return view('surveys.inactive');
        }

        $settings = $survey->settings ?? [];

        $now = now();
        if ($now < $survey->start_date || $now > $survey->end_date) {
            return view('surveys.inactive', ['message' => 'Esta encuesta está fuera del periodo de vigencia.']);
        }

        if (!empty($settings['max_responses'])) {
            $currentCount = $survey->responses()->count();
            if ($currentCount >= (int) $settings['max_responses']) {
                return view('surveys.inactive', ['message' => 'Esta encuesta ya alcanzó el límite máximo de respuestas.']);
            }
        }

        return view('surveys.public.show', compact('survey'));
    }

    public function storeAnswer(Request $request, $id)
    {
        $survey = Survey::findOrFail($id);

        $settings = $survey->settings ?? [];

        $now = now();
        if (!$survey->is_active || $now < $survey->start_date || $now > $survey->end_date) {
            return view('surveys.inactive', ['message' => 'Esta encuesta no está disponible en este momento.']);
        }

        if (!empty($settings['max_responses'])) {
            $currentCount = $survey->responses()->count();
            if ($currentCount >= (int) $settings['max_responses']) {
                return view('surveys.inactive', ['message' => 'Esta encuesta ya alcanzó el límite máximo de respuestas.']);
            }
        }

        if (!empty($settings['one_response_per_ip'])) {
            $alreadyAnswered = $survey->responses()
                ->where('ip_address', $request->ip())
                ->exists();

            if ($alreadyAnswered) {
                return view('surveys.inactive', ['message' => 'Ya has respondido esta encuesta.']);
            }
        }

        // Validación básica (se podría extender según questions required)
        // Por simplicidad en este MVP, validamos que lleguen 'answers'
        $request->validate([
            'answers' => 'required|array'
        ]);

        // Aquí se podría añadir validación detallada iterando sobre $survey->questions
        // y comprobando si las 'required' están presentes en $request->answers

        $response = new SurveyResponse();
        $response->survey_id = $survey->id;
        $response->answers = $request->input('answers');
        $response->ip_address = $request->ip();
        $response->user_agent = $request->userAgent();
        
        // Si no es anónima y el usuario está logueado (opcional)
        // O si se piden nombres/emails en settings, se podrían guardar aparte
        
        $response->save();

        $owner = $survey->user_id ? User::find($survey->user_id) : null;
        if ($owner) {
            Notification::create([
                'user_id' => $owner->id,
                'role' => $owner->role,
                'title' => 'Nueva respuesta recibida',
                'message' => 'La encuesta "' . $survey->title . '" recibió una nueva respuesta.',
                'type' => 'response_received',
                'data' => [
                    'survey_id' => (string) $survey->id,
                    'response_id' => (string) $response->id,
                ],
            ]);
        }

        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'role' => 'admin',
                'title' => 'Nueva respuesta en encuesta',
                'message' => 'La encuesta "' . $survey->title . '" recibió una nueva respuesta.',
                'type' => 'response_received_admin',
                'data' => [
                    'survey_id' => (string) $survey->id,
                    'response_id' => (string) $response->id,
                ],
            ]);
        }

        return redirect()->route('surveys.thank-you', $survey->id);
    }

    public function thankYou($id)
    {
        $survey = Survey::findOrFail($id);
        return view('surveys.thank-you', compact('survey'));
    }
}
