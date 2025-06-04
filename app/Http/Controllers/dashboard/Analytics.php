<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class Analytics extends Controller
{
  public function index(Request $request)
  {
        $totalCustomers = Customer::count();
        $completedOrders = Order::where('status', 0)->count();
        $pendingDeliveries = Order::where('status',1)->count();

        $customers = Customer::latest()->take(10)->get();

        $status = $request->status;
        $ordersComplate = Order::with('customer')
            ->where('status', 0)
            ->latest()
            ->take(10)
            ->get();
        
        $status = $request->status;
        $ordersPending = Order::with('customer')
            ->where('status', 1)
            ->latest()
            ->take(10)
            ->get();
        
        // If your redirct for URL
        $user = Auth::user(); 
        $role = $user->role->name ?? null; 
        if ($role === 'user') {
            return redirect()->intended('user/dashboard');
        }
          // return view('content.dashboard.dashboards-analytics');
        return view('content.dashboard.dashboards-analytics', compact('totalCustomers', 'completedOrders', 'pendingDeliveries', 'customers', 'ordersComplate', 'ordersPending'));
  }
}
   
  

