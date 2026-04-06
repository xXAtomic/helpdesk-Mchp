@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-12 px-6">
    <!-- Header Minimalista -->
    <div class="mb-12">
        <h1 class="text-4xl font-black text-slate-900 tracking-tighter italic uppercase mb-2">
            Editar <span class="text-indigo-600">Activo</span>
        </h1>
        <p class="text-slate-500 font-medium tracking-wide">Modificando registro: {{ $item->asset_tag }}</p>
    </div>

    <!-- Formulario de Edición Pro-SaaS -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden transition-all hover:shadow-md">
        <form action="{{ route('admin.inventory.update', $item->id) }}" method="POST" class="p-8 space-y-8">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Tag de Activo -->
                <div class="space-y-2">
                    <label class="text-[0.7rem] font-bold text-slate-400 uppercase tracking-widest ml-1">Asset Tag / ID</label>
                    <input type="text" name="asset_tag" value="{{ $item->asset_tag }}" required
                        class="w-full px-5 py-4 bg-slate-50 border-none rounded-xl text-slate-900 font-semibold focus:ring-2 focus:ring-indigo-500 transition-all">
                </div>

                <!-- Tipo -->
                <div class="space-y-2">
                    <label class="text-[0.7rem] font-bold text-slate-400 uppercase tracking-widest ml-1">Tipo de Dispositivo</label>
                    <select name="type" required
                        class="w-full px-5 py-4 bg-slate-50 border-none rounded-xl text-slate-900 font-semibold focus:ring-2 focus:ring-indigo-500 transition-all">
                        <option value="Laptop" {{ $item->type == 'Laptop' ? 'selected' : '' }}>Laptop</option>
                        <option value="Desktop" {{ $item->type == 'Desktop' ? 'selected' : '' }}>Desktop</option>
                        <option value="Monitor" {{ $item->type == 'Monitor' ? 'selected' : '' }}>Monitor</option>
                        <option value="Impresora" {{ $item->type == 'Impresora' ? 'selected' : '' }}>Impresora</option>
                        <option value="Smartphone" {{ $item->type == 'Smartphone' ? 'selected' : '' }}>Smartphone</option>
                        <option value="Servidor" {{ $item->type == 'Servidor' ? 'selected' : '' }}>Servidor</option>
                        <option value="Otro" {{ $item->type == 'Otro' ? 'selected' : '' }}>Otro</option>
                    </select>
                </div>

                <!-- Marca -->
                <div class="space-y-2">
                    <label class="text-[0.7rem] font-bold text-slate-400 uppercase tracking-widest ml-1">Marca</label>
                    <input type="text" name="brand" value="{{ $item->brand }}" required
                        class="w-full px-5 py-4 bg-slate-50 border-none rounded-xl text-slate-900 font-semibold focus:ring-2 focus:ring-indigo-500 transition-all">
                </div>

                <!-- Modelo -->
                <div class="space-y-2">
                    <label class="text-[0.7rem] font-bold text-slate-400 uppercase tracking-widest ml-1">Modelo</label>
                    <input type="text" name="model" value="{{ $item->model }}" required
                        class="w-full px-5 py-4 bg-slate-50 border-none rounded-xl text-slate-900 font-semibold focus:ring-2 focus:ring-indigo-500 transition-all">
                </div>

                <!-- Serial -->
                <div class="space-y-2">
                    <label class="text-[0.7rem] font-bold text-slate-400 uppercase tracking-widest ml-1">Número de Serie</label>
                    <input type="text" name="serial_number" value="{{ $item->serial_number }}" required
                        class="w-full px-5 py-4 bg-slate-50 border-none rounded-xl text-slate-900 font-semibold focus:ring-2 focus:ring-indigo-500 transition-all">
                </div>

                <!-- Estado -->
                <div class="space-y-2">
                    <label class="text-[0.7rem] font-bold text-slate-400 uppercase tracking-widest ml-1">Estado</label>
                    <select name="status" required
                        class="w-full px-5 py-4 bg-slate-50 border-none rounded-xl text-slate-900 font-semibold focus:ring-2 focus:ring-indigo-500 transition-all">
                        <option value="Operativo" {{ $item->status == 'Operativo' ? 'selected' : '' }}>Operativo</option>
                        <option value="En Reparación" {{ $item->status == 'En Reparación' ? 'selected' : '' }}>En Reparación</option>
                        <option value="De Baja" {{ $item->status == 'De Baja' ? 'selected' : '' }}>De Baja</option>
                        <option value="Perdido" {{ $item->status == 'Perdido' ? 'selected' : '' }}>Perdido</option>
                    </select>
                </div>

                <!-- Ubicación -->
                <div class="space-y-2">
                    <label class="text-[0.7rem] font-bold text-slate-400 uppercase tracking-widest ml-1">Ubicación Actual</label>
                    <input type="text" name="location" value="{{ $item->location }}" required
                        class="w-full px-5 py-4 bg-slate-50 border-none rounded-xl text-slate-900 font-semibold focus:ring-2 focus:ring-indigo-500 transition-all">
                </div>

                <!-- Asignación de Usuario -->
                <div class="space-y-2">
                    <label class="text-[0.7rem] font-bold text-slate-400 uppercase tracking-widest ml-1">Asignar a Usuario</label>
                    <select name="user_id"
                        class="w-full px-5 py-4 bg-slate-50 border-none rounded-xl text-slate-900 font-semibold focus:ring-2 focus:ring-indigo-500 transition-all">
                        <option value="">Sin asignar</option>
                        @foreach(\App\Models\User::all() as $user)
                            <option value="{{ $user->id }}" {{ $item->user_id == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Botones de Acción -->
            <div class="pt-6 flex gap-4">
                <button type="submit"
                    class="flex-1 bg-slate-900 hover:bg-slate-800 text-white font-black py-5 rounded-xl transition-all shadow-lg hover:shadow-slate-200 uppercase tracking-widest italic">
                    Actualizar Activo
                </button>
                <a href="{{ route('admin.inventory.index') }}"
                    class="px-8 bg-slate-100 hover:bg-slate-200 text-slate-500 font-bold py-5 rounded-xl transition-all uppercase tracking-widest flex items-center">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
