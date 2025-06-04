<?php

namespace App\Http\Controllers;
use App\Models\Pattern;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class PatternController extends Controller
{
public function index()
{
    $allPatterns = Pattern::all();
    return view('patterns.index', compact('allPatterns'));
}

public function create()
{
    $warehouses = Warehouse::all();
    return view('patterns.create', compact('warehouses'));
}

public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'base_price' => 'required|numeric|min:0',

    ]);

    Pattern::create([
        'name' => $request->name,
        'code' => $request->code,
        'description' => $request->description,
        'base_price' => $request->base_price,
        'status' => $request->status == 'Active' ? "Y" : "N",
        'warehouse_id' => auth()->user()->warehouse_id, // important!
    ]);

        $request->merge([
            'status' => $request->status == 'Active' ? 'Y' : 'N',
        ]);

    return redirect()->route('patterns.index')->with('success', 'Pattern added!');
}

public function edit($id)
{
    $pattern = Pattern::findOrFail($id);
    $warehouses = Warehouse::all();
    return view('patterns.edit', compact('pattern', 'warehouses'));
}

public function update(Request $request, $id)
{
    // Check the status and set it to "Y" if it's Active, else set it to "N"
    $request->merge([
        'status' => $request->status == 'Active' ? 'Y' : 'N',
    ]);

    $pattern = Pattern::findOrFail($id);
    $pattern->update($request->all());

    return redirect()->route('patterns.index')->with('success', 'Pattern updated!');
}

public function destroy($id)
{
    Pattern::findOrFail($id)->delete();
    return redirect()->route('patterns.index')->with('success', 'Pattern deleted!');
}
}
