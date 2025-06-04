<?php

namespace App\Http\Controllers;
use App\Models\Product;

use Illuminate\Http\Request;

class ProductController extends Controller
{

        public function index()
        {
            $products = Product::all();
            return view('products.index', compact('products'));
        }
    
        public function create()
        {
            return view('products.create');
              
        }
    
        public function store(Request $request)
        {
            $validated = $request->validate([
               'name' => 'required|string|max:255',
                'price' => 'required|numeric',
            ]);
                
            Product::create($validated);

            return redirect()->route('products.index')->with('success', 'Product created successfully.');
        }
    
        public function edit(Product $product)
        {
            return view('products.edit', compact('product'));
            // [
            //     'product' => $product,
            //     'warehouses' => Warehouse::all(),
            //     'patterns' => Pattern::all(),
            //     'shades' => Shade::all(),
            //     'sizes' => Size::all(),
            //     'embroideries' => Embroidery::all(),
            // ]);
        }
    
        public function update(Request $request, Product $product)
        {
            $request->validate([
                'name' => 'required',
                'price' => 'required|numeric',
                // 'warehouse_id' => 'required',
                // 'pattern_id' => 'required',
                // 'shade_id'  => 'required',
                // 'size_id'   => 'required',
                // 'embroidery_id' => 'required',
                // 'embroidery_charges' => 'required|numeric',
            ]);
            $data = $request->all();
            // $data['is_embroidery'] = $request->has('is_embroidery') ? 1 : 0;
        
            $product->update($data);
        
            return redirect()->route('products.index')->with('success', 'Product updated successfully.');
        }
    
        public function destroy(Product $product)
        {
            $product->delete();
            return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
        }
    }
    
