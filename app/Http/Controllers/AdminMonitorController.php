<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActivityLog;
use App\Models\User;
use Carbon\Carbon;

class AdminMonitorController extends Controller
{
    public function index()
    {
        $onlineSince = Carbon::now()->subMinutes(10);

        $recentLogs = ActivityLog::where('created_at', '>=', $onlineSince)
            ->orderBy('created_at', 'desc')
            ->get();

        $usersOnline = $recentLogs
            ->groupBy('user_id')
            ->take(20)
            ->map(function ($logs) {
                $log = $logs->first();
                $user = $log->user;

                return [
                    'name' => $user ? $user->name : ($log->user_email ?? 'Usuario'),
                    'role' => $user ? ($user->role ?? 'user') : 'user',
                    'location' => $log->ip_address ? 'IP: '.$log->ip_address : 'Sin IP registrada',
                ];
            })
            ->values()
            ->toArray();

        $recentActivityLogs = ActivityLog::orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        $recentActivity = $recentActivityLogs->map(function ($log) {
            return [
                'description' => $log->description,
                'time' => $log->created_at,
            ];
        })->toArray();

        $timelineSince = Carbon::now()->subHours(12);
        $timelineLogs = ActivityLog::where('created_at', '>=', $timelineSince)->get();

        $groupedByHour = $timelineLogs->groupBy(function ($log) {
            return $log->created_at->format('H:00');
        });

        $activityTimeline = [];
        for ($i = 11; $i >= 0; $i--) {
            $hour = Carbon::now()->subHours($i)->format('H:00');
            $activityTimeline[] = [
                'hour' => $hour,
                'count' => isset($groupedByHour[$hour]) ? $groupedByHour[$hour]->count() : 0,
            ];
        }

        $heatmapLogs = ActivityLog::whereNotNull('ip_address')
            ->orderBy('created_at', 'desc')
            ->limit(200)
            ->get();

        $heatmap = $heatmapLogs
            ->groupBy('ip_address')
            ->map(function ($logs, $ip) {
                return [
                    'location' => $ip,
                    'count' => $logs->count(),
                ];
            })
            ->values()
            ->take(9)
            ->toArray();

        return view('admin.monitor', [
            'usersOnline' => $usersOnline,
            'recentActivity' => $recentActivity,
            'activityTimeline' => $activityTimeline,
            'heatmap' => $heatmap,
        ]);
    }
}
