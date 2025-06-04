@extends('layouts/contentNavbarLayout')

@section('title', 'Users - Analytics')

@section('page-script')
@vite('resources/assets/js/dashboards-analytics.js')
@endsection

@section('content')

<div class="col-xxl">
    <div class="card mb-6">
        <h5 class="mt-5 ms-9 text-start" style="color: #003366; font-weight: bold;">Edit Size</h5>

        <form action="{{ route('sizes.update', $size->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row mb-3 ms-1 me-1">
                <div class="col-md-5">
                <label class="form-label ms-5">Warehouse Id</label>
                    <select name="warehouse_id" id="warehouse_id" class="form-control ms-5" required>
                        <option value="">Select Warehouse</option>
                        @foreach($warehouses as $warehouse)
                            <option value="{{ $warehouse->id }}" {{ $size->warehouse_id == $warehouse->id ? 'selected' : '' }}>{{ $warehouse->name }}</option>
                        @endforeach
                    </select>
            </div>
            <div class="col-md-5">
                    <label class="form-label ms-5">Size Name:</label>
                    <input type="text" name="name" class="form-control ms-5" value="{{ old('name', $size->name) }}" required>
            </div>
            </div>
            <div class="row mb-3 ms-1 me-1">
                <div class="col-md-5">
                    <label class="form-label ms-5">Code(optional):</label>
                    <input type="text" name="code" class="form-control ms-5" value="{{ old('code', $size->code) }}">
                </div>
                <div class="col-md-5">
                <label class="form-label ms-5">Description:</label>
                <input type="description" class="form-control ms-5" value="{{ old('Description', $size->description) }}">
                </div>
                </div>
                <div class="row mb-3 ms-1 me-1">
                    <div class="col-md-5">
                        <label class="ms-5">Base Price</label>
                        <input type="number" step="0.01" name="base_price" class="form-control ms-5" value="{{ old('base_price', $size->base_price ?? '') }}" required>
                    </div>
                </div>
                <div class="row mb-3 ms-1 me-1">
                <div class="col-md-5">
                <input type="checkbox" class="form-check-input ms-5 mt-5" id="status" name="status" value="Active" {{ $size->status == 'Y' ? 'checked' : '' }}>
                    <label class="form-check-label mt-5" for="status">Is Active</label>
                </div>
            </div>

            <div class="d-flex justify-content-center mt-3">
                <button type="submit" class="btn btn-primary">Update Size</button>
            </div>
            </br>
        </form>
    </div>
</div>
@endsection
