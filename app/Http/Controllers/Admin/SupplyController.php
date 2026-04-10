<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supply;
use App\Models\SupplyLog;
use App\Models\User;
use App\Services\InventoryService;
use Illuminate\Http\Request;

class SupplyController extends Controller
{
    private $inventory;

    public function __construct(InventoryService $inventory)
    {
        $this->inventory = $inventory;
    }

    public function index()
    {
        $supplies = Supply::latest()->paginate(15);
        $totalItems = Supply::sum('stock');
        $totalValue = Supply::get()->sum(fn($s) => $s->stock * ($s->unit_cost ?? 0));
        $lowStock = Supply::whereColumn('stock', '<=', 'min_stock')->count();
        $uniqueTypes = Supply::distinct('type')->count();

        return view('admin.supplies.index', compact(
            'supplies', 'lowStock', 'totalItems', 'totalValue', 'uniqueTypes'
        ));
    }

    public function create()
    {
        return view('admin.supplies.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
            'type' => 'required|string',
            'stock' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
            'location' => 'nullable|string',
            'unit_cost' => 'nullable|numeric|min:0'
        ]);

        $this->inventory->register($validated);

        return redirect()->route('admin.supplies.index')->with('success', '✅ INSUMO REGISTRADO: Alta de inventario exitosa.');
    }

    public function dispatch(Request $request, Supply $supply)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'quantity' => 'required|integer|min:1|max:' . $supply->stock,
            'action' => 'required|in:CONSUMPTION,LOAN',
            'equipment_tag' => 'nullable|string',
            'notes' => 'nullable|string'
        ]);

        $this->inventory->consume($supply, $validated);

        return back()->with('success', '✅ ENTREGA REGISTRADA: Inventario actualizado.');
    }

    public function restock(Request $request, Supply $supply)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string'
        ]);

        $this->inventory->restock($supply, $validated['quantity'], $validated['notes'] ?? null);

        return back()->with('success', '✅ REABASTECIMIENTO EXITOSO.');
    }

    public function return(SupplyLog $log)
    {
        if ($log->status !== 'PENDING_RETURN') {
            return back()->with('error', '⚠️ Esta transacción ya fue procesada.');
        }

        $this->inventory->handleReturn($log);

        return back()->with('success', '✅ INSUMO REINTEGRADO AL STOCK.');
    }

    public function show(Supply $supply)
    {
        $supply->load(['logs.user', 'logs.admin']);
        $users = User::orderBy('name')->get();
        return view('admin.supplies.show', compact('supply', 'users'));
    }

    public function edit(Supply $supply)
    {
        return view('admin.supplies.edit', compact('supply'));
    }

    public function update(Request $request, Supply $supply)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
            'type' => 'required|string',
            'min_stock' => 'required|integer|min:0',
            'location' => 'nullable|string',
            'unit_cost' => 'nullable|numeric|min:0'
        ]);

        $supply->update($validated);

        return redirect()->route('admin.supplies.index')->with('success', '✅ DATOS ACTUALIZADOS.');
    }

    public function destroy(Supply $supply)
    {
        $supply->delete();
        return redirect()->route('admin.supplies.index')->with('success', '🗑️ INSUMO ELIMINADO.');
    }
}
