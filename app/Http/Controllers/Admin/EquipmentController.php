<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Equipment;

class EquipmentController extends Controller
{
    public function index() {
        $items = Equipment::orderBy('created_at', 'desc')->get();
        return view('admin.inventory.index', compact('items'));
    }

    public function create() {
        return view('admin.inventory.create');
    }

    public function store(Request $request) {
        $data = $request->validate([
            'name' => 'required',
            'brand' => 'required',
            'serial_number' => 'required|unique:equipment',
            'inventory_code' => 'required|unique:equipment',
            'type' => 'required',
            'status' => 'required',
            'location' => 'nullable'
        ]);

        Equipment::create($request->all());
        return redirect()->route('admin.inventory.index')->with('success', 'Equipo registrado.');
    }

    public function edit($id) {
        $item = Equipment::findOrFail($id);
        return view('admin.inventory.edit', compact('item'));
    }

    public function update(Request $request, $id) {
        $item = Equipment::findOrFail($id);
        $item->update($request->all());
        return redirect()->route('admin.inventory.index')->with('success', 'Equipo actualizado.');
    }

    public function destroy($id) {
        $item = Equipment::findOrFail($id);
        $item->delete();
        return redirect()->route('admin.inventory.index')->with('success', 'Equipo eliminado.');
    }
}
