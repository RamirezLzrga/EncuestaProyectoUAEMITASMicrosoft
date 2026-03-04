<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\SurveyResponse;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class EditorDashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $surveys = Survey::where('user_id', $userId)->get();
        $totalSurveys = $surveys->count();
        $activeSurveys = $surveys->where('is_active', true)->count();
        $inactiveSurveys = $totalSurveys - $activeSurveys;

        $totalResponses = 0;
        foreach ($surveys as $survey) {
            $totalResponses += $survey->responses()->count();
        }

        $avgResponses = $totalSurveys > 0 ? round($totalResponses / max($totalSurveys, 1), 1) : 0;
        $completionRate = $totalSurveys > 0 ? round(($activeSurveys / max($totalSurveys, 1)) * 100) : 0;

        $recentSurveys = Survey::where('user_id', $userId)
            ->orderBy('updated_at', 'desc')
            ->take(3)
            ->get();

        $surveyIds = $surveys->pluck('id')->all();
        $days = 30;
        $startDate = Carbon::now()->subDays($days - 1)->startOfDay();
        $endDate = Carbon::now()->endOfDay();

        $labels = [];
        $data = [];
        $surveysPerDay = [];

        if (!empty($surveyIds)) {
            $responses = SurveyResponse::with('survey:id,title')
                ->whereIn('survey_id', $surveyIds)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->get();

            $responseSummary = [];

            foreach ($responses as $response) {
                $dayKey = $response->created_at->copy()->startOfDay()->format('Y-m-d');

                if (!isset($responseSummary[$dayKey])) {
                    $responseSummary[$dayKey] = [
                        'total' => 0,
                        'surveys' => [],
                    ];
                }

                $responseSummary[$dayKey]['total']++;

                $surveyId = $response->survey_id;
                $title = optional($response->survey)->title ?: 'Encuesta sin título';

                if (!isset($responseSummary[$dayKey]['surveys'][$surveyId])) {
                    $responseSummary[$dayKey]['surveys'][$surveyId] = [
                        'title' => $title,
                        'count' => 0,
                    ];
                }

                $responseSummary[$dayKey]['surveys'][$surveyId]['count']++;
            }

            for ($i = 0; $i < $days; $i++) {
                $currentDate = (clone $startDate)->addDays($i);
                $dateKey = $currentDate->format('Y-m-d');
                $labels[] = $currentDate->format('d/m');

                if (isset($responseSummary[$dateKey])) {
                    $data[] = $responseSummary[$dateKey]['total'];
                    $surveysPerDay[] = array_values($responseSummary[$dateKey]['surveys']);
                } else {
                    $data[] = 0;
                    $surveysPerDay[] = [];
                }
            }
        } else {
            for ($i = 0; $i < $days; $i++) {
                $currentDate = (clone $startDate)->addDays($i);
                $labels[] = $currentDate->format('d/m');
                $data[] = 0;
                $surveysPerDay[] = [];
            }
        }

        $performanceChart = [
            'labels' => $labels,
            'data' => $data,
            'surveys' => $surveysPerDay,
        ];

        $hasPerformanceData = array_sum($data) > 0;

        return view('editor.dashboard', compact(
            'totalSurveys',
            'activeSurveys',
            'inactiveSurveys',
            'totalResponses',
            'avgResponses',
            'completionRate',
            'recentSurveys',
            'performanceChart',
            'hasPerformanceData'
        ));
    }
}
