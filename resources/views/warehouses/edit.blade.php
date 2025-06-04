@extends('layouts/contentNavbarLayout')

@section('title', 'Users - Analytics')

@section('page-script')
@vite('resources/assets/js/dashboards-analytics.js')
@endsection

@section('content')

<div class="col-xxl">
    <div class="card mb-6">
        <h4 class="mt-8 ms-11 text-start" style="color: #003366; font-weight: bold;">Edit User</h4>
        <div class="card-body">
        <form method="POST" action="{{ route('warehouses.update', $warehouse->id) }}">
        @csrf @method('PUT')

        <div class="row mb-3 ms-1 me-1">
          <div class="col-md-5">
            <label>Name</label>
            <input type="text" name="name" value="{{ $warehouse->name }}" class="form-control" required>
         </div>
            <div class="col-md-5">
                <label>Code</label>
                <input type="text" name="code" value="{{ $warehouse->code }}" class="form-control" required>
            </div>
        </div>
            <div class="d-flex justify-content-center px-4">
                <button class="btn btn-primary">Update</button>
            </div>
        </br>
    </form>
</div>
@endsection
