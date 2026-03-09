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
            <div style="height:6px; background:var(--verde); width:100%;"></div>
            <form action="{{ route('users.store') }}" method="POST" class="p-8">
                @csrf

                <div class="space-y-6">
                    <!-- Nombre -->
                    <div>
                        <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Nombre Completo</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500 transition" placeholder="Ej. Juan Pérez" required>
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-bold text-gray-700 mb-2">Correo Electrónico</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500 transition" placeholder="usuario@uaemex.mx" required>
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-bold text-gray-700 mb-2">Contraseña</label>
                            <input type="password" name="password" id="password" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500 transition" placeholder="********" required>
                            @error('password')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-bold text-gray-700 mb-2">Confirmar Contraseña</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500 transition" placeholder="********" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Rol -->
                        <div>
                            <label for="role" class="block text-sm font-bold text-gray-700 mb-2">Rol</label>
                            <select name="role" id="role" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500 transition cursor-pointer">
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrador</option>
                                <option value="editor" {{ old('role') == 'editor' ? 'selected' : '' }}>Editor</option>
                            </select>
                            @error('role')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Estado -->
                        <div>
                            <label for="status" class="block text-sm font-bold text-gray-700 mb-2">Estado</label>
                            <select name="status" id="status" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500 transition cursor-pointer">
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
                    <a href="{{ route('users.index') }}" class="bg-white text-gray-700 border border-gray-300 px-6 py-2 rounded-lg font-bold hover:bg-gray-50 transition">
                        Cancelar
                    </a>
                    <button type="submit" class="bg-green-700 text-white px-8 py-2 rounded-lg font-bold hover:bg-green-800 transition shadow-md">
                        Guardar Usuario
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
