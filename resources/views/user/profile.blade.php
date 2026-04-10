@extends('layouts.app')

@section('content')
<div class="px-6 py-8 bg-slate-950 min-h-screen text-slate-200">
    
    <!-- CABECERA DE IDENTIDAD PREMIUM -->
    <div class="mb-16 flex flex-col md:flex-row md:items-center justify-between gap-10 border-b border-white/5 pb-10">
        <div>
            <h1 class="text-3xl font-black text-white tracking-tighter uppercase italic leading-none">Gestión de Identidad y Credenciales</h1>
            <p class="text-[0.65rem] font-black text-indigo-400 uppercase tracking-[0.6em] mt-4 flex items-center gap-2 italic">
                <span class="w-1.5 h-1.5 bg-indigo-500 rounded-full animate-pulse shadow-[0_0_10px_rgba(99,102,241,1)]"></span>
                Gravity Identity Passport • Terminal v2.0
            </p>
        </div>
        <div class="flex items-center gap-6 bg-slate-900/40 p-2 pr-8 rounded-[3rem] border border-white/5 shadow-2xl">
            <div class="w-20 h-20 bg-slate-950 rounded-[2.5rem] flex items-center justify-center text-white text-3xl shadow-2xl relative overflow-hidden group border border-indigo-500/30">
                 <div class="absolute inset-0 bg-indigo-600 opacity-20 group-hover:opacity-40 transition-opacity"></div>
                 <span class="relative z-10 italic font-black uppercase">{{ substr($user->name, 0, 1) }}</span>
            </div>
            <div>
                <p class="text-[0.55rem] font-black text-slate-600 uppercase tracking-widest italic leading-none mb-1">Usuario Activo</p>
                <p class="text-lg font-black text-white uppercase italic tracking-tighter leading-none">{{ $user->name }}</p>
            </div>
        </div>
    </div>

    <form action="{{ route('profile.update') }}" method="POST" class="space-y-12">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
            
            <!-- SECCIÓN: INFORMACIÓN OPERATIVA -->
            <div class="bg-slate-900/40 backdrop-blur-xl p-10 md:p-12 rounded-[3.5rem] border border-white/5 shadow-3xl space-y-10 relative overflow-hidden group">
                <div class="absolute -right-10 -top-10 w-48 h-48 bg-indigo-600/5 rounded-full blur-3xl group-hover:bg-indigo-600/10 transition-all"></div>
                
                <div class="flex items-center gap-4 relative z-10">
                    <div class="w-1.5 h-8 bg-indigo-600 rounded-full shadow-[0_0_15px_rgba(79,70,229,0.5)]"></div>
                    <h2 class="text-[0.7rem] font-black text-white uppercase italic tracking-widest">Información de Enlace</h2>
                </div>

                <div class="space-y-4 relative z-10">
                    <label class="text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.4em] ml-2 italic">Nombre de Registro Institucional</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required autocomplete="off"
                        class="w-full px-8 py-6 bg-slate-950 border border-white/5 rounded-2xl text-white font-black text-[0.9rem] focus:border-indigo-500 transition-all outline-none italic placeholder:text-slate-800 tracking-tight">
                </div>

                <div class="space-y-4 relative z-10">
                    <label class="text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.4em] ml-2 italic">Dirección de Sincronización (Email)</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                        class="w-full px-8 py-6 bg-slate-950 border border-white/5 rounded-2xl text-white font-black text-[0.9rem] focus:border-indigo-500 transition-all outline-none italic tracking-tight">
                    <p class="text-[0.55rem] text-slate-600 font-bold uppercase tracking-widest mt-4 italic px-2 leading-relaxed">Este canal se utiliza para la transmisión de protocolos y alertas de tickets.</p>
                </div>
            </div>

            <!-- SECCIÓN: SEGURIDAD Y ACCESO -->
            <div class="bg-slate-900/40 backdrop-blur-xl p-10 md:p-12 rounded-[3.5rem] border border-white/5 shadow-3xl space-y-10 relative overflow-hidden group">
                <div class="absolute -left-10 -bottom-10 w-48 h-48 bg-rose-600/5 rounded-full blur-3xl group-hover:bg-rose-600/10 transition-all"></div>
                
                <div class="flex items-center gap-4 relative z-10">
                    <div class="w-1.5 h-8 bg-rose-600 rounded-full shadow-[0_0_15px_rgba(225,29,72,0.5)]"></div>
                    <h2 class="text-[0.7rem] font-black text-white uppercase italic tracking-widest">Protocolo de Seguridad</h2>
                </div>

                <div class="space-y-4 relative z-10">
                    <label class="text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.4em] ml-2 italic">Nueva Clave de Acceso (Opcional)</label>
                    <input type="password" name="password" 
                        class="w-full px-8 py-6 bg-slate-950 border border-white/5 rounded-2xl text-white font-black focus:border-rose-600 transition-all outline-none tracking-widest">
                </div>

                <div class="space-y-4 relative z-10">
                    <label class="text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.4em] ml-2 italic">Re-Validar Contraseña</label>
                    <input type="password" name="password_confirmation" 
                        class="w-full px-8 py-6 bg-slate-950 border border-white/5 rounded-2xl text-white font-black focus:border-rose-600 transition-all outline-none tracking-widest">
                </div>
                
                <p class="text-[0.55rem] text-slate-600 font-bold uppercase tracking-widest mt-6 leading-relaxed italic border-t border-white/5 pt-6">El sistema mantendrá la llave actual si estos campos permanecen sin modificaciones.</p>
            </div>
        </div>

        <!-- ACCIÓN DE SINCRONIZACIÓN -->
        <div class="flex justify-center md:justify-end pt-10">
            <button type="submit" 
                class="group bg-white hover:bg-indigo-600 text-slate-950 hover:text-white font-black px-16 py-8 rounded-[2.5rem] shadow-3xl transition-all hover:-translate-y-2 flex items-center gap-6 border border-white/10 italic">
                <span class="text-[0.8rem] uppercase tracking-[0.4em] italic leading-none">Sincronizar Terminal Gravity</span>
                <i class="fas fa-sync-alt text-lg group-hover:rotate-180 transition-transform duration-700"></i>
            </button>
        </div>
    </form>

    <!-- FOOTER DE IDENTIDAD -->
    <div class="mt-24 text-center">
        <p class="text-[0.55rem] font-black text-slate-800 uppercase tracking-[1em] italic leading-none">
            Global Passport • Identity Node • Encryption Active
        </p>
    </div>
</div>
@endsection
