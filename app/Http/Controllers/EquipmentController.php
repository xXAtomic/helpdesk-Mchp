<?php
namespace App\Http\Controllers;
use App\Models\Equipment;
use Illuminate\Http\Request;
class EquipmentController extends Controller {
    public function index() {
        $equipment = Equipment::latest()->get();
        return view('inventory.index', compact('equipment'));
    }
    public function store(Request $request) {
        $data = $request->validate([
            'name' => 'required',
            'serial_number' => 'required|unique:equipment',
            'type' => 'required',
            'status' => 'required'
        ]);
        Equipment::create($data);
        return redirect()->back()->with('success', 'Equipo registrado.');
    }
    public function destroy($id) {
        $item = Equipment::findOrFail($id);
        $item->delete();
        return redirect()->back()->with('success', 'Equipo eliminado del sistema.');
    }
}
