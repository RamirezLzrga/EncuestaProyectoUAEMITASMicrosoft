@extends('layouts.admin')

@section('title', 'Nuevo Usuario')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="ph">
            <div class="ph-left">
                <div class="ph-label">Administración</div>
                <div class="ph-title">Nuevo Usuario</div>
                <div class="ph-sub">Completa el formulario para registrar un usuario</div>
            </div>
            <div class="ph-actions">
                <a href="{{ route('users.index') }}" class="btn btn-neu">← Volver</a>
            </div>
        </div>

        <div class="neu-card" style="padding:0; overflow:hidden;">
            <form action="{{ route('users.store') }}" method="POST" class="p-8">
                @csrf

                <div class="space-y-6">
                    <!-- Nombre -->
                    <div>
                        <label for="name" class="form-label">Nombre Completo</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-input" placeholder="Ej. Juan Pérez" required>
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-input" placeholder="usuario@uaemex.mx" required>
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid-2">
                        <!-- Password -->
                        <div>
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" name="password" id="password" class="form-input" placeholder="********" required>
                            @error('password')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-input" placeholder="********" required>
                        </div>
                    </div>

                    <div class="grid-2">
                        <!-- Rol -->
                        <div>
                            <label for="role" class="form-label">Rol</label>
                            <select name="role" id="role" class="form-input">
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrador</option>
                                <option value="editor" {{ old('role') == 'editor' ? 'selected' : '' }}>Editor</option>
                            </select>
                            @error('role')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Estado -->
                        <div>
                            <label for="status" class="form-label">Estado</label>
                            <select name="status" id="status" class="form-input">
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Activo</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactivo</option>
                            </select>
                            @error('status')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                </div>

                <div class="mt-8 flex justify-end gap-3">
                    <a href="{{ route('users.index') }}" class="btn btn-neu">Cancelar</a>
                    <button type="submit" class="btn btn-solid">Guardar Usuario</button>
                </div>
            </form>
        </div>
    </div>
@endsection
