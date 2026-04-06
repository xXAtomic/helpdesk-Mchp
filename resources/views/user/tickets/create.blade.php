@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-8">
    <!-- CABECERA DE ALTO IMPACTO -->
    <div class="mb-12 text-center">
        <h2 class="text-5xl font-black text-[#020617] italic tracking-tighter uppercase mb-3">SOLICITAR SOPORTE TÉCNICO 🎟️</h2>
        <div class="flex items-center justify-center gap-4">
            <span class="h-[2px] w-12 bg-blue-600 rounded-full"></span>
            <p class="text-[0.7rem] font-black text-gray-400 uppercase tracking-[0.3em] leading-none">Describe tu requerimiento y el equipo de TI lo resolverá</p>
            <span class="h-[2px] w-12 bg-blue-600 rounded-full"></span>
        </div>
    </div>

    <form action="{{ route('user.tickets.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        
        <!-- TARJETA PREMIUM -->
        <div class="bg-white p-12 rounded-[4rem] border-2 border-gray-50 shadow-2xl relative overflow-hidden">
            <!-- DECORACIÓN DE FONDO -->
            <div class="absolute -right-20 -top-20 w-80 h-80 bg-blue-50/30 rounded-full blur-3xl"></div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 relative z-10">
                
                <!-- TÍTULO DINÁMICO (DISPARADOR GRAVITYBRAIN) -->
                <div class="md:col-span-2 group">
                    <label class="block text-[0.65rem] font-black text-gray-400 uppercase tracking-[0.2em] mb-4 italic transition-colors group-focus-within:text-blue-600">Título de la Solicitud</label>
                    <input type="text" id="ticket-title" name="title" required 
                        placeholder="EJ: MI EQUIPO NO ENCIENDE TRAS LA ACTUALIZACIÓN.."
                        class="w-full bg-gray-50 border-2 border-transparent p-6 rounded-[2rem] text-sm font-black text-gray-900 focus:bg-white focus:border-blue-500/20 focus:ring-4 focus:ring-blue-500/10 placeholder:text-gray-300 transition-all uppercase shadow-inner">
                    
                    <!-- PANEL DE SUGERENCIAS AI -->
                    <div id="gravity-brain-container" class="mt-6 hidden animate-in fade-in slide-in-from-top-4 duration-500">
                        <div class="bg-gradient-to-br from-blue-600 to-indigo-700 p-8 rounded-[2.5rem] shadow-2xl shadow-blue-200 relative overflow-hidden">
                            <div class="flex items-center gap-4 mb-6">
                                <div class="bg-white/20 p-2 rounded-lg backdrop-blur-md">
                                    <span class="text-white text-lg">🤖</span>
                                </div>
                                <div>
                                    <h4 class="text-white text-[0.7rem] font-black uppercase tracking-widest italic">GravityBrain Intelligence</h4>
                                    <p class="text-blue-100 text-[0.6rem] font-bold uppercase tracking-tighter opacity-80">Hemos encontrado casos similares en la base de conocimientos:</p>
                                </div>
                            </div>
                            <div id="suggestions-list" class="grid grid-cols-1 gap-3">
                                <!-- Sugerencias dinámicas aquí -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CATEGORÍA -->
                <div class="group">
                    <label class="block text-[0.65rem] font-black text-gray-400 uppercase tracking-[0.2em] mb-4 italic group-focus-within:text-blue-600">Categoría</label>
                    <div class="relative">
                        <select name="category_id" required
                            class="w-full bg-gray-50 border-2 border-transparent p-6 rounded-[2rem] text-sm font-black text-gray-900 focus:bg-white focus:border-blue-500/20 focus:ring-4 focus:ring-blue-500/10 transition-all uppercase appearance-none cursor-pointer">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <div class="absolute right-6 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400 text-xs">
                            <i class="fas fa-chevron-down"></i>
                        </div>
                    </div>
                </div>

                <!-- PRIORIDAD -->
                <div class="group">
                    <label class="block text-[0.65rem] font-black text-gray-400 uppercase tracking-[0.2em] mb-4 italic group-focus-within:text-blue-600">Urgencia</label>
                    <div class="relative">
                        <select name="priority_id" required
                            class="w-full bg-gray-50 border-2 border-transparent p-6 rounded-[2rem] text-sm font-black text-gray-900 focus:bg-white focus:border-blue-500/20 focus:ring-4 focus:ring-blue-500/10 transition-all uppercase appearance-none cursor-pointer">
                            @foreach($priorities as $priority)
                                <option value="{{ $priority->id }}">{{ $priority->name }}</option>
                            @endforeach
                        </select>
                        <div class="absolute right-6 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400 text-xs">
                            <i class="fas fa-chevron-down"></i>
                        </div>
                    </div>
                </div>

                <!-- DESCRIPCIÓN DETALLADA -->
                <div class="md:col-span-2 group">
                    <label class="block text-[0.65rem] font-black text-gray-400 uppercase tracking-[0.2em] mb-4 italic group-focus-within:text-blue-600">Detalles del Requerimiento</label>
                    <textarea name="description" rows="6" required 
                        placeholder="Por favor, describe detalladamente tu problema o solicitud técnica.."
                        class="w-full bg-gray-50 border-2 border-transparent p-8 rounded-[3rem] text-sm font-bold text-gray-900 focus:bg-white focus:border-blue-500/20 focus:ring-4 focus:ring-blue-500/10 placeholder:text-gray-300 transition-all uppercase shadow-inner"></textarea>
                </div>

                <!-- CARGA DE ARCHIVOS -->
                <div class="md:col-span-2 group">
                    <label class="block text-[0.65rem] font-black text-gray-400 uppercase tracking-[0.2em] mb-4 italic group-focus-within:text-blue-600">Archivos Adjuntos</label>
                    <label class="flex flex-col items-center justify-center w-full h-44 border-4 border-dashed border-gray-50 rounded-[3rem] cursor-pointer bg-gray-50/50 hover:bg-blue-50 hover:border-blue-400/50 transition-all duration-500 group/drop">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center mb-4 shadow-xl border border-gray-100 group-hover/drop:scale-110 transition-transform">
                                <i class="fas fa-cloud-upload-alt text-blue-600"></i>
                            </div>
                            <p class="text-[0.65rem] font-black text-gray-900 italic tracking-[0.2em] uppercase">Click para adjuntar evidencia</p>
                            <p class="text-[0.55rem] text-gray-400 uppercase tracking-widest font-bold mt-2">Formatos permitidos: JPG, PNG, PDF (MAX 10MB)</p>
                        </div>
                        <input type="file" name="attachments[]" multiple class="hidden" />
                    </label>
                </div>
            </div>
        </div>

        <!-- ACCIONES FINALES -->
        <div class="flex flex-col md:flex-row items-center justify-end gap-8 pt-6">
            <a href="{{ route('user.tickets.index') }}" class="text-[0.7rem] font-black text-gray-400 uppercase tracking-[0.3em] hover:text-[#020617] transition-all flex items-center gap-2">
                <i class="fas fa-times text-xs"></i> CANCELAR PROCESO
            </a>
            <button type="submit" class="w-full md:w-auto bg-[#020617] text-white px-16 py-7 rounded-[2.5rem] font-black text-[0.8rem] uppercase tracking-[0.25em] shadow-2xl hover:bg-blue-600 transition-all transform hover:-translate-y-2 active:scale-95 border-b-4 border-black/20 flex items-center gap-4">
                ENVIAR REQUERIMIENTO <i class="fas fa-paper-plane text-xs"></i>
            </button>
        </div>
    </form>
</div>

<!-- MOTOR DE INTELIGENCIA GRAVITYBRAIN -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const titleInput = document.getElementById('ticket-title');
    const brainContainer = document.getElementById('gravity-brain-container');
    const suggestionsList = document.getElementById('suggestions-list');
    let debounceTimer;

    titleInput.addEventListener('keyup', function() {
        clearTimeout(debounceTimer);
        const query = this.value;

        if (query.length < 3) {
            brainContainer.classList.add('hidden');
            return;
        }

        debounceTimer = setTimeout(() => {
            fetch(`{{ route('gravity.brain.search') }}?query=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        suggestionsList.innerHTML = '';
                        data.forEach(item => {
                            const link = `{{ url('/knowledge') }}/${item.id}`; // Ajustado a tu ruta de conocimiento
                            const div = document.createElement('div');
                            div.innerHTML = `
                                <a href="${link}" target="_blank" class="flex items-center justify-between p-4 bg-white/10 hover:bg-white/20 rounded-2xl border border-white/10 transition-all group/item backdrop-blur-md">
                                    <span class="text-[0.7rem] font-black text-white uppercase truncate pr-4">${item.title}</span>
                                    <span class="text-[0.6rem] font-black text-blue-200 group-hover/item:text-white uppercase tracking-tighter shrink-0 italic">Ver Solución →</span>
                                </a>
                            `;
                            suggestionsList.appendChild(div);
                        });
                        brainContainer.classList.remove('hidden');
                    } else {
                        brainContainer.classList.add('hidden');
                    }
                })
                .catch(err => console.error('GravityBrain Error:', err));
        }, 600);
    });
});
</script>
@endsection
