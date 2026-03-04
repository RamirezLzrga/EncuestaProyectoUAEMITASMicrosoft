<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use App\Models\Survey;
use App\Models\User;

class Notification extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'notifications';

    protected $fillable = [
        'user_id',
        'role',
        'title',
        'message',
        'type',
        'data',
        'read_at',
    ];

    protected $casts = [
        'data' => 'array',
        'read_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getUrlAttribute()
    {
        $data = $this->data ?? [];
        $surveyId = $data['survey_id'] ?? null;

        try {
            switch ($this->type) {
                case 'survey_created':
                case 'survey_updated':
                case 'editor_survey_created':
                case 'editor_survey_updated':
                case 'editor_survey_config_updated':
                    return route('admin.aprobaciones');

                case 'survey_approved':
                case 'survey_rejected':
                    return $surveyId ? route('surveys.show', $surveyId) : route('surveys.index');

                case 'survey_expiring':
                case 'survey_expiring_admin':
                    return $surveyId ? route('surveys.edit', $surveyId) : route('surveys.index');

                case 'response_received':
                case 'response_received_admin':
                    return $surveyId ? route('editor.encuestas.respuestas', $surveyId) : route('dashboard');

                case 'survey_approved_admin':
                case 'survey_rejected_admin':
                    return route('admin.aprobaciones');

                default:
                    return route('dashboard');
            }
        } catch (\Throwable $e) {
            return url()->previous() ?: route('dashboard');
        }
    }

    public static function notifyExpiringSurveys($daysAhead = 3)
    {
        $now = now();
        $limitDate = $now->copy()->addDays($daysAhead)->endOfDay();

        $surveys = Survey::where('is_active', true)
            ->where('end_date', '>=', $now)
            ->where('end_date', '<=', $limitDate)
            ->get();

        foreach ($surveys as $survey) {
            $existing = self::where('type', 'survey_expiring')
                ->where('data->survey_id', (string) $survey->id)
                ->first();

            if ($existing) {
                continue;
            }

            $owner = $survey->user_id ? User::find($survey->user_id) : null;

            if ($owner) {
                self::create([
                    'user_id' => $owner->id,
                    'role' => $owner->role,
                    'title' => 'Encuesta próxima a vencer',
                    'message' => 'Tu encuesta "' . $survey->title . '" vence el ' . $survey->end_date->format('d/m/Y') . '.',
                    'type' => 'survey_expiring',
                    'data' => [
                        'survey_id' => (string) $survey->id,
                        'end_date' => $survey->end_date->toDateTimeString(),
                    ],
                ]);
            }

            $admins = User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                self::create([
                    'user_id' => $admin->id,
                    'role' => 'admin',
                    'title' => 'Encuesta próxima a vencer',
                    'message' => 'La encuesta "' . $survey->title . '" vence el ' . $survey->end_date->format('d/m/Y') . '.',
                    'type' => 'survey_expiring_admin',
                    'data' => [
                        'survey_id' => (string) $survey->id,
                        'end_date' => $survey->end_date->toDateTimeString(),
                    ],
                ]);
            }
        }
    }
}
