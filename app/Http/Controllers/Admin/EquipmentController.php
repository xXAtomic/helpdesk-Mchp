<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Asset;
use App\Services\AssetService;

class EquipmentController extends Controller
{
    protected $assetService;

    public function __construct(AssetService $assetService)
    {
        $this->assetService = $assetService;
    }

    public function index(Request $request) 
    {
        $items = $this->assetService->getFilteredAssets($request->only(['search', 'type', 'status']));
        return view('admin.inventory.index', compact('items'));
    }

    public function create() 
    {
        return view('admin.inventory.create');
    }

    public function store(Request $request) 
    {
        $validated = $request->validate([
            'asset_tag'           => 'required|unique:assets',
            'type'                => 'required',
            'brand'               => 'required',
            'model'               => 'required',
            'serial_number'       => 'required|unique:assets',
            'location'            => 'required',
            'purchase_cost'       => 'nullable|numeric|min:0',
            'purchased_at'        => 'nullable|date',
            'last_maintenance_at' => 'nullable|date',
            'next_maintenance_at' => 'nullable|date|after_or_equal:last_maintenance_at',
            'entity'              => 'required|in:IASD,FESDG',
            'status'              => 'nullable|string'
        ]);

        $this->assetService->createAsset($validated);

        return redirect()->route('admin.inventory.index')->with('success', '✅ ACTIVO REGISTRADO CORRECTAMENTE.');
    }

    public function show($id) 
    {
        $item = Asset::with(['user', 'logs.user'])->findOrFail($id);
        return view('admin.inventory.show', compact('item'));
    }

    public function edit($id) 
    {
        $item = Asset::findOrFail($id);
        return view('admin.inventory.edit', compact('item'));
    }

    public function update(Request $request, $id) 
    {
        $asset = Asset::findOrFail($id);
        
        $request->validate([
            'purchase_cost'       => 'nullable|numeric|min:0',
            'purchased_at'        => 'nullable|date',
            'last_maintenance_at' => 'nullable|date',
            'next_maintenance_at' => 'nullable|date',
        ]);

        $this->assetService->updateAsset($asset, $request->all());

        return redirect()->route('admin.inventory.index')->with('success', '✅ EQUIPO ACTUALIZADO.');
    }

    public function destroy($id) 
    {
        Asset::findOrFail($id)->delete();
        return redirect()->route('admin.inventory.index')->with('success', '🗑️ EQUIPO ELIMINADO.');
    }

    public function generateLabel($id) 
    {
        $item = Asset::findOrFail($id);
        return view('admin.inventory.label', compact('item'));
    }

    public function storeMaintenance(Request $request, $id) 
    {
        $validated = $request->validate([
            'details'             => 'required|string|min:10',
            'next_maintenance_at' => 'required|date|after:today',
            'status'              => 'nullable|string'
        ]);

        $asset = Asset::findOrFail($id);
        $this->assetService->recordMaintenance($asset, $validated);

        return redirect()->back()->with('success', '🔧 MANTENIMIENTO REGISTRADO CON ÉXITO.');
    }
}
