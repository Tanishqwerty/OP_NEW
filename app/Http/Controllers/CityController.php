<?php

namespace App\Http\Controllers;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
   
    public function index()
    {
        $cities = City::all();
        return view('cities.index', compact('cities'));
    }

  
    public function create()
    {
       return view('cities.create');   
    }

    public function store(Request $request)
    {
        // $request->validate([
        //     'city_name' => 'required|unique:cities', 
        //     'delivery_charge' => 'required|numeric', 
        //     'status' => 'required'
        // ]);

        City::create($request->all());
        return redirect()->route('cities.index')->with('success', 'City created successfully.');
    }

    public function edit(City $city)
    {
         $customer = Customer::findOrFail($id);
         $cities = City::where('status', 'Active')->get();
         return view('customers.edit', compact('customer', 'cities'));
    }
   
    public function update(Request $request, City $city) 
      {
         $request->validate([
            'city_name' => 'required|unique:cities', 
            'delivery_charge' => 'required|numeric', 
            'status' => 'required'
        ]);
        $city->update($request->all());
        return redirect()->route('cities.index')->with('success', 'City updated successfully.');
      }
    public function destroy(City $city) 
    {
        $city->delete();
        return redirect()->route('cities.index')->with('success', 'City deleted successfully.');
    }
}
