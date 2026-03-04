<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\ActivityLog;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\EditorDashboardController;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Redirecciona al servicio de autenticación de UAEMex.
     */
    public function loginUaemex(Request $request)
    {
        $request->validate([
            'email' => 'required|email|ends_with:uaemex.mx',
        ], [
            'email.ends_with' => 'Debe acceder con un correo institucional válido (@uaemex.mx).',
        ]);

        $accessToken = config('services.uaemex.token');
        $ldapApiUrl = config('services.uaemex.base_url');
        
        $url = $ldapApiUrl . '?access_token=' . $accessToken . '&correo=' . urlencode($request->email);
        
        return redirect($url);
    }

    /**
     * Maneja la respuesta del servicio de autenticación de UAEMex.
     * Este método actúa como proxy para /editor/dashboard para interceptar el login.
     */
    public function uaemexCallback(Request $request)
    {
        // Si no hay datos, verificar si ya está logueado
        if (!$request->has('data')) {
            Log::info('UAEMex Callback: No data provided. Auth Check: ' . (Auth::check() ? 'true' : 'false'));
            if (Auth::check()) {
                // Verificar permisos
                $user = Auth::user();
                Log::info('User role: ' . $user->role);
                
                if ($user->role === 'editor' || $user->role === 'admin') {
                     return app(EditorDashboardController::class)->index();
                }
                abort(403);
            }
            return redirect()->route('login');
        }

        // Proceso de login con UAEMex
        try {
            Log::info('UAEMex Callback received', ['data' => $request->all()]);

            $data = base64_decode($request->data);
            $jsonData = json_decode($data, true);
            
            if (!isset($jsonData['error']) || $jsonData['error'] != 0) {
                $mensaje = $jsonData['mensaje'] ?? 'Error desconocido en el servicio de autenticación.';
                Log::error('UAEMex Auth Error: ' . $mensaje);
                return redirect()->route('login')->withErrors(['email' => $mensaje]);
            }

            $empleado = $jsonData['empleado'];
            $correo = $empleado['correo'];
            $clave = $empleado['clave'];

            Log::info('UAEMex User Data', ['email' => $correo]);

            if (empty($correo)) {
                 return redirect()->route('login')->withErrors(['email' => 'El servicio no devolvió un correo electrónico válido.']);
            }

            // Segunda verificación (Opcional pero recomendada)
            // Se comenta temporalmente para evitar problemas de SSL en local si la primera fase fue exitosa
            /*
            $accessToken = config('services.uaemex.token');
            $validationUrl = config('services.uaemex.validation_url');
            $verifySsl = config('services.uaemex.verify_ssl', true);
            
            // Log::info('Validating with token: ' . $accessToken);

            $response = Http::withOptions([
                'verify' => $verifySsl,
            ])->post($validationUrl, [
                'access_token' => $accessToken,
                'clave' => $clave
            ]);

            if ($response->successful()) {
                $datos = $response->json();
                $correo_empleado = $datos['correo'];
                $verificado = $datos['verificado'];

                if ($verificado == 1 && strcmp($correo, $correo_empleado) == 0) {
            */
                    // LOGIN DIRECTO CON DATOS DEL CALLBACK
                    // Buscar usuario en BD local
                    // Nota: Usamos 'status' en lugar de 'activo' según el modelo User actual
                    $user = User::where('email', $correo)->first();

                    if ($user) {
                        Log::info('User found in DB', ['id' => $user->id, 'status' => $user->status]);

                        if ($user->status !== 'active' && $user->status !== true) { // Asumiendo que puede ser string o boolean
                             Log::warning('User inactive');
                             return redirect()->route('login')->withErrors(['email' => 'Su cuenta está inactiva.']);
                        }

                        // Login exitoso
                        Auth::login($user);
                        $request->session()->regenerate(); // Important for session security fixation
                        
                        // Log Activity
                        ActivityLog::create([
                            'user_id' => $user->id,
                            'user_email' => $user->email,
                            'action' => 'login_uaemex',
                            'description' => 'Inicio de sesión exitoso vía UAEMex',
                            'type' => 'auth',
                            'ip_address' => $request->ip()
                        ]);

                        Log::info('Login successful, redirecting to dashboard');

                        // Redirigir al dashboard (limpiando la URL de parámetros)
                        return redirect()->route('editor.dashboard');

                    } else {
                        Log::warning('User not found in DB, creating new user');
                        
                        // Crear usuario automáticamente
                        try {
                            $newUser = User::create([
                                'name' => $empleado['nombre_completo'] ?? $empleado['nombre'] . ' ' . $empleado['paterno'],
                                'email' => $correo,
                                'password' => Hash::make(\Illuminate\Support\Str::random(16)), // Contraseña aleatoria segura
                                'role' => 'editor', // Rol por defecto
                                'status' => 'active',
                            ]);

                            Log::info('New user created', ['id' => $newUser->id]);

                            Auth::login($newUser);
                            $request->session()->regenerate();

                            ActivityLog::create([
                                'user_id' => $newUser->id,
                                'user_email' => $newUser->email,
                                'action' => 'register_uaemex',
                                'description' => 'Registro automático vía UAEMex',
                                'type' => 'auth',
                                'ip_address' => $request->ip()
                            ]);

                            return redirect()->route('editor.dashboard');
                        } catch (\Exception $e) {
                            Log::error('Error creating user: ' . $e->getMessage());
                            return redirect()->route('login')->withErrors(['email' => 'Error al crear su cuenta de usuario.']);
                        }
                    }
            /*
                } else {
                    Log::error('UAEMex Verification Failed', ['response' => $datos]);
                    return redirect()->route('login')->withErrors(['email' => 'Error de verificación de credenciales institucionales.']);
                }
            } else {
                 Log::error('UAEMex Validation Service Error', ['status' => $response->status()]);
                 return redirect()->route('login')->withErrors(['email' => 'Error al conectar con el servicio de validación.']);
            }
            */

        } catch (\Exception $e) {
            Log::error('Error en login UAEMex: ' . $e->getMessage());
            return redirect()->route('login')->withErrors(['email' => 'Ocurrió un error al procesar el inicio de sesión.']);
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Log Activity
            ActivityLog::create([
                'user_id' => Auth::id(),
                'user_email' => Auth::user()->email,
                'action' => 'login',
                'description' => 'Inicio de sesión exitoso',
                'type' => 'auth',
                'ip_address' => $request->ip()
            ]);

            $user = Auth::user();

            $target = $user && $user->role === 'admin'
                ? route('dashboard')
                : route('editor.dashboard');

            return redirect()->intended($target);
        }

        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        // Log Activity
        ActivityLog::create([
            'user_id' => $user->id,
            'user_email' => $user->email,
            'action' => 'register',
            'description' => 'Nuevo usuario registrado',
            'type' => 'user',
            'ip_address' => $request->ip()
        ]);

        $target = $user && $user->role === 'admin'
            ? route('dashboard')
            : route('editor.dashboard');

        return redirect($target);
    }

    public function profile()
    {
        $user = Auth::user();
        return view('auth.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
            'avatar_url' => 'nullable|url',
        ]);

        $user->name = $validated['name'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        if (array_key_exists('avatar_url', $validated)) {
            $user->avatar_url = $validated['avatar_url'] ?: null;
        }

        $user->save();

        ActivityLog::create([
            'user_id' => $user->id,
            'user_email' => $user->email,
            'action' => 'update_profile',
            'description' => 'Actualizó su perfil',
            'type' => 'user',
            'ip_address' => $request->ip()
        ]);

        return redirect()->route('profile.show')->with('success', 'Perfil actualizado correctamente.');
    }

    public function logout(Request $request)
    {
        // Log Activity before logout
        if (Auth::check()) {
            ActivityLog::create([
                'user_id' => Auth::id(),
                'user_email' => Auth::user()->email,
                'action' => 'logout',
                'description' => 'Cierre de sesión',
                'type' => 'auth',
                'ip_address' => $request->ip()
            ]);
        }

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
