@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-4">
    <!-- CABECERA -->
    <div class="mb-10 text-center">
        <h2 class="text-4xl font-extrabold text-[#020617] italic tracking-tighter uppercase mb-2">SOLICITAR SOPORTE TÉCNICO 🎟️</h2>
        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest leading-none">Describe tu requerimiento y nuestro equipo de TI te ayudará pronto.</p>
    </div>

    <form action="{{ route('user.tickets.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        
        <!-- TARJETA PRINCIPAL DEL FORMULARIO -->
        <div class="bg-white p-10 rounded-[3rem] border border-gray-100 shadow-2xl relative overflow-hidden">
            <!-- DECORACIÓN -->
            <div class="absolute -right-10 -top-10 w-40 h-40 bg-blue-50/50 rounded-full blur-3xl"></div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 relative z-10">
                
                <!-- TÍTULO -->
                <div class="md:col-span-2">
                    <label class="block text-[0.65rem] font-black text-gray-400 uppercase tracking-widest mb-3 italic">TÍTULO DEL PROBLEMA</label>
                    <input type="text" id="ticket-title" name="title" required placeholder="Ej: Error al conectar con la impresora.."
                        class="w-full bg-gray-50/50 border-0 p-5 rounded-2xl text-sm font-bold text-gray-900 focus:ring-4 focus:ring-blue-500/10 placeholder:text-gray-300 transition-all uppercase">
                    
                    <!-- SUGERENCIAS DE GRAVITYBRAIN -->
                    <div id="gravity-brain-container" class="mt-4 hidden">
                        <div class="bg-blue-50/50 p-6 rounded-3xl border border-blue-100/50 backdrop-blur-sm relative overflow-hidden">
                            <div class="flex items-center gap-3 mb-4">
                                <span class="bg-blue-600 text-white text-[0.6rem] font-black px-2 py-1 rounded uppercase tracking-tighter italic">GRAVITYBRAIN AI</span>
                                <span class="text-[0.6rem] font-bold text-gray-400 uppercase tracking-widest leading-none">Hemos encontrado soluciones que podrían ayudarte ahora:</span>
                            </div>
                            <div id="suggestions-list" class="space-y-2">
                                <!-- Las sugerencias se cargarán aquí -->
                            </div>
                        </div>
                    </div>
                </div>

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
                                                const link = `{{ url('/knowledge-base') }}`;
                                                const div = document.createElement('div');
                                                div.className = "group active:scale-95 transition-all text-left";
                                                div.innerHTML = `
                                                    <a href="${link}" target="_blank" class="flex items-center justify-between p-3 bg-white hover:bg-blue-600 rounded-xl border border-blue-100/30 transition-all shadow-sm">
                                                        <span class="text-[0.7rem] font-black text-gray-900 group-hover:text-white uppercase truncate">${item.title}</span>
                                                        <span class="text-[0.65rem] font-black text-blue-600 group-hover:text-white uppercase tracking-tighter">LEER SOLUCIÓN →</span>
                                                    </a>
                                                `;
                                                suggestionsList.appendChild(div);
                                            });
                                            brainContainer.classList.remove('hidden');
                                        } else {
                                            brainContainer.classList.add('hidden');
                                        }
                                    });
                            }, 500);
                        });
                    });
                </script>

                <!-- CATEGORÍA -->
                <div>
                    <label class="block text-[0.65rem] font-black text-gray-400 uppercase tracking-widest mb-3 italic">CATEGORÍA</label>
                    <select name="category_id" required
                        class="w-full bg-gray-50/50 border-0 p-5 rounded-2xl text-sm font-bold text-gray-900 focus:ring-4 focus:ring-blue-500/10 transition-all uppercase appearance-none">
                        @foreach(\App\Models\TicketCategory::all() as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- PRIORIDAD -->
                <div>
                    <label class="block text-[0.65rem] font-black text-gray-400 uppercase tracking-widest mb-3 italic">PRIORIDAD</label>
                    <select name="priority_id" required
                        class="w-full bg-gray-50/50 border-0 p-5 rounded-2xl text-sm font-bold text-gray-900 focus:ring-4 focus:ring-blue-500/10 transition-all uppercase appearance-none">
                        @foreach(\App\Models\TicketPriority::orderBy('level', 'desc')->get() as $priority)
                            <option value="{{ $priority->id }}">{{ $priority->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- DESCRIPCIÓN -->
                <div class="md:col-span-2">
                    <label class="block text-[0.65rem] font-black text-gray-400 uppercase tracking-widest mb-3 italic">DESCRIPCIÓN DETALLADA</label>
                    <textarea name="description" rows="5" required placeholder="Describe paso a paso lo que sucede.."
                        class="w-full bg-gray-50/50 border-0 p-5 rounded-2xl text-sm font-bold text-gray-900 focus:ring-4 focus:ring-blue-500/10 placeholder:text-gray-300 transition-all uppercase"></textarea>
                </div>

                <!-- ADJUNTO (ESTILO PREMIUM) -->
                <div class="md:col-span-2">
                    <label class="block text-[0.65rem] font-black text-gray-400 uppercase tracking-widest mb-3 italic">CAPTURAS O ARCHIVOS (OPCIONAL)</label>
                    <div class="flex items-center justify-center w-full">
                        <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-100 rounded-3xl cursor-pointer bg-gray-50/30 hover:bg-gray-50 hover:border-blue-400 transition-all duration-300">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <p class="mb-2 text-xs font-black text-gray-900 italic tracking-widest uppercase">Subir archivos &attach;</p>
                                <p class="text-[0.6rem] text-gray-400 uppercase tracking-widest font-bold">Imágenes, PDF o Documentos (Max 10MB)</p>
                            </div>
                            <input type="file" name="attachments[]" multiple class="hidden" />
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- BOTONES DE ACCIÓN -->
        <div class="flex items-center justify-end gap-4 pt-4">
            <a href="{{ route('user.tickets.index') }}" class="text-[0.7rem] font-black text-gray-400 uppercase tracking-widest hover:text-gray-900 transition">
                CANCELAR
            </a>
            <button type="submit" class="bg-[#020617] text-white px-12 py-5 rounded-[2rem] font-black text-[0.75rem] uppercase tracking-[0.2em] shadow-2xl hover:bg-blue-600 transition-all transform hover:-translate-y-1 active:scale-95">
                ENVIAR TICKET SOPORTE →
            </button>
        </div>
    </form>
</div>
@endsection
