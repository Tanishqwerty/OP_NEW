@extends('layouts/contentNavbarLayout')

@section('title', 'Users - Analytics')

@section('page-script')
@vite('resources/assets/js/dashboards-analytics.js')
@endsection

@section('content')
<div class="col-xxl">
<div class="card mb-6">
<h4 class="mt-5 ms-5 text-start"style="color: #003366; font-weight: bold;">Create Size</h4>
<form action="{{ route('sizes.store') }}" method="POST">
    @csrf

    <div class="row mb-3 ms-1 me-1">
    <div class="col-md-5">
    <label for="warehouse_id">Warehouse:</label>
                <select name="warehouse_id" id="warehouse_id" class="form-control" required>
                <option value="">Select Warehouse</option>
                @foreach($warehouses as $warehouse)
                    <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                @endforeach
            </select>
    </div>
    <div class="col-md-5">
            <label class="ms-5">Size Name:</label>
            <input type="text" name="name" class="form-control" required>
    </div>
    </div>
         <div class="row mb-3 ms-1 me-1">
            <div class="col-md-5">
            <label class="ms-1">Code(optional):</label>
            <input type="text" name="code" class="form-control">
            </div>

            <div class="col-md-5">
            <label class="ms-5">Description:</label>
            <textarea name="description" class="form-control"></textarea>
            </div>
        </div>
        <div class="row mb-3 ms-1 me-1">
            <div class="col-md-5">
                <label class="ms-1">Base Price</label>
                <input type="number" name="base_price" class="form-control">
            </div>
        </div>
            <div class="row mb-3 ms-1 me-1">
            <div class="col-md-5">
            <input type="checkbox" class="form-check-input" id="status" name="status" value="Active">
                    <label class="form-check-label" for="status">Is Active</label>
                </div>
            </div>

    <div class="d-flex justify-content-center px-4">
    <button type="submit" class="btn btn-primary mt-3">Add Size</button>
    </div>
</br>
</form>
</div>
</div>
@endsection
