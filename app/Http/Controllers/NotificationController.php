<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function unread()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'count' => 0,
                'items' => [],
            ]);
        }

        $notifications = Notification::where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->orWhere(function ($q) use ($user) {
                        $q->whereNull('user_id')
                            ->where('role', $user->role);
                    });
            })
            ->whereNull('read_at')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return response()->json([
            'count' => $notifications->count(),
            'items' => $notifications->map(function ($n) {
                return [
                    'id' => (string) $n->id,
                    'title' => $n->title,
                    'message' => $n->message,
                    'type' => $n->type,
                    'url' => $n->url,
                    'created_at' => optional($n->created_at)->diffForHumans(),
                ];
            }),
        ]);
    }

    public function markAllRead()
    {
        $user = Auth::user();

        if ($user) {
            Notification::where(function ($query) use ($user) {
                    $query->where('user_id', $user->id)
                        ->orWhere(function ($q) use ($user) {
                            $q->whereNull('user_id')
                                ->where('role', $user->role);
                        });
                })
                ->whereNull('read_at')
                ->update(['read_at' => now()]);
        }

        return response()->json(['status' => 'ok']);
    }
}
