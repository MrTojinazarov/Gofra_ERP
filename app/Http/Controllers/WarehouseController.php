<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function index()
    {
        $warehouses = Warehouse::all();
        return view('admin.warehouses.index', compact('warehouses'));
    }

    public function create()
    {
        $users = User::all();
        return view('admin.warehouses.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
           'name' => 'required|string|max:255',
           'user_id' => 'required|exists:users,id',
        ]);

        $warehouse = Warehouse::create($request->all());
        return redirect()->route('warehouses.index')->with('create', 'Warehouse created successfully.');
    }

    public function edit(Warehouse $warehouse)
    {
        $users = User::all();
        return view('admin.warehouses.edit', compact('warehouse', 'users'));
    }

    public function update(Request $request, Warehouse $warehouse)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
        ]);

        $warehouse->update($request->all());
        return redirect()->route('warehouses.index')->with('update', 'Warehouse updated successfully.');
    }

    public function destroy(Warehouse $warehouse)
    {
        $warehouse->delete();
        return redirect()->route('warehouses.index')->with('delete', 'Warehouse deleted successfully.');
    }

    public function status(Warehouse $warehouse)
    {
        $warehouse->status = !$warehouse->status;
        $warehouse->save();
        return redirect()->route('warehouses.index')->with('update', 'Warehouse status updated');
    }
}
