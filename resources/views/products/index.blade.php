@extends('layouts/contentNavbarLayout')

@section('title', 'Users - Analytics')

@section('page-script')
@vite('resources/assets/js/dashboards-analytics.js')
@endsection

@section('content')
<div class="col-xxl">
<div class="card mb-6">
<div class="d-flex justify-content-between align-items-center mt-4 mb-3 px-4">
<h4 class="mb-0" style="color: #003366; font-weight: bold;">Items List</h4>
    <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">Add Item</a>
</div>
    <table class="table table-bordered custom-table" style="margin-left: 10px; width: 98% !important; margin-bottom: 10px;">
        <thead>
            <tr style="background-color: #e6f2ff; color: #007acc; font-weight: bold;">
                <th style="color: #007acc; font-weight: bold;">Name</th>
                <th style="color: #007acc; font-weight: bold;">Price</th>
                <th style="color: #007acc; font-weight: bold;">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <!-- <td>{{ $product->warehouse->name ?? 'N/A' }}</td>
                <td>{{ $product->pattern->name ?? 'N/A' }}</td>
                <td>{{ $product->shade->name ?? 'N/A' }}</td>
                <td>{{ $product->size->name ?? 'N/A' }}</td>
                <td>{{ $product->embroidery->name ?? 'N/A' }}</td> -->
                <td>{{ $product->price }}</td>
                <!-- <td>{{ $product->embroidery_charges }}</td>
                <td>{{ $product->is_embroidery ? 'Yes' : 'No' }}</td> -->
                <td>
                    <a href="{{ route('products.edit', $product->id) }}" title="Edit"><i class="bx bx-edit-alt text-warning" style="font-size: 1.2rem;"></i></a>
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure you want to delete this items?')" style="background: none; border: none; padding: 0;" title="Delete">
                             <i class="bx bx-trash text-danger" style="font-size: 1.2rem;"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>
</div>
@endsection