<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Asset;

class EquipmentController extends Controller
{
    public function index(Request $request) {
        $query = Asset::query();

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('asset_tag', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%")
                  ->orWhere('serial_number', 'like', "%{$search}%")
                  ->orWhereHas('user', function($qu) use ($search) {
                      $qu->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->has('type') && !empty($request->type)) {
            $query->where('type', $request->type);
        }

        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        $items = $query->with('user')->orderBy('created_at', 'desc')->get();
        return view('admin.inventory.index', compact('items'));
    }

    public function create() {
        return view('admin.inventory.create');
    }

    public function store(Request $request) {
        $request->validate([
            'asset_tag'     => 'required|unique:assets',
            'type'          => 'required',
            'brand'         => 'required',
            'model'         => 'required',
            'serial_number' => 'required|unique:assets',
            'location'      => 'required',
            'purchase_cost' => 'nullable|numeric|min:0',
            'entity'        => 'required|in:IASD,FESDG',
        ]);

        $data = $request->all();
        if (!isset($data['status'])) {
            $data['status'] = 'Operativo';
        }

        $asset = Asset::create($data);

        // Registro de Auditoría ✨
        \App\Models\AssetLog::create([
            'asset_id' => $asset->id,
            'user_id'  => auth()->id(),
            'action'   => 'CREATE',
            'new_data' => $asset->toArray(),
            'details'  => 'Activo registrado por primera vez.'
        ]);

        return redirect()->route('admin.inventory.index')->with('success', 'Activo registrado correctamente en el sistema.');
    }

    public function show($id) {
        $item = Asset::with(['user', 'logs.user'])->findOrFail($id);
        return view('admin.inventory.show', compact('item'));
    }

    public function edit($id) {
        $item = Asset::with('logs.user')->findOrFail($id);
        return view('admin.inventory.edit', compact('item'));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'purchase_cost' => 'nullable|numeric|min:0',
        ]);

        $item = Asset::findOrFail($id);
        $oldData = $item->toArray();
        
        $item->update($request->all());
        
        // Registro de Auditoría ✨
        \App\Models\AssetLog::create([
            'asset_id' => $item->id,
            'user_id'  => auth()->id(),
            'action'   => 'UPDATE',
            'old_data' => $oldData,
            'new_data' => $item->toArray(),
            'details'  => 'Actualización de datos del equipo.'
        ]);

        return redirect()->route('admin.inventory.index')->with('success', 'Equipo actualizado.');
    }

    public function destroy($id) {
        $item = Asset::findOrFail($id);
        $item->delete();
        return redirect()->route('admin.inventory.index')->with('success', 'Equipo eliminado.');
    }

    /**
     * Genera una etiqueta imprimible con Código QR para el activo. ✨
     */
    public function generateLabel($id) {
        $item = Asset::findOrFail($id);
        return view('admin.inventory.label', compact('item'));
    }

    /**
     * Registra un mantenimiento preventivo para el equipo. ✨
     */
    public function storeMaintenance(Request $request, $id) {
        $request->validate([
            'details'             => 'required|string|min:10',
            'next_maintenance_at' => 'required|date|after:today',
        ]);

        $asset = Asset::findOrFail($id);
        $oldData = $asset->toArray();

        // Actualizamos las fechas del activo
        $asset->update([
            'last_maintenance_at' => now(),
            'next_maintenance_at' => $request->next_maintenance_at,
            'status'              => $request->status ?? $asset->status,
        ]);

        // Generamos el registro en el historial (AssetLog)
        \App\Models\AssetLog::create([
            'asset_id' => $asset->id,
            'user_id'  => auth()->id(),
            'action'   => 'MAINTENANCE',
            'old_data' => $oldData,
            'new_data' => $asset->toArray(),
            'details'  => "MANTENIMIENTO REALIZADO: " . $request->details
        ]);

        return redirect()->back()->with('success', 'Mantenimiento registrado con éxito. El ciclo de vida del equipo ha sido actualizado.');
    }
}
