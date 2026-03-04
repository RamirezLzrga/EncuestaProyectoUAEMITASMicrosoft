<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\SurveyResponse;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class StatisticsController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        if ($user && $user->role !== 'admin') {
            $surveys = Survey::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $surveys = Survey::orderBy('created_at', 'desc')->get();
        }

        $selectedSurveyId = $request->input('survey_id');
        $selectedSurvey = null;

        if ($selectedSurveyId) {
            $selectedSurvey = $surveys->find($selectedSurveyId);
        } else {
            $selectedSurvey = $surveys->first();
        }

        $fromDateInput = $request->input('from_date');
        $toDateInput = $request->input('to_date');
        $fromDate = $fromDateInput ? Carbon::parse($fromDateInput)->startOfDay() : null;
        $toDate = $toDateInput ? Carbon::parse($toDateInput)->endOfDay() : null;

        $stats = [
            'total_responses' => 0,
            'completion_rate' => 0,
            'responses_growth' => 0,
            'completion_growth' => 0,
            'responses_per_day' => ['labels' => [], 'data' => []],
            'responses_distribution' => ['labels' => [], 'data' => []],
            'recent_responses' => []
        ];

        if ($selectedSurvey) {
            $baseQuery = $selectedSurvey->responses();

            $totalQuery = clone $baseQuery;
            if ($fromDate) {
                $totalQuery->where('created_at', '>=', $fromDate);
            }
            if ($toDate) {
                $totalQuery->where('created_at', '<=', $toDate);
            }

            $totalResponses = $totalQuery->count();
            $stats['total_responses'] = $totalResponses;

            $stats['completion_rate'] = $totalResponses > 0 ? 100 : 0; 

            if ($fromDate && $toDate) {
                $periodDays = $fromDate->diffInDays($toDate) + 1;

                $lastPeriodResponses = (clone $baseQuery)
                    ->whereBetween('created_at', [$fromDate, $toDate])
                    ->count();

                $prevFrom = $fromDate->copy()->subDays($periodDays);
                $prevTo = $fromDate->copy()->subSecond();

                $prevPeriodResponses = (clone $baseQuery)
                    ->whereBetween('created_at', [$prevFrom, $prevTo])
                    ->count();
            } else {
                $lastMonthResponses = (clone $baseQuery)
                    ->where('created_at', '>=', Carbon::now()->subMonth())
                    ->count();
                $prevMonthResponses = (clone $baseQuery)
                    ->whereBetween('created_at', [Carbon::now()->subMonths(2), Carbon::now()->subMonth()])
                    ->count();

                $prevPeriodResponses = $prevMonthResponses;
                $lastPeriodResponses = $lastMonthResponses;
            }

            if ($prevPeriodResponses > 0) {
                $growth = (($lastPeriodResponses - $prevPeriodResponses) / $prevPeriodResponses) * 100;
                $stats['responses_growth'] = round($growth, 1);
            } else {
                $stats['responses_growth'] = $lastPeriodResponses > 0 ? 100 : 0;
            }

            $evolutionStartDate = $fromDate ? $fromDate->copy() : Carbon::now()->subDays(6);
            $evolutionEndDate = $toDate ? $toDate->copy() : Carbon::now();

            $rawResponses = (clone $baseQuery)
                ->whereBetween('created_at', [$evolutionStartDate, $evolutionEndDate])
                ->get(['created_at']);

            $groupedByDate = $rawResponses->groupBy(function($item) {
                return $item->created_at->format('Y-m-d');
            })->map(function($group) {
                return $group->count();
            });

            $labelsEvolution = [];
            $dataEvolution = [];

            $cursorDate = $evolutionStartDate->copy();
            while ($cursorDate->lte($evolutionEndDate)) {
                $dateKey = $cursorDate->format('Y-m-d');
                $labelsEvolution[] = $cursorDate->format('d M');
                $dataEvolution[] = $groupedByDate->get($dateKey, 0);
                $cursorDate->addDay();
            }

            $stats['responses_per_day'] = [
                'labels' => $labelsEvolution,
                'data' => $dataEvolution
            ];

            $targetQuestion = null;
            $questions = $selectedSurvey->questions ?? [];
            
            foreach ($questions as $q) {
                if (in_array($q['type'], ['multiple_choice', 'checkboxes', 'dropdown'])) {
                    $targetQuestion = $q;
                    break;
                }
            }

            if ($targetQuestion) {
                $qText = $targetQuestion['text'];
                $options = $targetQuestion['options'] ?? [];
                $counts = array_fill_keys($options, 0);

                $distributionQuery = clone $baseQuery;
                if ($fromDate) {
                    $distributionQuery->where('created_at', '>=', $fromDate);
                }
                if ($toDate) {
                    $distributionQuery->where('created_at', '<=', $toDate);
                }

                $allResponses = $distributionQuery->get();
                
                foreach ($allResponses as $resp) {
                    $answers = $resp->answers ?? [];
                    // Buscar la respuesta a esta pregunta
                    // La clave en $answers es el texto de la pregunta (según show.blade.php)
                    if (isset($answers[$qText])) {
                        $val = $answers[$qText];
                        if (is_array($val)) { // Checkboxes
                            foreach ($val as $v) {
                                if (isset($counts[$v])) $counts[$v]++;
                            }
                        } else { // Radio/Select
                            if (isset($counts[$val])) $counts[$val]++;
                        }
                    }
                }

                $stats['responses_distribution'] = [
                    'labels' => array_keys($counts),
                    'data' => array_values($counts)
                ];
            } else {
                // Si no hay preguntas cerradas, mostrar mensaje vacío o contar total
                 $stats['responses_distribution'] = [
                    'labels' => ['Sin preguntas cerradas'],
                    'data' => [0]
                ];
            }

            $recentQuery = clone $baseQuery;
            if ($fromDate) {
                $recentQuery->where('created_at', '>=', $fromDate);
            }
            if ($toDate) {
                $recentQuery->where('created_at', '<=', $toDate);
            }

            $recent = $recentQuery->orderBy('created_at', 'desc')->take(10)->get();
            $formattedRecent = [];
            
            foreach ($recent as $r) {
                // Generar resumen (primeras 3 respuestas)
                $summaryParts = [];
                $answers = $r->answers ?? [];
                $i = 0;
                foreach ($answers as $q => $a) {
                    if ($i >= 3) break;
                    $val = is_array($a) ? implode(', ', $a) : $a;
                    $summaryParts[] = Str::limit($val, 20);
                    $i++;
                }
                
                $formattedRecent[] = [
                    'date' => $r->created_at->format('d/m/Y, h:i a'),
                    'summary' => implode(' | ', $summaryParts)
                ];
            }
            $stats['recent_responses'] = $formattedRecent;
        }

        $view = $user && $user->role === 'admin'
            ? 'statistics.index'
            : 'editor.statistics.index';

        return view($view, compact('surveys', 'selectedSurvey', 'stats'));
    }
}
