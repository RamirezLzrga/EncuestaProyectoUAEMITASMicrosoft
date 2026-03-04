<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\SurveyResponse;
use App\Models\User;
use App\Models\Notification;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EditorSurveyController extends Controller
{
    public function templates()
    {
        $templates = $this->getTemplates();

        $categories = [
            'encuesta' => 'Encuesta',
            'cuestionario' => 'Cuestionario',
            'invitacion' => 'Invitación',
            'registro' => 'Registro',
        ];

        return view('editor.encuestas.plantillas', [
            'templates' => $templates,
            'categories' => $categories,
        ]);
    }

    public function builderNew(Request $request)
    {
        $templateKey = $request->query('template');
        $templates = $this->getTemplates();
        $template = $templateKey && isset($templates[$templateKey]) ? $templates[$templateKey] : null;

        $surveyData = [
            'title' => $template['title'] ?? '',
            'description' => $template['description'] ?? '',
            'year' => date('Y'),
            'start_date' => now(),
            'end_date' => now()->addMonth(),
            'settings' => [],
            'questions' => $template['questions'] ?? [],
        ];

        $survey = new Survey($surveyData);

        return view('editor.encuestas.builder', [
            'survey' => $survey,
            'mode' => 'create',
        ]);
    }

    public function builderEdit(Survey $survey)
    {
        if ($survey->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }

        return view('editor.encuestas.builder', [
            'survey' => $survey,
            'mode' => 'edit',
        ]);
    }

    public function builderStore(Request $request)
    {
        $survey = $this->saveSurveyFromBuilder($request, new Survey());

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_email' => Auth::user()->email,
            'action' => 'create',
            'description' => 'Editor creó encuesta: ' . $survey->title,
            'type' => 'survey',
            'ip_address' => $request->ip(),
            'details' => [
                'survey_id' => $survey->id,
                'origin' => 'editor',
            ],
        ]);

        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'role' => 'admin',
                'title' => 'Nueva encuesta creada en editor',
                'message' => Auth::user()->name . ' creó la encuesta "' . $survey->title . '" desde el editor.',
                'type' => 'editor_survey_created',
                'data' => [
                    'survey_id' => (string) $survey->id,
                    'creator_id' => (string) Auth::id(),
                ],
            ]);
        }

        return redirect()->route('editor.encuestas.configuracion', $survey)->with('success', 'Encuesta creada. Configura los detalles generales.');
    }

    public function builderUpdate(Request $request, Survey $survey)
    {
        if ($survey->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $this->saveSurveyFromBuilder($request, $survey);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_email' => Auth::user()->email,
            'action' => 'update',
            'description' => 'Editor actualizó encuesta: ' . $survey->title,
            'type' => 'survey',
            'ip_address' => $request->ip(),
            'details' => [
                'survey_id' => $survey->id,
                'origin' => 'editor',
            ],
        ]);

        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'role' => 'admin',
                'title' => 'Encuesta modificada en editor',
                'message' => Auth::user()->name . ' modificó la encuesta "' . $survey->title . '" desde el editor.',
                'type' => 'editor_survey_updated',
                'data' => [
                    'survey_id' => (string) $survey->id,
                    'editor_id' => (string) Auth::id(),
                ],
            ]);
        }

        return redirect()->route('editor.encuestas.configuracion', $survey)->with('success', 'Encuesta actualizada.');
    }

    protected function saveSurveyFromBuilder(Request $request, Survey $survey)
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

        $questions = array_values($validated['questions']);
        foreach ($questions as &$question) {
            $question['required'] = isset($question['required']);
        }
        $validated['questions'] = $questions;

        $defaultSettings = [
            'anonymous' => false,
            'collect_names' => false,
            'collect_emails' => false,
            'allow_multiple' => false,
        ];
        $validated['settings'] = array_merge($defaultSettings, $request->input('settings', []));
        foreach ($validated['settings'] as $key => $value) {
            $validated['settings'][$key] = (bool) $value;
        }

        $survey->fill($validated);
        if (!$survey->exists) {
            $survey->user_id = Auth::id();
        }
        $survey->is_active = false;
        $survey->approval_status = 'pending';
        $survey->save();

        return $survey;
    }

    protected function getTemplates(): array
    {
        return [
            'satisfaccion_empleados' => [
                'category' => 'encuesta',
                'icon' => '😊',
                'title' => 'Encuesta de satisfacción de los empleados',
                'description' => 'Mide el clima laboral y la satisfacción del personal.',
                'questions' => [
                    [
                        'text' => '¿Qué tan satisfecho estás con tu ambiente de trabajo?',
                        'type' => 'multiple_choice',
                        'options' => [
                            'Muy satisfecho',
                            'Satisfecho',
                            'Neutral',
                            'Insatisfecho',
                            'Muy insatisfecho',
                        ],
                        'required' => true,
                    ],
                    [
                        'text' => '¿Cómo calificarías la comunicación dentro de tu equipo?',
                        'type' => 'multiple_choice',
                        'options' => [
                            'Excelente',
                            'Buena',
                            'Regular',
                            'Mala',
                        ],
                        'required' => true,
                    ],
                    [
                        'text' => 'Menciona una cosa que podríamos mejorar para apoyarte mejor en tu trabajo.',
                        'type' => 'paragraph',
                        'options' => [],
                        'required' => false,
                    ],
                ],
            ],
            'evaluacion_curso' => [
                'category' => 'cuestionario',
                'icon' => '📚',
                'title' => 'Encuesta de evaluación del curso',
                'description' => 'Evalúa la calidad de un curso, taller o capacitación.',
                'questions' => [
                    [
                        'text' => '¿El contenido del curso cumplió con tus expectativas?',
                        'type' => 'multiple_choice',
                        'options' => [
                            'Superó mis expectativas',
                            'Cumplió mis expectativas',
                            'Cumplió parcialmente',
                            'No cumplió mis expectativas',
                        ],
                        'required' => true,
                    ],
                    [
                        'text' => '¿Cómo calificarías al instructor?',
                        'type' => 'multiple_choice',
                        'options' => [
                            'Excelente',
                            'Bueno',
                            'Regular',
                            'Malo',
                        ],
                        'required' => true,
                    ],
                    [
                        'text' => 'Comentarios o sugerencias para mejorar el curso.',
                        'type' => 'paragraph',
                        'options' => [],
                        'required' => false,
                    ],
                ],
            ],
            'invitacion_evento' => [
                'category' => 'invitacion',
                'icon' => '✉️',
                'title' => 'Invitación a evento',
                'description' => 'Confirma asistencia y recopila información básica de invitados.',
                'questions' => [
                    [
                        'text' => '¿Asistirás al evento?',
                        'type' => 'multiple_choice',
                        'options' => [
                            'Sí',
                            'No',
                            'Aún no lo sé',
                        ],
                        'required' => true,
                    ],
                    [
                        'text' => '¿Traerás acompañantes? Indica cuántas personas.',
                        'type' => 'short_text',
                        'options' => [],
                        'required' => false,
                    ],
                    [
                        'text' => 'Indica si tienes necesidades especiales (alergias, accesibilidad, etc.).',
                        'type' => 'paragraph',
                        'options' => [],
                        'required' => false,
                    ],
                ],
            ],
            'registro_participantes' => [
                'category' => 'registro',
                'icon' => '📝',
                'title' => 'Registro de participantes',
                'description' => 'Registra información básica de asistentes a un evento o actividad.',
                'questions' => [
                    [
                        'text' => 'Nombre completo',
                        'type' => 'short_text',
                        'options' => [],
                        'required' => true,
                    ],
                    [
                        'text' => 'Correo electrónico',
                        'type' => 'short_text',
                        'options' => [],
                        'required' => true,
                    ],
                    [
                        'text' => 'Dependencia o área de procedencia',
                        'type' => 'short_text',
                        'options' => [],
                        'required' => false,
                    ],
                ],
            ],
        ];
    }

    public function configuracion(Survey $survey)
    {
        if ($survey->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }

        return view('editor.encuestas.configuracion', [
            'survey' => $survey,
        ]);
    }

    public function configuracionUpdate(Request $request, Survey $survey)
    {
        if ($survey->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'max_responses' => 'nullable|integer|min:1',
            'theme' => 'nullable|string|max:50',
            'logo_url' => 'nullable|string|max:255',
            'thank_you_page' => 'nullable|string',
            'public_link' => 'nullable|string|max:255',
            'password' => 'nullable|string|max:100',
            'one_response_per_ip' => 'nullable|boolean',
            'allow_edit_response' => 'nullable|boolean',
            'show_progress_bar' => 'nullable|boolean',
        ]);

        $settings = $survey->settings ?? [];
        $settings['max_responses'] = $data['max_responses'] ?? null;
        $settings['theme'] = $data['theme'] ?? null;
        $settings['logo_url'] = $data['logo_url'] ?? null;
        $settings['thank_you_page'] = $data['thank_you_page'] ?? null;
        $settings['public_link'] = $data['public_link'] ?? route('surveys.public', $survey->id);
        $settings['password'] = $data['password'] ?? null;
        $settings['one_response_per_ip'] = $request->boolean('one_response_per_ip');
        $settings['allow_edit_response'] = $request->boolean('allow_edit_response');
        $settings['show_progress_bar'] = $request->boolean('show_progress_bar');

        $survey->title = $data['title'];
        $survey->description = $data['description'] ?? null;
        $survey->start_date = $data['start_date'];
        $survey->end_date = $data['end_date'];
        $survey->settings = $settings;
        $survey->save();

        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'role' => 'admin',
                'title' => 'Configuración de encuesta actualizada',
                'message' => Auth::user()->name . ' actualizó la configuración de "' . $survey->title . '".',
                'type' => 'editor_survey_config_updated',
                'data' => [
                    'survey_id' => (string) $survey->id,
                    'editor_id' => (string) Auth::id(),
                ],
            ]);
        }

        return redirect()->route('editor.encuestas.respuestas', $survey)->with('success', 'Configuración guardada.');
    }

    public function respuestas(Survey $survey)
    {
        if ($survey->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $responses = SurveyResponse::where('survey_id', $survey->id)->orderBy('created_at', 'desc')->get();
        $totalResponses = $responses->count();
        $completed = $responses->where('is_complete', true)->count();
        $completionRate = $totalResponses > 0 ? round(($completed / $totalResponses) * 100, 1) : 0;
        $avgTimeSeconds = $totalResponses > 0 ? round($responses->avg('completion_time_seconds')) : null;

        return view('editor.encuestas.respuestas', [
            'survey' => $survey,
            'responses' => $responses,
            'totalResponses' => $totalResponses,
            'completionRate' => $completionRate,
            'avgTimeSeconds' => $avgTimeSeconds,
        ]);
    }

    public function compartir(Survey $survey)
    {
        if ($survey->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $publicLink = route('surveys.public', $survey->id);

        return view('editor.encuestas.compartir', [
            'survey' => $survey,
            'publicLink' => $publicLink,
        ]);
    }
}
