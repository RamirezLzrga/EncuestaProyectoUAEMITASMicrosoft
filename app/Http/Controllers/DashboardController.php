<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\SurveyResponse;
use App\Models\Notification;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user && $user->role !== 'admin') {
            return redirect()->route('editor.dashboard');
        }

        Notification::notifyExpiringSurveys(3);

        // Métricas generales globales (todas las encuestas del sistema)
        $surveys = Survey::all();
        $totalSurveys = $surveys->count();
        $activeSurveys = $surveys->where('is_active', true)->count();
        $inactiveSurveys = $totalSurveys - $activeSurveys;

        // Respuestas globales
        $totalResponses = SurveyResponse::count();
        $completedResponses = SurveyResponse::where('is_complete', true)->count();

        // Tasa de respuesta promedio (Respuestas / Encuestas que tienen al menos 1 respuesta)
        // Como no tenemos "total de envíos esperados", usaremos un cálculo simple o placeholder dinámico
        // Para este dashboard, calcularemos el promedio de respuestas por encuesta
        $avgResponses = $totalSurveys > 0 ? round($totalResponses / $totalSurveys, 1) : 0;

        // Tasa de completado global
        $completionRate = $totalResponses > 0
            ? round(($completedResponses / $totalResponses) * 100, 1)
            : 0;

        // Encuestas recientes (últimas creadas en el sistema)
        $recentSurveys = Survey::orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        // Datos para Gráfica de Barras (Top 5 encuestas con más respuestas)
        // Procesamiento en memoria para evitar problemas con Mongo aggregation en Eloquent básico
        $surveysWithResponses = $surveys->map(function ($survey) {
            return [
                'title' => $survey->title,
                'responses_count' => $survey->responses()->count()
            ];
        })->sortByDesc('responses_count')->take(5);

        $chartLabels = $surveysWithResponses->pluck('title')->values()->toArray();
        $chartData = $surveysWithResponses->pluck('responses_count')->values()->toArray();

        // Datos para Gráfica de Dona (Estado)
        $doughnutData = [$activeSurveys, $inactiveSurveys];

        // Usuarios activos
        $activeUsers = User::where('status', 'active')->count();

        // Encuestas pendientes de aprobación
        $pendingApprovals = Survey::where('approval_status', 'pending')->count();

        // Actividad del sistema (últimos 30 días)
        $periodDays = 30;
        $periodLabel = 'últimos 30 días';
        $periodEnd = Carbon::now();
        $periodStart = $periodEnd->copy()->subDays($periodDays - 1)->startOfDay();

        $periodSurveys = Survey::whereBetween('created_at', [$periodStart, $periodEnd])->get();
        $periodResponses = SurveyResponse::whereBetween('created_at', [$periodStart, $periodEnd])->get();

        $surveysByDate = $periodSurveys->groupBy(function ($survey) {
            return $survey->created_at->toDateString();
        });

        $responsesByDate = $periodResponses->groupBy(function ($response) {
            return $response->created_at->toDateString();
        });

        $activityByDay = [];
        foreach (range(0, $periodDays - 1) as $index) {
            $date = $periodStart->copy()->addDays($index);
            $key = $date->toDateString();
            $surveysCount = isset($surveysByDate[$key]) ? $surveysByDate[$key]->count() : 0;
            $responsesCount = isset($responsesByDate[$key]) ? $responsesByDate[$key]->count() : 0;

            $activityByDay[] = [
                'label' => $date->format('d M'),
                'surveys' => $surveysCount,
                'responses' => $responsesCount,
            ];
        }

        $topDay = collect($activityByDay)
            ->sortByDesc(function ($day) {
                return $day['responses'];
            })
            ->first();

        $systemActivity = [
            'period_label' => $periodLabel,
            'new_surveys' => $periodSurveys->count(),
            'new_responses' => $periodResponses->count(),
            'top_day' => $topDay,
        ];

        // Actividad reciente
        $recentActivity = [];

        if ($user) {
            $recentActivity[] = [
                'icon' => '🔐',
                'icon_class' => 'auth',
                'title' => 'Inicio de sesión de administrador',
                'description' => $user->name,
                'time' => 'Ahora',
            ];
        }

        $latestSurvey = Survey::orderBy('created_at', 'desc')->first();
        if ($latestSurvey) {
            $recentActivity[] = [
                'icon' => '📋',
                'icon_class' => 'survey',
                'title' => 'Nueva encuesta creada',
                'description' => $latestSurvey->title . ($latestSurvey->user ? ' • Por ' . $latestSurvey->user->name : ''),
                'time' => $latestSurvey->created_at->diffForHumans(),
            ];
        }

        $latestUser = User::orderBy('created_at', 'desc')->first();
        if ($latestUser) {
            $recentActivity[] = [
                'icon' => '👤',
                'icon_class' => 'user',
                'title' => 'Nuevo usuario registrado',
                'description' => $latestUser->name . ' • Rol: ' . $latestUser->role,
                'time' => $latestUser->created_at->diffForHumans(),
            ];
        }

        $responsesLast24h = SurveyResponse::where('created_at', '>=', Carbon::now()->subDay())->count();
        if ($responsesLast24h > 0) {
            $recentActivity[] = [
                'icon' => '✅',
                'icon_class' => 'approval',
                'title' => 'Nuevas respuestas registradas',
                'description' => $responsesLast24h . ' respuesta' . ($responsesLast24h === 1 ? '' : 's') . ' en las últimas 24 horas',
                'time' => 'Últimas 24 horas',
            ];
        }

        return view('admin.dashboard', compact(
            'totalSurveys',
            'activeSurveys',
            'inactiveSurveys',
            'totalResponses',
            'avgResponses',
            'completionRate',
            'activeUsers',
            'recentSurveys',
            'chartLabels',
            'chartData',
            'doughnutData',
            'pendingApprovals',
            'systemActivity',
            'recentActivity'
        ));
    }
}
