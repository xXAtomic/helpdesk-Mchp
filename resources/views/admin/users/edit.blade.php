@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-12 px-6">
    <div class="mb-12">
        <h1 class="text-4xl font-black text-slate-900 tracking-tighter italic uppercase mb-2">
            Editar <span class="text-blue-600">Usuario</span>
        </h1>
        <p class="text-slate-500 font-medium tracking-wide">Actualizar perfil de: <strong>{{ $user->name }}</strong></p>
    </div>

    <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden transition-all hover:shadow-md">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="p-10 space-y-8">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Nombre -->
                <div class="space-y-2">
                    <label class="text-[0.7rem] font-bold text-slate-400 uppercase tracking-widest ml-1">Nombre Completo</label>
                    <input type="text" name="name" required value="{{ old('name', $user->name) }}"
                        class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl text-slate-900 font-semibold focus:ring-2 focus:ring-blue-500 transition-all placeholder:text-slate-300">
                </div>

                <!-- Email -->
                <div class="space-y-2">
                    <label class="text-[0.7rem] font-bold text-slate-400 uppercase tracking-widest ml-1">Email Institucional</label>
                    <input type="email" name="email" required value="{{ old('email', $user->email) }}"
                        class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl text-slate-900 font-semibold focus:ring-2 focus:ring-blue-500 transition-all placeholder:text-slate-300">
                </div>

                <!-- Password -->
                <div class="space-y-2">
                    <label class="text-[0.7rem] font-bold text-slate-400 uppercase tracking-widest ml-1">Nueva Contraseña (Opcional)</label>
                    <input type="password" name="password"
                        class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl text-slate-900 font-semibold focus:ring-2 focus:ring-blue-500 transition-all placeholder:text-slate-300">
                    <p class="text-[0.6rem] text-slate-400 italic">Dejar vacío para mantener la actual. Mínimo 8 caracteres.</p>
                </div>

                <!-- Rol -->
                <div class="space-y-2">
                    <label class="text-[0.7rem] font-bold text-slate-400 uppercase tracking-widest ml-1">Rol de Acceso</label>
                    <select name="role_id" required
                        class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl text-slate-900 font-semibold focus:ring-2 focus:ring-blue-500 transition-all">
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Teléfono -->
                <div class="space-y-2">
                    <label class="text-[0.7rem] font-bold text-slate-400 uppercase tracking-widest ml-1">Teléfono (Opcional)</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                        class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl text-slate-900 font-semibold focus:ring-2 focus:ring-blue-500 transition-all placeholder:text-slate-300">
                </div>

                <!-- Entidad -->
                <div class="space-y-2">
                    <label class="text-[0.7rem] font-bold text-blue-600 uppercase tracking-widest ml-1">Entidad Perteneciente</label>
                    <select name="entity" required
                        class="w-full px-5 py-4 bg-blue-50 border-none rounded-2xl text-slate-900 font-bold focus:ring-2 focus:ring-blue-500 transition-all appearance-none cursor-pointer">
                        <option value="IASD" {{ old('entity', $user->entity) == 'IASD' ? 'selected' : '' }}>⛪ IASD - Iglesia Adventista</option>
                        <option value="FESDG" {{ old('entity', $user->entity) == 'FESDG' ? 'selected' : '' }}>🎓 FESDG - Fundación Sanders</option>
                    </select>
                </div>
            </div>

            <div class="pt-10 flex gap-4">
                <button type="submit"
                    class="flex-1 bg-slate-900 hover:bg-slate-800 text-white font-black py-5 rounded-2xl transition-all shadow-xl hover:shadow-slate-200 uppercase tracking-widest italic">
                    Actualizar Usuario
                </button>
                <a href="{{ route('admin.users.index') }}"
                    class="px-10 bg-slate-100 hover:bg-slate-200 text-slate-500 font-bold py-5 rounded-2xl transition-all uppercase tracking-widest flex items-center">
                    Cerrar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
