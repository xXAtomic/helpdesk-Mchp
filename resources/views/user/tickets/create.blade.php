@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow rounded-lg overflow-hidden border border-gray-100">
    <div class="px-8 py-6 border-b bg-gray-50">
        <h2 class="text-2xl font-bold text-gray-800">Crear una solicitud de Soporte</h2>
        <p class="text-gray-500 text-sm mt-1">Por favor describe tu problema lo más detallado posible.</p>
    </div>

    <form action="{{ route('user.tickets.store') ?? '#' }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
        @csrf
        
        <!-- Título -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Breve Resumen (Asunto) <span class="text-red-500">*</span></label>
            <input type="text" name="title" required placeholder="Ej: No tengo acceso a internet en el escritorio" 
                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 outline-none px-4 py-2 border">
        </div>

        <!-- Categoría y Prioridad en 2 columnas -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Categoría del Problema <span class="text-red-500">*</span></label>
                <select name="category_id" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border px-4 py-2">
                    <option value="">Selecciona una opción...</option>
                    @if(isset($categories))
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    @else
                        <!-- Dummy data -->
                        <option value="1">Hardware (Equipo Fisico)</option>
                        <option value="2">Software / Sistemas</option>
                        <option value="3">Redes y Conectividad</option>
                    @endif
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Impacto / Prioridad sugerida <span class="text-red-500">*</span></label>
                <select name="priority_id" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border px-4 py-2">
                    <option value="1" selected>Baja (No urgente, puedo seguir trabajando)</option>
                    <option value="2">Media (Molesto, pero puedo avanzar)</option>
                    <option value="3">Alta (Me impide realizar mis funciones nativas)</option>
                    <option value="4">Crítica (Falla masiva total)</option>
                </select>
            </div>
        </div>

        <!-- Descripción Completa -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Detalle Completo del Inconveniente <span class="text-red-500">*</span></label>
            <textarea name="description" rows="5" required placeholder="Explica detalladamente qué sucede, desde cuándo y qué estabas haciendo cuando ocurrió..." 
                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 outline-none px-4 py-2 border"></textarea>
        </div>

        <!-- Archivos Adjuntos -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Evidencias / Adjuntos (Capturas de pantalla, archivos, etc.)</label>
            <input type="file" name="attachments[]" multiple 
                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            <p class="text-xs text-gray-400 mt-2 italic">Puedes subir múltiples archivos de hasta 10MB c/u.</p>
        </div>

        <!-- Botones -->
        <div class="pt-4 flex justify-end">
            <a href="{{ route('user.tickets.index') ?? '#' }}" class="bg-white text-gray-700 border border-gray-300 px-4 py-2 rounded shadow-sm hover:bg-gray-50 mr-3">Cancelar</a>
            <button type="submit" class="bg-blue-600 text-white font-bold px-6 py-2 rounded shadow-sm hover:bg-blue-700 transition">Enviar Solicitud a Soporte</button>
        </div>
    </form>
</div>
@endsection
