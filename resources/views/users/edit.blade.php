@extends('layouts.admin')

@section('title', 'Editar Usuario')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="ph">
            <div class="ph-left">
                <div class="ph-label">Administración</div>
                <div class="ph-title">Editar Usuario</div>
                <div class="ph-sub">Modificar datos de {{ $user->name }}</div>
            </div>
            <div class="ph-actions">
                <a href="{{ route('users.index') }}" class="btn btn-neu">← Volver</a>
            </div>
        </div>

        <div class="neu-card" style="padding:0; overflow:hidden;">
            <form action="{{ route('users.update', $user->id) }}" method="POST" class="p-8">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <!-- Nombre -->
                    <div>
                        <label for="name" class="form-label">Nombre Completo</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="form-input" required>
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="form-input" required>
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid-2">
                        <!-- Password -->
                        <div>
                            <label for="password" class="form-label">Contraseña (Opcional)</label>
                            <input type="password" name="password" id="password" class="form-input" placeholder="Dejar en blanco para mantener">
                            @error('password')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-input" placeholder="********">
                        </div>
                    </div>

                    <div class="grid-2">
                        <!-- Rol -->
                        <div>
                            <label for="role" class="form-label">Rol del Usuario <span class="text-red-500">*</span></label>
                            <select name="role" id="role" required class="form-input">
                                <option value="editor" {{ old('role', $user->role) == 'editor' ? 'selected' : '' }}>Editor</option>
                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Administrador</option>
                            </select>
                        </div>

                        <!-- Estado -->
                        <div>
                            <label for="status" class="form-label">Estado</label>
                            <select name="status" id="status" class="form-input">
                                <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>Activo</option>
                                <option value="inactive" {{ old('status', $user->status) == 'inactive' ? 'selected' : '' }}>Inactivo</option>
                            </select>
                            @error('status')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                </div>

                <div class="mt-8 flex justify-end gap-3">
                    <a href="{{ route('users.index') }}" class="btn btn-neu">Cancelar</a>
                    <button type="submit" class="btn btn-solid">Actualizar Usuario</button>
                </div>
            </form>
        </div>
    </div>
@endsection
