@extends('layouts.app')

@section('title', 'Mi Perfil')

@section('content')
<div class="page-header">
    <div class="page-title-row">
        <div>
            <h1 class="page-title">Mi perfil</h1>
            <p class="page-subtitle">Actualiza tus datos personales y credenciales de acceso</p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-1">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col items-center text-center gap-4">
            <div class="relative">
                @php
                    $avatarUrl = $user->avatar_url ?? null;
                @endphp
                @if($avatarUrl)
                    <img src="{{ $avatarUrl }}" alt="Foto de perfil" class="w-24 h-24 rounded-full object-cover border-4 border-uaemex/10">
                @else
                    <div class="w-24 h-24 rounded-full bg-uaemex text-white flex items-center justify-center text-3xl font-bold">
                        {{ substr($user->name, 0, 2) }}
                    </div>
                @endif
            </div>
            <div>
                <p class="text-lg font-bold text-gray-900">{{ $user->name }}</p>
                <p class="text-sm text-gray-500">{{ $user->email }}</p>
            </div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-semibold uppercase tracking-wide">
                <i class="fas fa-id-badge"></i>
                <span>
                    @switch($user->role)
                        @case('admin') Administrador @break
                        @case('editor') Editor @break
                        @default Usuario
                    @endswitch
                </span>
            </div>
        </div>
    </div>

    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-6">
            @if(session('success'))
                <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800 flex items-center gap-3">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
                @csrf

                <div class="space-y-2">
                    <label for="name" class="block text-sm font-bold text-gray-700">Nombre completo</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm text-gray-800 focus:outline-none focus:border-uaemex" required>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-bold text-gray-700">Correo electrónico</label>
                    <input type="email" value="{{ $user->email }}" class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm text-gray-500 bg-gray-50" disabled>
                    <p class="text-xs text-gray-400 mt-1">El correo se administra desde el panel de usuarios.</p>
                </div>

                <div class="space-y-2">
                    <label for="avatar_url" class="block text-sm font-bold text-gray-700">Foto de perfil (URL)</label>
                    <input type="url" id="avatar_url" name="avatar_url" value="{{ old('avatar_url', $user->avatar_url ?? '') }}" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm text-gray-800 focus:outline-none focus:border-uaemex" placeholder="https://...">
                    <p class="text-xs text-gray-400 mt-1">Puedes pegar un enlace directo a una imagen (por ejemplo, desde un repositorio o almacenamiento interno).</p>
                </div>

                <div class="border-t border-gray-100 pt-4">
                    <h2 class="text-sm font-bold text-gray-800 mb-3 flex items-center gap-2">
                        <i class="fas fa-lock text-uaemex"></i>
                        Cambiar contraseña
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label for="password" class="block text-sm font-bold text-gray-700">Nueva contraseña</label>
                            <input type="password" id="password" name="password" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm text-gray-800 focus:outline-none focus:border-uaemex" placeholder="Dejar en blanco para no cambiar">
                        </div>
                        <div class="space-y-2">
                            <label for="password_confirmation" class="block text-sm font-bold text-gray-700">Confirmar contraseña</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm text-gray-800 focus:outline-none focus:border-uaemex" placeholder="Repite la nueva contraseña">
                        </div>
                    </div>
                    <p class="text-xs text-gray-400 mt-2">La contraseña debe tener al menos 8 caracteres.</p>
                </div>

                <div class="flex items-center justify-end gap-3 pt-2">
                    <a href="{{ url()->previous() }}" class="px-4 py-2 rounded-lg border border-gray-300 text-sm font-semibold text-gray-600 hover:bg-gray-50">
                        Cancelar
                    </a>
                    <button type="submit" class="px-5 py-2 rounded-lg bg-uaemex text-white text-sm font-bold hover:bg-green-800 transition flex items-center gap-2">
                        <i class="fas fa-save"></i>
                        Guardar cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

