@extends('layouts.app')

@section('content')
<div style="background: white; padding: 40px; border-radius: 20px; border: 2px solid #f3f4f6; max-width: 800px; margin: 20px auto; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
    
    <div style="text-align: center; margin-bottom: 30px;">
        <h1 style="font-size: 2rem; font-weight: 900; color: #020617; text-transform: uppercase;">Nueva Solicitud TI 🎟️</h1>
        <p style="color: #6b7280; font-size: 0.8rem; font-weight: bold; text-transform: uppercase;">Si ves este mensaje, el sistema está funcionando correctamente.</p>
    </div>

    <form action="{{ route('user.tickets.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div style="margin-bottom: 20px;">
            <label style="display: block; font-size: 0.65rem; font-weight: 900; color: #9ca3af; text-transform: uppercase; margin-bottom: 8px;">Asunto del Problema</label>
            <input type="text" name="title" required placeholder="Ej: Falla en internet.." 
                   style="width: 100%; padding: 15px; border-radius: 12px; border: 1px solid #e5e7eb; background: #f9fafb; font-weight: bold;">
        </div>

        <div style="display: grid; grid-template-cols: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div>
                <label style="display: block; font-size: 0.65rem; font-weight: 900; color: #9ca3af; text-transform: uppercase; margin-bottom: 8px;">Categoría</label>
                <select name="category_id" required style="width: 100%; padding: 15px; border-radius: 12px; border: 1px solid #e5e7eb; background: #f9fafb;">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label style="display: block; font-size: 0.65rem; font-weight: 900; color: #9ca3af; text-transform: uppercase; margin-bottom: 8px;">Urgencia</label>
                <select name="priority_id" required style="width: 100%; padding: 15px; border-radius: 12px; border: 1px solid #e5e7eb; background: #f9fafb;">
                    @foreach($priorities as $priority)
                        <option value="{{ $priority->id }}">{{ $priority->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; font-size: 0.65rem; font-weight: 900; color: #9ca3af; text-transform: uppercase; margin-bottom: 8px;">Mensaje Detallado</label>
            <textarea name="description" rows="5" required style="width: 100%; padding: 15px; border-radius: 12px; border: 1px solid #e5e7eb; background: #f9fafb;" placeholder="Describe aquí tu problema.."></textarea>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 30px;">
            <a href="{{ route('user.tickets.index') }}" style="padding: 15px 30px; font-weight: 900; font-size: 0.7rem; color: #9ca3af; text-decoration: none;">CANCELAR</a>
            <button type="submit" style="background: #020617; color: white; padding: 15px 40px; border-radius: 30px; font-weight: 900; font-size: 0.75rem; border: none; cursor: pointer;">ENVIAR TICKET →</button>
        </div>
    </form>
</div>
@endsection
