<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    // Show all items (optional)
    public function index()
    {
        $items = OrderItem::with('order', 'product')->get();
        return view('order_items.index', compact('items'));
    }

    public function store()
    {
        foreach ($request->products as $product) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product['product_id'],
                'user_id' => auth()->id(),
                'price' => $product['price'],
                'quantity' => $product['quantity'],
                'other_charges' => $product['other_charges'] ?? 0,
                'total_charges' => $product['total_charges'],
                'shade_id' => $product['shade_id'],
                'size_id' => $product['size_id'],
                'pattern_id' => $product['pattern_id'],
                'embroidery_id' => $product['embroidery_id'] ?? null,
            ]);
        }
        return redirect()->back()->with('success', 'Items added successfully.');        
    }

    // Edit item (optional)
    public function edit($id)
    {
        $item = OrderItem::findOrFail($id);
        return view('order_items.edit', compact('item'));
    }

    // Update item
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
            'other_charges' => 'nullable|numeric',
            'total_charges' => 'required|numeric',
        ]);

        $item = OrderItem::findOrFail($id);
        $item->update($request->all());

        return redirect()->back()->with('success', 'Item updated successfully.');
    }

    // Delete item
    public function destroy($id)
    {
        $item = OrderItem::findOrFail($id);
        $item->delete();

        return redirect()->back()->with('success', 'Item deleted successfully.');
    }
}
