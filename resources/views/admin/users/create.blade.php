@extends('layouts.app')

@section('content')
<div class="px-6 py-8 bg-slate-950 min-h-screen text-slate-200">
    
    <!-- HEADER DE GESTIÓN DE ACCESO -->
    <div class="mb-16 border-b border-white/5 pb-10 flex flex-col md:flex-row md:items-center justify-between gap-8">
        <div>
            <h1 class="text-3xl font-black text-white tracking-tighter uppercase italic leading-none">
                Despliegue de <span class="text-indigo-500">Nuevo Operador</span>
            </h1>
            <p class="text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.5em] mt-4 flex items-center gap-3 italic">
                <i class="fas fa-user-plus text-indigo-400"></i>
                Terminal de Control de Identidades • Gravity Access
            </p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="text-[0.6rem] font-black text-slate-500 hover:text-white transition-all uppercase tracking-[0.4em] flex items-center gap-4 bg-slate-900 px-8 py-4 rounded-2xl border border-white/5 italic">
            <i class="fas fa-arrow-left text-[10px]"></i>
            Abortar Alta
        </a>
    </div>

    <!-- PANEL DE REGISTRO (GLASSMORPHISM) -->
    <div class="max-w-4xl mx-auto bg-slate-900/40 backdrop-blur-xl p-10 md:p-14 rounded-[3.5rem] border border-white/5 shadow-3xl relative overflow-hidden group">
        <div class="absolute -right-20 -top-20 w-80 h-80 bg-indigo-600/5 rounded-full blur-3xl opacity-0 group-hover:opacity-100 transition-all duration-1000"></div>
        
        <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-12 relative z-10">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <!-- Nombre Máster -->
                <div class="space-y-4 group">
                    <label class="block text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.4em] ml-2 italic group-focus-within:text-indigo-400">Denominación / Nombre Real</label>
                    <input type="text" name="name" required value="{{ old('name') }}"
                        class="w-full px-8 py-6 rounded-2xl bg-slate-950 border border-white/5 text-white font-black text-[0.9rem] focus:border-indigo-500 transition-all outline-none placeholder:text-slate-800 italic uppercase"
                        placeholder="EJ: JUAN PÉREZ">
                </div>

                <!-- Email Sincronizado -->
                <div class="space-y-4 group">
                    <label class="block text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.4em] ml-2 italic group-focus-within:text-indigo-400">Vínculo Email Institucional</label>
                    <input type="email" name="email" required value="{{ old('email') }}"
                        class="w-full px-8 py-6 rounded-2xl bg-slate-950 border border-white/5 text-white font-black text-[0.9rem] focus:border-indigo-500 transition-all outline-none placeholder:text-slate-800 italic uppercase"
                        placeholder="USER@MCHP.CL">
                </div>

                <!-- Seguridad Temporal -->
                <div class="space-y-4 group">
                    <label class="block text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.4em] ml-2 italic group-focus-within:text-indigo-400">Cifrado Temporal (Password)</label>
                    <input type="password" name="password" required
                        class="w-full px-8 py-6 rounded-2xl bg-slate-950 border border-white/5 text-indigo-400 font-black text-[0.9rem] focus:border-indigo-500 transition-all outline-none placeholder:text-slate-800 italic uppercase">
                    <p class="text-[0.5rem] text-slate-700 font-black uppercase tracking-widest pl-2 italic">Protocolo: Mín. 8 Caracteres Alfanuméricos</p>
                </div>

                <!-- Nivel de Autorización (Rol) -->
                <div class="space-y-4 group">
                    <label class="block text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.4em] ml-2 italic leading-none">Nivel de Acceso Root</label>
                    <div class="relative">
                        <select name="role_id" required
                            class="w-full px-8 py-6 bg-slate-950 border border-white/5 rounded-2xl text-white font-black text-[0.75rem] focus:border-indigo-500 transition-all outline-none appearance-none uppercase italic tracking-widest custom-select">
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }} class="bg-slate-950">
                                    {{ strtoupper($role->name) }}
                                </option>
                            @endforeach
                        </select>
                        <i class="fas fa-user-shield absolute right-8 top-1/2 -translate-y-1/2 text-slate-800"></i>
                    </div>
                </div>

                <!-- Vector Localizador (Teléfono) -->
                <div class="space-y-4 group">
                    <label class="block text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.4em] ml-2 italic group-focus-within:text-indigo-400 transition-all">Vector de Contacto Operativo</label>
                    <input type="text" name="phone" value="{{ old('phone') }}"
                        class="w-full px-8 py-6 rounded-2xl bg-slate-950 border border-white/5 text-white font-black text-[0.9rem] focus:border-indigo-500 transition-all outline-none placeholder:text-slate-800 italic uppercase"
                        placeholder="+56 9 XXXX XXXX">
                </div>

                <!-- Afiliación Corporativa -->
                <div class="space-y-4 group">
                    <label class="block text-[0.6rem] font-black text-indigo-400 uppercase tracking-[0.4em] ml-2 italic leading-none transition-all group-focus-within:text-white">Entidad Perteneciente</label>
                    <div class="relative">
                        <select name="entity" required
                            class="w-full px-8 py-6 bg-indigo-500/10 border border-indigo-500/30 rounded-2xl text-white font-black text-[0.75rem] focus:border-indigo-500 transition-all outline-none appearance-none uppercase italic tracking-widest custom-select hover:bg-indigo-600/20">
                            <option value="IASD" {{ old('entity') == 'IASD' ? 'selected' : '' }} class="bg-indigo-950">⛪ IASD - IGLESIA ADVENTISTA</option>
                            <option value="FESDG" {{ old('entity') == 'FESDG' ? 'selected' : '' }} class="bg-indigo-950">🎓 FESDG - FUNDACIÓN SANDERS</option>
                        </select>
                        <i class="fas fa-university absolute right-8 top-1/2 -translate-y-1/2 text-indigo-400/50"></i>
                    </div>
                </div>
            </div>

            <!-- EJECUCIÓN MAESTRO -->
            <div class="pt-10 flex flex-col sm:flex-row gap-6">
                <button type="submit"
                    class="flex-1 bg-white text-slate-950 hover:bg-indigo-600 hover:text-white font-black py-8 rounded-[2rem] transition-all shadow-3xl uppercase tracking-[0.4em] italic text-[0.8rem] flex items-center justify-center gap-6 group">
                    CONFIRMAR ALTA DEL AGENTE
                    <i class="fas fa-check-double text-[10px] group-hover:scale-125 transition-transform"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    .custom-select { background-image: none; }
</style>
@endsection
