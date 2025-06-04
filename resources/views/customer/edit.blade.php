@extends('layouts/contentNavbarLayout')

@section('title', 'Users - Analytics')

@section('page-script')
@vite('resources/assets/js/dashboards-analytics.js')
@endsection

@section('content')

<div class="col-xxl">
    <div class="card mb-6">
        <h4 class="mt-5 ms-5 text-start" style="color: #003366; font-weight: bold;">Edit Customer</h4>
        <div class="card-body">
            <form action="{{ route('customers.update', $customer->id) }}" method="POST">
                @csrf
                @method('PUT')

                  <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Name*</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $customer->name) }}" required>
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Email*</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $customer->email) }}" required>
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Mobile Number*</label>
                            <input type="number" name="mobile_number" class="form-control" required value="{{ old('mobile_number', $customer->mobile_number) }}">
                            @error('mobile_number')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                </div>
            
                <div class="row mb-3">
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Organization Name</label>
                           <input type="postal" name="organization" class="form-control" value="{{ old('organization', $customer->organization) }}">
                        </div>
                    </div>
                 
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" name="address" class="form-control" value="{{ old('address', $customer->address) }}">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="city_id">City*</label>
                             <select name="city_id" class="form-control select2" required>
                                <option value="">Select City</option>
                                @foreach($cities as $city)
                                <option value="{{ $city->id }}" {{ $city->id == $customer->city_id ? 'selected' : '' }}>
                                {{ $city->city_name }}
                                @endforeach
                            </select>
                            @error('city_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                          
                </div>
            
                <div class="row mb-3">
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Country</label>
                            <input type="text" name="country" class="form-control" value="{{ old('country', $customer->country) }}">
                        </div>
                    </div>
               
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Postal</label>
                           <input type="postal" name="postal" class="form-control" value="{{ old('postal', $customer->postal) }}">
                        </div>
                    </div>

                     <div class="col-md-4">
                        <div class="form-group">
                            <label>Date of Birth</label>
                            <input type="date" name="dob" class="form-control" value="{{ old('dob', $customer->dob) }}">
                        </div>
                    </div>
                    
                </div>

                <div class="row mb-3">
                     <div class="col-md-4">
                        <div class="form-group">
                            <label>Anniversary_date</label>
                            <input type="date" name="anniversary_date" class="form-control" value="{{ old('anniversary_date', $customer->anniversary_date) }}">
                           </div>
                    </div>
                    <div class="col-md-4">
                        <input type="checkbox" class="form-check-input ms-5 mt-5" id="is_active" name="is_active" value="Active"  {{ $customer->is_active == 1 ? 'checked' : '' }}>
                        <label class="form-check-label mt-5" for="is_active">Is Active</label>
                    </div>
                </div>
            
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </br>
            </form>
        </div>
    </div>
</div>
@endsection