@extends('layouts/contentNavbarLayout')

@section('title', 'Users - Analytics')

@section('page-script')
@vite('resources/assets/js/dashboards-analytics.js')
@endsection

@section('content')

<div class="col-xxl">
    <div class="card mb-6">
        <h5 class="mt-5 ms-5 text-start" style="color: #003366; font-weight: bold;">Create Users</h5>
        <form method="POST" action="{{ route('warehouses.store') }}">
        @csrf
        <div class="row mb-3 ms-1 me-1">
          <div class="col-md-5">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
         </div>
            <div class="col-md-5">
                <label>Code</label>
                <input type="text" name="code" class="form-control" required>
            </div>
        </div>
             <div class="d-flex justify-content-center px-4">
                <button class="btn btn-success">Save</button>
            </div>
        </br>
    </form>
</div>
</div>
@endsection