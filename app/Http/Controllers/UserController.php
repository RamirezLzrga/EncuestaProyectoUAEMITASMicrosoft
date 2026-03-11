<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Survey;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Filtros
        if ($request->has('search') && ! empty($request->search)) {
            $query->where(function ($q) use ($request) {
                $search = trim((string) $request->search);

                $q->where('name', 'like', '%'.$search.'%')
                    ->orWhere('email', 'like', '%'.$search.'%')
                    ->orWhere('role', 'like', '%'.$search.'%')
                    ->orWhere('status', 'like', '%'.$search.'%');

                $searchLower = mb_strtolower($search);
                if (in_array($searchLower, ['activo', 'activos'], true)) {
                    $q->orWhere('status', 'active');
                } elseif (in_array($searchLower, ['inactivo', 'inactivos'], true)) {
                    $q->orWhere('status', 'inactive');
                }

                if (in_array($searchLower, ['administrador', 'admin', 'admins'], true)) {
                    $q->orWhere('role', 'admin');
                } elseif (in_array($searchLower, ['editor', 'editores'], true)) {
                    $q->orWhere('role', 'editor');
                } elseif (in_array($searchLower, ['viewer', 'vista', 'solo vista'], true)) {
                    $q->orWhere('role', 'viewer');
                }
            });
        }

        if ($request->has('role') && $request->role != 'Todos') {
            $query->where('role', $request->role);
        }

        if ($request->has('status') && $request->status != 'Todos') {
            $query->where('status', $request->status);
        }

        $users = $query->paginate(10);

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateOnly = $request->expectsJson() && $request->boolean('validate_only');

        $rules = [
            'name' => 'required|string|max:255|unique:users,name',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,editor',
            'status' => 'required|in:active,inactive',
        ];

        if ($request->expectsJson() && ! $validateOnly) {
            $rules['admin_password'] = 'required|string';
        }

        $validated = $request->validate(
            $rules,
            [
                'name.required' => 'El nombre es obligatorio.',
                'name.string' => 'El nombre no es válido.',
                'name.max' => 'El nombre no debe exceder 255 caracteres.',
                'name.unique' => 'Este usuario ya existe.',

                'email.required' => 'El correo es obligatorio.',
                'email.email' => 'El correo no tiene un formato válido.',
                'email.max' => 'El correo no debe exceder 255 caracteres.',
                'email.unique' => 'Este usuario ya existe.',

                'password.required' => 'La contraseña es obligatoria.',
                'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
                'password.confirmed' => 'Las contraseñas no coinciden.',

                'role.required' => 'El rol es obligatorio.',
                'role.in' => 'El rol seleccionado no es válido.',

                'status.required' => 'El estado es obligatorio.',
                'status.in' => 'El estado seleccionado no es válido.',

                'admin_password.required' => 'La contraseña es obligatoria.',
            ],
            [
                'name' => 'nombre',
                'email' => 'correo',
                'password' => 'contraseña',
                'password_confirmation' => 'confirmación de contraseña',
                'admin_password' => 'contraseña',
            ]
        );

        if ($validateOnly) {
            return response()->json(['ok' => true]);
        }

        if ($request->expectsJson()) {
            if (! Hash::check((string) $request->input('admin_password'), (string) Auth::user()->password)) {
                throw ValidationException::withMessages([
                    'admin_password' => ['Contraseña incorrecta.'],
                ]);
            }
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'status' => $validated['status'],
        ]);

        // Log Activity
        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_email' => Auth::user()->email,
            'action' => 'create',
            'description' => 'Creó usuario: '.$user->name,
            'type' => 'user',
            'ip_address' => $request->ip(),
            'details' => ['user_id' => $user->id],
        ]);

        if ($request->expectsJson()) {
            return response()->json(['ok' => true]);
        }

        return redirect()->route('users.index')->with('success', 'Usuario creado exitosamente.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);

        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $validateOnly = $request->expectsJson() && $request->boolean('validate_only');

        $rules = [
            'name' => 'required|string|max:255|unique:users,name,'.$id,
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|string|in:admin,editor',
            'status' => 'required|string|in:active,inactive',
        ];

        if ($request->expectsJson() && ! $validateOnly) {
            $rules['admin_password'] = 'required|string';
        }

        $validated = $request->validate(
            $rules,
            [
                'name.required' => 'El nombre es obligatorio.',
                'name.string' => 'El nombre no es válido.',
                'name.max' => 'El nombre no debe exceder 255 caracteres.',
                'name.unique' => 'Este usuario ya existe.',

                'email.required' => 'El correo es obligatorio.',
                'email.email' => 'El correo no tiene un formato válido.',
                'email.max' => 'El correo no debe exceder 255 caracteres.',
                'email.unique' => 'Este usuario ya existe.',

                'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
                'password.confirmed' => 'Las contraseñas no coinciden.',

                'role.required' => 'El rol es obligatorio.',
                'role.in' => 'El rol seleccionado no es válido.',

                'status.required' => 'El estado es obligatorio.',
                'status.in' => 'El estado seleccionado no es válido.',

                'admin_password.required' => 'La contraseña es obligatoria.',
            ],
            [
                'name' => 'nombre',
                'email' => 'correo',
                'password' => 'contraseña',
                'password_confirmation' => 'confirmación de contraseña',
                'admin_password' => 'contraseña',
            ]
        );

        if ($validateOnly) {
            return response()->json(['ok' => true]);
        }

        if ($request->expectsJson()) {
            if (! Hash::check((string) $request->input('admin_password'), (string) Auth::user()->password)) {
                throw ValidationException::withMessages([
                    'admin_password' => ['Contraseña incorrecta.'],
                ]);
            }
        }

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'status' => $validated['status'],
        ];

        if (! empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $user->update($data);

        // Log Activity
        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_email' => Auth::user()->email,
            'action' => 'update',
            'description' => 'Actualizó usuario: '.$user->name,
            'type' => 'user',
            'ip_address' => $request->ip(),
            'details' => ['user_id' => $user->id],
        ]);

        if ($request->expectsJson()) {
            return response()->json(['ok' => true]);
        }

        return redirect()->route('users.index')->with('success', 'Usuario actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        // Prevent deleting self
        if ($user->id === Auth::id()) {
            return redirect()->route('users.index')->with('error', 'No puedes eliminar tu propio usuario.');
        }

        $userName = $user->name;

        $adminFallback = User::where('role', 'admin')->orderBy('created_at')->first();

        if ($adminFallback) {
            Survey::where('user_id', $user->id)->update(['user_id' => $adminFallback->id]);
        }

        $user->delete();

        // Log Activity
        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_email' => Auth::user()->email,
            'action' => 'delete',
            'description' => 'Eliminó usuario: '.$userName.($adminFallback ? ' (encuestas transferidas a '.$adminFallback->name.')' : ''),
            'type' => 'user',
            'ip_address' => $request->ip(),
            'details' => ['user_id' => $id],
        ]);

        return redirect()->route('users.index')->with('success', 'Usuario eliminado exitosamente.');
    }

    public function toggleStatus(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        if ($user->id === Auth::id()) {
            return redirect()->route('users.index')->with('error', 'No puedes cambiar el estado de tu propio usuario.');
        }

        $newStatus = $user->status === 'active' ? 'inactive' : 'active';
        $user->status = $newStatus;
        $user->save();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_email' => Auth::user()->email,
            'action' => 'toggle_status',
            'description' => 'Cambió estado de usuario: '.$user->name.' a '.($newStatus === 'active' ? 'activo' : 'inactivo'),
            'type' => 'user',
            'ip_address' => $request->ip(),
            'details' => ['user_id' => $user->id, 'new_status' => $newStatus],
        ]);

        return redirect()->route('users.index')->with('success', 'Estado de usuario actualizado.');
    }
}
