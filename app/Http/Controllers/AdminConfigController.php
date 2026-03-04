<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SystemConfig;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class AdminConfigController extends Controller
{
    public function index()
    {
        $stored = SystemConfig::first();

        $generalDefaults = [
            'organization_name' => 'UAEMex - Sistema de Encuestas',
            'logo_url' => null,
            'primary_color' => '#0d5c41',
            'secondary_color' => '#d4af37',
            'default_language' => 'es',
            'dark_mode' => false,
            'homepage' => 'dashboard',
            'show_help_tips' => true,
        ];

        $securityDefaults = [
            'password_policy' => 'Mínimo 8 caracteres, con mayúsculas, minúsculas y números.',
            'session_time' => config('session.lifetime', 120),
            'two_factor_enabled' => false,
            'max_login_attempts' => 5,
            'password_expiration_days' => 365,
        ];

        $general = $stored ? array_merge($generalDefaults, $stored->general ?? []) : $generalDefaults;
        $security = $stored ? array_merge($securityDefaults, $stored->security ?? []) : $securityDefaults;

        return view('admin.configuracion', [
            'general' => $general,
            'security' => $security,
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'general.organization_name' => 'required|string|max:255',
            'general.default_language' => 'required|string|max:5',
            'security.session_time' => 'required|integer|min:1',
            'security.max_login_attempts' => 'nullable|integer|min:1',
            'security.password_expiration_days' => 'nullable|integer|min:1',
        ]);

        $config = SystemConfig::first() ?: new SystemConfig();

        $general = $request->input('general', []);
        $security = $request->input('security', []);

        $general['dark_mode'] = $request->has('general.dark_mode');
        $general['show_help_tips'] = $request->has('general.show_help_tips');

        $security['two_factor_enabled'] = $request->has('security.two_factor_enabled');

        $config->general = $general;
        $config->security = $security;
        $config->save();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_email' => Auth::user()->email,
            'action' => 'update_config',
            'description' => 'Actualizó la configuración del sistema',
            'type' => 'config',
            'ip_address' => $request->ip(),
            'details' => [],
        ]);

        return redirect()->route('admin.configuracion')->with('success', 'Configuración actualizada correctamente.');
    }
}
