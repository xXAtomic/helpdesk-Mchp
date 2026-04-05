<x-app-layout>
    <x-slot name="header">
        Nueva Solicitud de Soporte 🚀
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto">
            <form action="{{ route('user.tickets.store') }}" method="POST" enctype="multipart/form-data" 
                  class="bg-white p-10 md:p-16 rounded-[3rem] shadow-2xl shadow-blue-50/50 border border-gray-100">
                @csrf
                
                <h2 class="text-3xl font-black text-gray-900 mb-10 italic tracking-tighter uppercase">NUEVA SOLICITUD DE APOYO 🔥</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    <!-- NOMBRE (Solo lectura) -->
                    <div>
                        <label class="text-[0.65rem] font-black text-gray-400 uppercase tracking-widest mb-2 block">SOLICITANTE</label>
                        <input type="text" value="{{ Auth::user()->name }}" readonly 
                               class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-2 border-gray-50 text-gray-400 font-bold text-sm outline-none">
                    </div>
                    <!-- EMAIL (Solo lectura) -->
                    <div>
                        <label class="text-[0.65rem] font-black text-gray-400 uppercase tracking-widest mb-2 block">CORREO ELECTRÓNICO</label>
                        <input type="text" value="{{ Auth::user()->email }}" readonly 
                               class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-2 border-gray-50 text-gray-400 font-bold text-sm outline-none">
                    </div>
                </div>

                <!-- CATEGORÍA Y PRIORIDAD -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    <div>
                        <label class="text-[0.65rem] font-black text-gray-450 uppercase tracking-widest mb-2 block">CATEGORÍA DEL PROBLEMA <span class="text-blue-500">*</span></label>
                        <select name="category_id" required class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-2 border-gray-100 font-black text-sm focus:border-blue-500 focus:bg-white transition outline-none">
                            <option value="">SELECCIONA UNA...</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-[0.65rem] font-black text-gray-450 uppercase tracking-widest mb-2 block">PRIORIDAD / IMPACTO <span class="text-blue-500">*</span></label>
                        <select name="priority_id" required class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-2 border-gray-100 font-black text-sm focus:border-blue-500 focus:bg-white transition outline-none">
                            @foreach($priorities as $priority)
                                <option value="{{ $priority->id }}" {{ $priority->id == 1 ? 'selected' : '' }}>{{ $priority->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- ASUNTO -->
                <div class="mb-8">
                    <label class="text-[0.65rem] font-black text-gray-450 uppercase tracking-widest mb-2 block">ASUNTO DE LA SOLICITUD <span class="text-blue-500">*</span></label>
                    <input type="text" name="title" required placeholder="EJ: EL CORREO NO CARGA EN OUTLOOK"
                           class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-2 border-gray-100 font-black text-sm focus:border-blue-500 focus:bg-white transition outline-none uppercase placeholder:text-gray-300">
                </div>

                <!-- DESCRIPCIÓN -->
                <div class="mb-10">
                    <label class="text-[0.65rem] font-black text-gray-450 uppercase tracking-widest mb-2 block">DETALLE DEL PROBLEMA <span class="text-blue-500">*</span></label>
                    <textarea name="description" required rows="5" placeholder="EXPLICA AQUÍ TU INCONVENIENTE..."
                              class="w-full px-6 py-4 rounded-3xl bg-gray-50 border-2 border-gray-100 font-bold text-sm focus:border-blue-500 focus:bg-white transition outline-none placeholder:text-gray-300"></textarea>
                </div>

                <!-- ADJUNTO -->
                <div class="mb-12">
                    <label class="text-[0.65rem] font-black text-gray-450 uppercase tracking-widest mb-2 block">ADJUNTAR CAPTURA O EVIDENCIA (OPCIONAL)</label>
                    <div class="relative group">
                        <input type="file" name="attachment" 
                               class="w-full px-6 py-4 rounded-2xl border-2 border-dashed border-gray-200 bg-gray-50 text-gray-400 font-black text-[0.65rem] cursor-pointer hover:border-blue-400 hover:bg-blue-50 transition uppercase">
                        <p class="mt-2 text-[0.6rem] text-gray-400 font-bold tracking-tighter">MAX 10MB • FORMATOS: JPG, PNG, PDF</p>
                    </div>
                </div>

                <!-- BOTÓN ENVIAR -->
                <div class="flex gap-4">
                    <a href="{{ route('user.tickets.index') }}" class="flex-1 px-8 py-5 rounded-2xl bg-gray-100 text-gray-500 font-black text-xs text-center hover:bg-gray-200 transition uppercase tracking-widest">
                        CANCELAR
                    </a>
                    <button type="submit" class="flex-[2] px-8 py-5 rounded-2xl bg-blue-600 text-white font-black text-sm shadow-xl shadow-blue-200 hover:bg-blue-700 transition uppercase tracking-widest">
                        ENVIAR SOLICITUD AHORA 🚀
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
