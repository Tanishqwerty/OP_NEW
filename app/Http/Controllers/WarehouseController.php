<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Warehouse;


class WarehouseController extends Controller
{
    public function index()
    {
        $warehouses = Warehouse::all();
        return view('warehouses.index', compact('warehouses'));
    }

    public function create()
    {
            $users = User::all();
            $products = Product::all();
            $warehouses = Warehouse::all();
        return view('warehouses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'code' => 'required|string|unique:warehouses,code',
        ]);

        Warehouse::create($request->only('name', 'code'));

        return redirect()->route('warehouses.index')->with('success', 'Warehouse created.');
    }

    public function edit(Warehouse $warehouse)
    {
        return view('warehouses.edit', compact('warehouse'));
    }

    public function update(Request $request, Warehouse $warehouse)
    {
        $request->validate([
            'name' => 'required|string',
            'code' => 'required|string|unique:warehouses,code,' . $warehouse->id,
        ]);

        $warehouse->update($request->only('name', 'code'));

        return redirect()->route('warehouses.index')->with('success', 'Warehouse updated.');
    }

    public function destroy(Warehouse $warehouse)
    {
        $warehouse->delete();
        return redirect()->route('warehouses.index')->with('success', 'Warehouse deleted.');
    }
}
