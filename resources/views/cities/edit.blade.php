@extends('layouts/contentNavbarLayout')

@section('title', 'Users - Analytics')

@section('page-script')
@vite('resources/assets/js/dashboards-analytics.js')
@endsection

@section('content')

<div class="col-xxl">
    <div class="card mb-6">
        <h4 class="mt-5 ms-5 text-start">Edit City</h4>
        <div class="card-body">
            <form action="{{ route('cities.update', $city->id) }}" method="POST">
                @csrf
                @method('PUT')

                  <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>City_Name</label>
                            <input type="city_name" name="city_name" class="form-control" value="{{ old('name', $customer->name) }}" required>
                            @error('city_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Delivery_Charge</label>
                            <input type="delivery_charge" name="delivery_charge" class="form-control" value="{{ old('email', $customer->email) }}" required>
                            @error('delivery_charge')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <input type="checkbox" class="form-check-input ms-5 mt-5" id="is_active" name="is_active" value="Active"  {{ $customer->is_active == 1 ? 'checked' : '' }}>
                        <label class="form-check-label mt-5" for="is_active">Is Active</label>
                    </div>
                </div>
            
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </br>
            </form>
        </div>
    </div>
</div>
@endsection