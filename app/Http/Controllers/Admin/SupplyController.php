<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supply;
use App\Models\SupplyLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupplyController extends Controller
{
    public function index()
    {
        $supplies = Supply::latest()->paginate(15);
        $totalItems = Supply::sum('stock');
        $totalValue = Supply::get()->sum(function($supply) {
            return $supply->stock * ($supply->unit_cost ?? 0);
        });
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
            'location' => 'nullable|string'
        ]);

        DB::transaction(function() use ($validated) {
            $supply = Supply::create($validated);
            if ($supply->stock > 0) {
                $supply->logs()->create([
                    'admin_id' => auth()->id(),
                    'quantity' => $supply->stock,
                    'action' => 'RESTOCK',
                    'notes' => 'Ingreso inicial de mercancía.'
                ]);
            }
        });

        return redirect()->route('admin.supplies.index')->with('success', '✅ INSUMO REGISTRADO: El stock ha sido actualizado.');
    }

    public function dispatch(Request $request, Supply $supply)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'quantity' => 'required|integer|min:1|max:' . $supply->stock,
            'action' => 'required|in:CONSUMPTION,LOAN',
            'equipment_tag' => 'nullable|string',
            'notes' => 'nullable|string'
        ]);

        DB::transaction(function() use ($request, $supply) {
            $supply->decrement('stock', $request->quantity);
            
            $supply->logs()->create([
                'user_id' => $request->user_id,
                'admin_id' => auth()->id(),
                'quantity' => $request->quantity,
                'action' => $request->action,
                'equipment_tag' => $request->equipment_tag,
                'status' => $request->action === 'LOAN' ? 'PENDING_RETURN' : 'COMPLETED',
                'notes' => $request->notes
            ]);
        });

        return back()->with('success', '✅ ENTREGA REGISTRADA: El inventario se ha descontado.');
    }

    public function restock(Request $request, Supply $supply)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string'
        ]);

        DB::transaction(function() use ($request, $supply) {
            $supply->increment('stock', $request->quantity);
            $supply->logs()->create([
                'admin_id' => auth()->id(),
                'quantity' => $request->quantity,
                'action' => 'RESTOCK',
                'notes' => $request->notes
            ]);
        });

        return back()->with('success', '✅ REABASTECIMIENTO EXITOSO.');
    }

    public function return(SupplyLog $log)
    {
        if ($log->status !== 'PENDING_RETURN') {
            return back()->with('error', '⚠️ Esta transacción ya fue procesada.');
        }

        DB::transaction(function() use ($log) {
            $log->supply->increment('stock', $log->quantity);
            $log->update(['status' => 'RETURNED']);
            
            // Log de retorno oficial
            $log->supply->logs()->create([
                'user_id' => $log->user_id,
                'admin_id' => auth()->id(),
                'quantity' => $log->quantity,
                'action' => 'RETURN',
                'status' => 'COMPLETED',
                'notes' => 'Devolución formal de material del préstamo #' . $log->id
            ]);
        });

        return back()->with('success', '✅ INSUMO REINTEGRADO AL STOCK: El inventario ha sido actualizado.');
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
            'location' => 'nullable|string'
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
