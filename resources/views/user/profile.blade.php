@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-12 px-6">
    <!-- Header de Perfil ✨ -->
    <div class="mb-12 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl font-black text-slate-950 tracking-tighter uppercase italic leading-none">Gestión de Identidad y Credenciales de Usuario</h1>
            <p class="text-[0.65rem] font-black text-slate-400 uppercase tracking-[0.6em] mt-4 italic">Gravity Passport</p>
        </div>
        <div class="w-20 h-20 bg-slate-950 rounded-[2rem] flex items-center justify-center text-white text-3xl shadow-2xl relative overflow-hidden group border-4 border-indigo-500/20">
             <div class="absolute inset-0 bg-indigo-600 opacity-20 group-hover:opacity-40 transition-opacity"></div>
             <span class="relative z-10 italic uppercase">{{ substr($user->name, 0, 1) }}</span>
        </div>
    </div>

    <form action="{{ route('profile.update') }}" method="POST" class="space-y-10">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
            <!-- Sección: Datos Personales (Pro-SaaS) -->
            <div class="bg-white p-10 rounded-[3rem] border border-slate-100 shadow-xl shadow-slate-200/50 space-y-8">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-2 h-6 bg-indigo-600 rounded-full"></div>
                    <h2 class="text-sm font-black text-slate-900 uppercase italic tracking-widest">Información Básica</h2>
                </div>

                <div class="space-y-2">
                    <label class="text-[0.65rem] font-black text-slate-400 uppercase tracking-widest ml-1">Nombre Completo</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                        class="w-full px-6 py-5 bg-slate-50 border-2 border-transparent rounded-2xl text-slate-900 font-bold focus:border-indigo-500 focus:bg-white transition-all uppercase italic">
                </div>

                <div class="space-y-2">
                    <label class="text-[0.65rem] font-black text-slate-400 uppercase tracking-widest ml-1">Correo Electrónico Oficial</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                        class="w-full px-6 py-5 bg-slate-50 border-2 border-transparent rounded-2xl text-slate-900 font-bold focus:border-indigo-500 focus:bg-white transition-all italic">
                    <p class="text-[0.55rem] text-slate-400 font-bold uppercase tracking-widest mt-2 italic px-1">Este correo se usará para todas las notificaciones de tickets.</p>
                </div>
            </div>

            <!-- Sección: Seguridad -->
            <div class="bg-slate-950 p-10 rounded-[3rem] shadow-2xl relative overflow-hidden space-y-8">
                <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/5 rounded-full"></div>
                <div class="relative z-10">
                    <div class="flex items-center gap-3 mb-10">
                        <div class="w-2 h-6 bg-red-500 rounded-full shadow-[0_0_10px_rgba(244,63,94,0.5)]"></div>
                        <h2 class="text-sm font-black text-white uppercase italic tracking-widest">Seguridad de Cuenta</h2>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[0.65rem] font-black text-slate-500 uppercase tracking-widest ml-1">Nueva Contraseña (Opcional)</label>
                        <input type="password" name="password" 
                            class="w-full px-6 py-5 bg-white/5 border-2 border-transparent rounded-2xl text-white font-bold focus:border-red-500 focus:bg-white/10 transition-all">
                    </div>

                    <div class="space-y-2 mt-6">
                        <label class="text-[0.65rem] font-black text-slate-500 uppercase tracking-widest ml-1">Confirmar Contraseña</label>
                        <input type="password" name="password_confirmation" 
                            class="w-full px-6 py-5 bg-white/5 border-2 border-transparent rounded-2xl text-white font-bold focus:border-red-500 focus:bg-white/10 transition-all">
                    </div>
                    
                    <p class="text-[0.55rem] text-slate-500 font-bold uppercase tracking-widest mt-6 leading-relaxed italic">Deje en blanco si no desea cambiar su clave de acceso actual.</p>
                </div>
            </div>
        </div>

        <!-- Botón de Sincronización -->
        <div class="flex justify-center md:justify-end pt-4">
            <button type="submit" 
                class="group bg-indigo-600 hover:bg-slate-950 text-white font-black px-12 py-6 rounded-[2rem] shadow-2xl transition-all hover:-translate-y-2 flex items-center gap-4 border-2 border-indigo-400">
                <span class="text-xs uppercase tracking-[0.3em] italic">Sincronizar Datos Gravity</span>
                <span class="text-xl group-hover:rotate-12 transition-transform">🔄</span>
            </button>
        </div>
    </form>
</div>
@endsection
