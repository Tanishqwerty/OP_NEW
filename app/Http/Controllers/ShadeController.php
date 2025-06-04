<?php

namespace App\Http\Controllers;
use App\Models\Shade;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class ShadeController extends Controller
{
    public function index()
{
    $shades = Shade::all();
    return view('shades.index', compact('shades'));
}

public function create()
{
    $warehouses = Warehouse::all();
    return view('shades.create' ,compact('warehouses'));
}

public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|unique:shades,name',
        'base_price' => 'required|numeric|min:0',
       
    ]);

    Shade::create([
        'name' => $request->name,
        'code' => $request->code,
        'description' => $request->description,
        'base_price' => $request->base_price,
        'status' => $request->status == 'Active' ? 'Y' : 'N',
        'warehouse_id' => auth()->user()->warehouse_id, // important!
    ]);
    
    return redirect()->route('shades.index')->with('success', 'Shade added successfully!');
}
public function edit($id)
{
    $shade = Shade::findOrFail($id);
    $warehouses = Warehouse::all();
    return view('shades.edit', compact('shade', 'warehouses'));
}

public function update(Request $request, $id)
{
    $shade = Shade::findOrFail($id);
    
    $request->validate([
        'name' => 'required',
        'code' => 'nullable|string',
        'description' => 'nullable|string',
        'base_price' => 'required|numeric|min:0',
        'status' => 'required',
    ]);

    $request->merge([
        'status' => $request->status == 'Active' ? 'Y' : 'N',
    ]);
    
    $shade->update($request->all());

    return redirect()->route('shades.index')->with('success', 'Shade updated successfully!');
}

public function destroy($id)
{
    $shade = Shade::findOrFail($id)->delete();
  
    return redirect()->route('shades.index')->with('success', 'Shade deleted successfully!');
}
}
