@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900 mb-2">📚 Base de Conocimientos</h2>
        <p class="text-gray-600">Encuentra guías y soluciones rápidas para problemas comunes.</p>
    </div>

    @if($articles->isEmpty())
        <div class="bg-blue-50 border-l-4 border-blue-400 p-6 rounded-r-lg shadow-sm">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="Value info svg..." />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-blue-700 font-medium">
                        Aún no hay artículos publicados. Por favor, vuelve más tarde.
                    </p>
                </div>
            </div>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($articles as $article)
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition cursor-pointer">
                    <span class="inline-block px-2 py-1 bg-blue-100 text-blue-700 text-xs font-bold rounded uppercase mb-3">
                        {{ $article->category->name ?? 'General' }}
                    </span>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $article->title }}</h3>
                    <p class="text-gray-600 text-sm line-clamp-3 mb-4">
                        {{ Str::limit(strip_tags($article->content), 150) }}
                    </p>
                    <div class="flex items-center text-blue-600 font-semibold text-sm hover:underline">
                        Leer guía completa &rarr;
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
