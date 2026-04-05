<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Asset;

class EquipmentController extends Controller
{
    public function index() {
        $items = Asset::orderBy('created_at', 'desc')->get();
        return view('admin.inventory.index', compact('items'));
    }

    public function create() {
        return view('admin.inventory.create');
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
            'brand' => 'required',
            'serial_number' => 'required|unique:assets',
            'code' => 'required|unique:assets',
            'type' => 'required',
            'status' => 'required',
        ]);

        Asset::create($request->all());
        return redirect()->route('admin.inventory.index')->with('success', 'Equipo registrado.');
    }

    public function edit($id) {
        $item = Asset::findOrFail($id);
        return view('admin.inventory.edit', compact('item'));
    }

    public function update(Request $request, $id) {
        $item = Asset::findOrFail($id);
        $item->update($request->all());
        return redirect()->route('admin.inventory.index')->with('success', 'Equipo actualizado.');
    }

    public function destroy($id) {
        $item = Asset::findOrFail($id);
        $item->delete();
        return redirect()->route('admin.inventory.index')->with('success', 'Equipo eliminado.');
    }
}
