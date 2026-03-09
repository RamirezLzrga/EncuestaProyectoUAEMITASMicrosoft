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
            <div style="height:6px; background:var(--oro); width:100%;"></div>
            <form action="{{ route('users.update', $user->id) }}" method="POST" class="p-8">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <!-- Nombre -->
                    <div>
                        <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Nombre Completo</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500 transition" required>
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-bold text-gray-700 mb-2">Correo Electrónico</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500 transition" required>
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-bold text-gray-700 mb-2">Contraseña (Opcional)</label>
                            <input type="password" name="password" id="password" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500 transition" placeholder="Dejar en blanco para mantener">
                            @error('password')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-bold text-gray-700 mb-2">Confirmar Contraseña</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500 transition" placeholder="********">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Rol -->
                        <div class="space-y-2">
                            <label for="role" class="block text-sm font-medium text-gray-700">Rol del Usuario <span class="text-red-500">*</span></label>
                            <select name="role" id="role" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-uaemex focus:border-uaemex transition-all bg-white">
                                <option value="editor" {{ old('role', $user->role) == 'editor' ? 'selected' : '' }}>Editor</option>
                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Administrador</option>
                            </select>
                        </div>

                        <!-- Estado -->
                        <div>
                            <label for="status" class="block text-sm font-bold text-gray-700 mb-2">Estado</label>
                            <select name="status" id="status" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500 transition cursor-pointer">
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
                    <a href="{{ route('users.index') }}" class="bg-white text-gray-700 border border-gray-300 px-6 py-2 rounded-lg font-bold hover:bg-gray-50 transition">
                        Cancelar
                    </a>
                    <button type="submit" class="bg-yellow-500 text-white px-8 py-2 rounded-lg font-bold hover:bg-yellow-600 transition shadow-md">
                        Actualizar Usuario
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
