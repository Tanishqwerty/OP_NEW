<?php

namespace App\Http\Controllers;
use App\Models\Embroidery;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class EmbroideryController extends Controller
{
    public function index()
    {
        $embroideries = Embroidery::with('warehouse')->get();
        return view('embroideries.index', compact('embroideries'));
    }

    // Show form to create new embroidery
    public function create()
    {
        $warehouses = Warehouse::all();
        return view('embroideries.create', compact('warehouses'));
    }

    // Store new embroidery
    public function store(Request $request)
    {
        $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'embroidery_name' => 'required|string|max:255',
            'additional_cost' => 'required|numeric|min:0',
            'base_price' => 'required|numeric|min:0',
        ]);

        $request->merge([
            'status' => $request->status == 'Active' ? 'Y' : 'N',
        ]);

        Embroidery::create($request->all());

        return redirect()->route('embroideries.index')->with('success', 'Embroidery added successfully.');
    }

    // // Show form to edit embroidery
    public function edit($id)
    {
        $embroidery = Embroidery::findOrFail($id);
        $warehouses = Warehouse::all();
        return view('embroideries.edit', compact('embroidery', 'warehouses'));
    }

    // Update embroidery
    public function update(Request $request, $id)
    {

        // Check the status and set it to "Y" if it's Active, else set it to "N"
        $request->merge([
            'status' => $request->status == 'Active' ? 'Y' : 'N',
        ]);


        $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'embroidery_name' => 'required|string|max:255',
            'additional_cost' => 'required|numeric|min:0',
            'base_price' => 'required|numeric|min:0',
            'status' => 'required|in:Y,N',
        ]);

        $embroidery = Embroidery::findOrFail($id);
        $embroidery->update($request->all());

        
        //$embroidery->update($validated);
        return redirect()->route('embroideries.index')->with('success', 'Embroidery updated successfully.');
    }

    // Delete embroidery
    public function destroy($id)
    {
        $embroidery = Embroidery::findOrFail($id);
        $embroidery->delete();

        return redirect()->route('embroideries.index')->with('success', 'Embroidery deleted successfully.');
    }
}
