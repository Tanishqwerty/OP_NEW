<?php

namespace App\Http\Controllers;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Shade;
use App\Models\Pattern;
use App\Models\Size;
use App\Models\PaymentMethod;
use App\Models\Embroidery;
use App\Models\User;
use App\Models\Product;
use App\Models\Warehouse;
use App\Models\OrderItem;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use PDF;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    public function index() {
        $user = Auth::user();
        $role = $user->role->name ?? null;
        $orders = [];
        if ($role === 'admin') {
            $orders = Order::with('paymentMethod', 'customer')->get();
        } elseif ($role == 'user') {
            $orders = Order::with('paymentMethod', 'customer')->where('user_id', $user->id)->get();
        }
        
        $paymentMethods = PaymentMethod::where('status', 1)->get();

        $customers = Customer::all();
        return view('orders.index', compact('orders', 'paymentMethods','customers'));
     }

     public function create()
     {
        $customers = Customer::with("city")->get();
        // $customers = User::all();
        $paymentMethods = PaymentMethod::where('status', 1)->get();
        $shades = Shade::all();
        $patterns = Pattern::all();
        $sizes = Size::all();
        $embroideries = Embroidery::all();
        $products = Product::all();
        //$warehouses = Warehouse::all();

        $order = null;

        return view('orders.create', compact( 'customers', 'shades', 'patterns', 'sizes', 'embroideries', 'paymentMethods', 'products'));
     }

     public function store(Request $request)
     {

        $totalPrice = 0;

         try {

            Log::info('1');
            $request->validate([
                'order_number' => 'required|string',
                'order_date' => 'required|date',
                'delivery_date' => 'required|date',
                'payment_id' => 'required|nullable',
                'status' => 'required|string|in:pending,completed',
                'delivery_charge' => 'nullable|numeric',
                'total_amount' => 'required|numeric',
                'customer_id' => 'required|string',
                'discount' => 'nullable|numeric',
                'payable_amount' => 'nullable|numeric',
            ]);

            } catch (Exception $e) {
                 Log::error($e->getMessage());

                 //return redirect()->back()->with('error', 'Error creating order: ' . $e->getMessage());
            }

            $user = Auth::user();

            $warehouse_id = null;
            if($user->role->name =='user'){
                $warehouse_id = session('selected_warehouse_id');
            }

            $request->merge([
                'status' => 1,
                'user_id' =>$user->id,
                'warehouse_id' => $warehouse_id
            ]);

            if($user->role->name =='user'){
                $request->merge([
                    'warehouse_id' => $warehouse_id
                ]);
            }

            $order = Order::create($request->all());

            session(['order_id' => $order->id]);

            Log::info('2');

            $products = $request->input('products');

            foreach ($request->products as $product) {
                $orderItemData = [
                    'order_id' => $order->id,
                    'product_id' => $product['product_id'],
                    'user_id' => $user->id,
                    'price' => $product['price'],
                    'quantity' => $product['quantity'],
                    'other_charges' => $product['other_charges'] ?? 0,
                    'total_charges' => $product['total_charges'],
                    'shade_id' => $product['shade_id'] ?? null,
                    'size_id' => $product['size_id'] ?? null,
                    'pattern_id' => $product['pattern_id'] ?? null,
                    'embroidery_id' => $product['embroidery_id'] ?? null,
                ];

                if ($user->role->name == 'user') {
                    $orderItemData['warehouse_id'] = $warehouse_id;
                }

                OrderItem::create($orderItemData);
            }


            Log::info('5 : Complated');

        return redirect()->back()->with('success', 'Order submitted successfully');
       // return redirect()->route('orders.create')->with('success', 'Order created successfully.');
    }
    public function edit($id)
    {
        $order = Order::with('orderItems')->findOrFail($id);
        //$warehouses = Warehouse::all();
        $products = Product::all();
        $shades = Shade::all();
        $sizes = Size::all();
        $patterns = Pattern::all();
        $embroideries = Embroidery::all();
        $paymentMethods = PaymentMethod::all();
        $orderItems = \App\Models\OrderItem::where('order_id', $order->id)->get();
        $customers = Customer::all();

        return view('orders.edit', compact('order', 'products',  'orderItems' , 'paymentMethods', 'shades', 'sizes', 'patterns', 'embroideries', 'customers'));
    }

    public function update(Request $request, $id)
    {
        // Log::info('2 : Complated');
        // Validate the incoming request data
        $validated = $request->validate([
            'order_number' => 'required|string|max:255',
            'order_date' => 'required|date',
            'delivery_date' => 'required|date',
            'payment_id' => 'required|integer|exists:paymentmethods,id',
            'status' => 'required|string|in:pending,completed',
            'delivery_charge' => 'nullable|numeric',
            'total_amount' => 'required|numeric',
            'customer_id' => 'required|string',
            'discount' => 'nullable|numeric',
            'payable_amount' => 'nullable|numeric',
        ]);

        $user = Auth::user();
        $request->merge([
            'status' => 'pending' ? 1 : 0,
            'user_id' =>$user->id,
            'warehouse_id' => session('selected_warehouse_id'),
        ]);
        // Log::info('3 : Complated');

        // Find the order by ID
        $order = Order::findOrFail($id);

        // Update order header fields
        $order->order_number = $validated['order_number'];
        $order->order_date = $validated['order_date'];
        $order->delivery_date = $validated['delivery_date'];
        $order->warehouse_id = session('selected_warehouse_id');
        $order->payment_id = $validated['payment_id'];
        $order->status = $validated['status'] == 'pending' ? 1 : 0;
        $order->total_amount = $validated['total_amount'];
        $order->customer_id = $validated['customer_id'];
        $order->delivery_charge = $validated['delivery_charge'];
        $order->payable_amount = $validated['payable_amount'];
        $order->discount = $validated['discount'];
        $order->save();
        // Log::info('4 : Complated');
        // Get the currently authenticated user
        $user = auth()->user();

        // Delete existing order items (assuming full replacement)
        $order->orderItems()->delete();

        $user = Auth::user();

        $warehouse_id = null;
        if($user->role->name =='user'){
            $warehouse_id = session('selected_warehouse_id');
        }

        $request->merge([
            'user_id' =>$user->id,
            'warehouse_id' => $warehouse_id
        ]);

        if($user->role->name =='user'){
            $request->merge([
                'warehouse_id' => $warehouse_id
            ]);
        }

        // Recreate order items
        foreach ($request->products as $product) {

            // Log::info($product);

            OrderItem::create([
                'warehouse_id' => session('selected_warehouse_id'),
                'order_id' => $order->id,
                'product_id' => $product['product_id'],
                'user_id' => $user->id,
                'price' => $product['price'],
                'quantity' => $product['quantity'],
                'other_charges' => $product['other_charges'] ?? 0,
                'total_charges' => $product['total_charges'],
                'shade_id' => $product['shade_id'] ?? null,
                'size_id' => $product['size_id'] ?? null,
                'pattern_id' => $product['pattern_id'] ?? null,
                'embroidery_id' => $product['embroidery_id'] ?? null,
                //'delivery_date' => now(),
            ]);
        }
        // Log::info('5 : Complated');
        return redirect()->route('order.index')->with('success', 'Order updated successfully.');
    }

    public function destroy($id)
    {
        $order = Order::with('orderItems')->findOrFail($id);
       // $order = Order::findOrFail($id);
        $order->orderItems()->delete(); // delete items first
        $order->delete(); // then delete order

    return redirect()->route('order.index')->with('success', 'Order deleted successfully.');
    }

    public function generatePDF($id)
    {
        // Fetch order details from database (including related customer, items, etc.)
        $order = Order::with(['customer', 'items'])->findOrFail($id);

        $total_in_words = $this->convertNumberToWords($order->total_amount);

        // Define data to be passed to the PDF view
        $data = [
            'order' => $order,
            'customer' =>$order->customer,
            'amount_in_words' =>$total_in_words,

        ];

        // Load the view and generate PDF
        $pdf = Pdf::loadView('orders.order_pdf', $data);

        // Download PDF directly
        return $pdf->download('Order Invoice.pdf'.$order->id.'.pdf');
    }

    public function downloadInvoice($id)
    {

         // Fetch order details from database (including related customer, items, etc.)
        $order = Order::with(['customer', 'items'])->findOrFail($id);

        $total_in_words = $this->convertNumberToWords($order->total_amount);

        // Define data to be passed to the PDF view
        $data = [
            'order' => $order,
            'customer' =>$order->customer,
            'amount_in_words' =>$total_in_words
        ];

         // Load the view and generate PDF
        $pdf = Pdf::loadView('orders.order_pdf', $data);

        // Define the directory and file path
        $directory = 'public/invoices'; // Store in public storage
        $pdfFileName = 'invoice_' . $order->customer->name . '.pdf';
        $pdfPath = $directory . '/' . $pdfFileName;

        // Ensure the directory exists
        if (!Storage::exists($directory)) {
            Storage::makeDirectory($directory, 0755, true); // Create directory with permissions
        }

         // Save PDF file in the directory
        Storage::put($pdfPath, $pdf->output());

        // Generate URL for downloading
        $pdfUrl = Storage::url($pdfPath);

        return response()->json([
            'url' => $pdfUrl,
            'username' =>$order->customer->name,
            'mobile' =>$order->customer->mobile_number
        ]);
    }

    // Helper Function to Convert Number to Words (Custom)
    private function convertNumberToWords($number)
    {
        $words = [
            0 => 'zero', 1 => 'one', 2 => 'two', 3 => 'three', 4 => 'four',
            5 => 'five', 6 => 'six', 7 => 'seven', 8 => 'eight', 9 => 'nine',
            10 => 'ten', 11 => 'eleven', 12 => 'twelve', 13 => 'thirteen',
            14 => 'fourteen', 15 => 'fifteen', 16 => 'sixteen', 17 => 'seventeen',
            18 => 'eighteen', 19 => 'nineteen', 20 => 'twenty',
            30 => 'thirty', 40 => 'forty', 50 => 'fifty', 60 => 'sixty',
            70 => 'seventy', 80 => 'eighty', 90 => 'ninety'
        ];

        if ($number < 21) {
            return ucfirst($words[$number]);
        } elseif ($number < 100) {
            return ucfirst($words[floor($number / 10) * 10]) . ($number % 10 ? ' ' . $words[$number % 10] : '');
        } elseif ($number < 1000) {
            return ucfirst($words[floor($number / 100)]) . ' hundred' . ($number % 100 ? ' and ' . $this->convertNumberToWords($number % 100) : '');
        } elseif ($number < 100000) {
            return $this->convertNumberToWords(floor($number / 1000)) . ' thousand' . ($number % 1000 ? ' ' . $this->convertNumberToWords($number % 1000) : '');
        } elseif ($number < 10000000) {
            return $this->convertNumberToWords(floor($number / 100000)) . ' lakh' . ($number % 100000 ? ' ' . $this->convertNumberToWords($number % 100000) : '');
        } else {
            return $this->convertNumberToWords(floor($number / 10000000)) . ' crore' . ($number % 10000000 ? ' ' . $this->convertNumberToWords($number % 10000000) : '');
        }
    }

}
