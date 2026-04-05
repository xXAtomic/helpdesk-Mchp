<x-app-layout>
    <div style="background: #fdfdfd; padding: 4rem 3.5rem; min-height: 100vh;">
        <div style="margin-bottom: 3rem; display: flex; align-items: center; gap: 1.5rem;">
            <a href="{{ route('admin.knowledge.index') }}" style="text-decoration: none; color: #94a3b8; font-size: 1.5rem;">←</a>
            <h1 style="font-size: 1.8rem; font-weight: 800; color: #111827;">Editando Manual: {{ $manual->title }}</h1>
        </div>

        <div style="max-width: 1000px; background: white; border-radius: 1.8rem; border: 1px solid #e5e7eb; padding: 4rem; box-shadow: 0 10px 40px rgba(0,0,0,0.02);">
            <form action="{{ route('admin.knowledge.update', $manual->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div style="margin-bottom: 2.5rem;">
                    <label style="display: block; font-size: 0.7rem; font-weight: 900; color: #64748b;">TÍTULO</label>
                    <input type="text" name="title" value="{{ $manual->title }}" required style="width: 100%; padding: 1rem; border-radius: 12px; border: 1px solid #e2e8f0;">
                </div>

                <div style="margin-bottom: 2.5rem;">
                    <label style="display: block; font-size: 0.7rem; font-weight: 900; color: #64748b;">CONTENIDO</label>
                    <textarea name="content" rows="12" required style="width: 100%; padding: 1.5rem; border-radius: 15px; border: 1px solid #e2e8f0;">{{ $manual->content }}</textarea>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 1.5rem;">
                    <button type="submit" class="btn-primary" style="padding: 1.1rem 3.5rem;">GUARDAR CAMBIOS 💾</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
