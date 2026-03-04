<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Survey;
use App\Models\SurveyResponse;
use Carbon\Carbon;

class AdminReportController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->get('period', 'mes');

        $availableMetrics = [
            'tasa_respuesta' => 'Tasa de respuesta',
            'satisfaccion_promedio' => 'Satisfacción promedio',
            'encuestas_enviadas' => 'Encuestas enviadas',
            'encuestas_completadas' => 'Encuestas completadas',
        ];

        $from = null;
        $to = Carbon::now();

        if ($period === 'hoy') {
            $from = Carbon::today();
        } elseif ($period === 'semana') {
            $from = Carbon::now()->subWeek();
        } elseif ($period === 'mes') {
            $from = Carbon::now()->subMonth();
        } elseif ($period === 'año') {
            $from = Carbon::now()->subYear();
        } else {
            $from = Carbon::now()->subMonth();
        }

        $responsesQuery = SurveyResponse::whereBetween('created_at', [$from, $to]);
        $surveysQuery = Survey::whereBetween('created_at', [$from, $to]);

        $encuestasEnviadas = $surveysQuery->count();
        $encuestasCompletadas = $responsesQuery->count();

        $tasaRespuesta = $encuestasEnviadas > 0
            ? round(($encuestasCompletadas / $encuestasEnviadas) * 100, 1)
            : 0;

        $allResponses = $responsesQuery->get();
        $totalScore = 0;
        $scoreCount = 0;

        foreach ($allResponses as $resp) {
            $answers = $resp->answers ?? [];
            foreach ($answers as $value) {
                if (is_array($value)) {
                    foreach ($value as $v) {
                        if (is_numeric($v)) {
                            $totalScore += $v;
                            $scoreCount++;
                        }
                    }
                } else {
                    if (is_numeric($value)) {
                        $totalScore += $value;
                        $scoreCount++;
                    }
                }
            }
        }

        $satisfaccionPromedio = $scoreCount > 0 ? round($totalScore / $scoreCount, 1) : null;

        $preview = [
            'period' => $period,
            'summary' => [
                'encuestas_enviadas' => $encuestasEnviadas,
                'encuestas_completadas' => $encuestasCompletadas,
                'tasa_respuesta' => $tasaRespuesta,
                'satisfaccion_promedio' => $satisfaccionPromedio ?? 0,
            ],
        ];

        $history = [];

        return view('admin.reportes', [
            'availableMetrics' => $availableMetrics,
            'preview' => $preview,
            'history' => $history,
            'period' => $period,
        ]);
    }
}
