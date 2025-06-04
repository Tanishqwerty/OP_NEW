<?php

namespace App\Http\Controllers;
use App\Models\Size;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    public function index()
    {
        $allSizes = Size::all();
        return view('sizes.index', compact('allSizes'));
    }

    public function create()
    {
        $warehouses = Warehouse::all();
        return view('sizes.create' ,compact('warehouses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'base_price' => 'required|numeric|min:0',
        ]);
        Size::create([
            'name' => $request->name,
            'code' => $request->code,
            'description' => $request->description,
            'base_price' => $request->base_price,
            'status' => $request->status,
            'warehouse_id' => auth()->user()->warehouse_id, // important!
            'status' => $request->status == 'Active' ? 'Y' : 'N',
        ]);

        return redirect()->route('sizes.index')->with('success', 'Size added successfully!');
    }

    public function edit($id)
    {
        $size = Size::findOrFail($id);
        $warehouses = Warehouse::all();
        return view('sizes.edit', compact('size' , 'warehouses'));
    }

    public function update(Request $request, $id)
    {
        $size = Size::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50',
            'warehouse_id' => 'required|exists:warehouses,id',
            'base_price' => 'required|numeric|min:0',
            // Add more validations if needed
        ]);

        $request->merge([
            'status' => $request->status == 'Active' ? 'Y' : 'N',
        ]);

        $size->update($request->all());

    return redirect()->route('sizes.index')->with('success', 'Size updated!');
    }
    public function destroy($id)
    {
        Size::findOrFail($id)->delete();
        return redirect()->route('sizes.index')->with('success', 'Size deleted!');
    }
//     public function show($id)
// {
//     $size = Size::findOrFail($id);
//     return view('sizes.show', compact('size'));
// }
}
