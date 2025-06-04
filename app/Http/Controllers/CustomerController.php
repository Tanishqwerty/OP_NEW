<?php

namespace App\Http\Controllers;
use App\Models\Customer;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller {

    
    // Display Customer List with Search and Dropdown
    public function index(Request $request)
    {
        $customers = Customer::with('city')->get();
        return view('customer.index', compact('customers'));
    }

    // Show Create Customer Form
    public function create(Request $request)
    {
        $referrer = $request->headers->get('referer');
        Log::info($referrer);
        if($referrer){
            $referrerPath = parse_url($referrer, PHP_URL_PATH);
            Log::info($referrerPath);
            session(['referrerPath' => $referrerPath]);
        }

        $cities = City::all();    
        return view('customer.create', compact('cities'));
    }

    // Store New Customer
    public function store(Request $request)
    {
       // try {
            // Log::info('1');
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:customers', 
                'mobile_number' => 'required|min:10|max:12|unique:customers',
                'address' => 'nullable|string|max:255',
                'city_id' => 'required|exists:cities,id',
                'country' => 'nullable|string|max:255',
                'postal' => 'nullable|string|max:255',
                'organization' =>'nullable|string|max:255',
                'dob' => 'nullable|date',
                'anniversary_date'=> 'nullable|date',
            ]);
        // } catch (\Exception $e) {
        //     Log::error('Error creating customer: ' . $e->getMessage());
        //     return back()->with('error', 'Something went wrong.');
        // }
        // Log::info('Validated data: ', $validated);
        
        // Log::info('2');
        
        Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile_number' => $request->mobile_number,
            'address' => $request->address,
            'city_id' => $request->city_id,
            'country' => $request->country,
            'postal'=> $request->postal,
            'is_active' => $request->is_active == 'Active' ? 1 : 0,
            'organization' => $request->organization,
            'dob' => $request->dob,
           'anniversary_date' => $request->anniversary_date
        ]);
        
        $referrerPath = session('referrerPath');
        session()->forget('referrerPath');
        Log::info($referrerPath);

        if ($referrerPath && strpos($referrerPath, '/order/create') !== false) {
            return redirect()->route('order.create')->with('success', 'Customer created successfully.');
        } else {
            return redirect()->route('customers.index')->with('success', 'Customer created successfully.');
        }
    }

    // Edit Customer
    public function edit($id)
    {
          $customer = Customer::findOrFail($id);
          $cities = City::all(); 
        return view('customer.edit', compact('customer','cities'));
    }

    // Update Customer
    public function update(Request $request, $id)
    {
         Log::info('1');
        $validated = $request->validate([
            'name' => 'required|string|max:255', 
            'email' => 'required|email|unique:customers,email,' . $id, 
            'mobile_number' => 'required|min:10|max:12|unique:customers,mobile_number,' . $id,
            'address' => 'nullable|string|max:255',
            'city_id' => 'required|exists:cities,id',
            'country' => 'nullable|string|max:255',
            'postal' => 'nullable|string|max:255',
            'organization' =>'nullable|string|max:255',
            'dob' => 'nullable|date',
            'anniversary_date'=> 'nullable|date',
        ]);
 Log::info('2');
        $request->merge([
            'is_active' => $request->is_active == 'Active' ? 1 : 0
        ]);
 Log::info('3');
        $customer = Customer::findOrFail($id);
         Log::info('4');
        $customer->update($request->all());
          Log::info('5');
        return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
    }

    // Delete Customer
    public function destroy($id)
    {
        Customer::findOrFail($id)->delete();
        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
    }

    // Get All Customers for Dropdown
    public function customerDropdown()
    {
        $customers = Customer::all();
        return view('customers.dropdown', compact('customers'));
    }
}

