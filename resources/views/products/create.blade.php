@extends('layouts/contentNavbarLayout')

@section('title', 'Users - Analytics')

@section('page-script')
@vite('resources/assets/js/dashboards-analytics.js')
@endsection

@section('content')
<div class="col-xxl">
<div class="card mb-4 p-4">

<form action="{{ route('products.store') }}" method="POST">
@csrf
        <h4 class="mb-4" style="color: #003366; font-weight: bold;">Item Form</h4>

        <div class="row mb-3">
            <div class="col-md-6">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $product->name ?? '') }}" required>
            </div>
            <div class="col-md-6">
                <label>Price</label>
                <input type="number" name="price" step="0.01" class="form-control" value="{{ old('price', $product->price ?? '') }}" required>
            </div>
        </div>

       
        <div class="d-flex justify-content-center px-4">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    
</br>

</form>
</div>
</div>
@endsection