@extends('layouts/contentNavbarLayout')

@section('title', 'Users - Analytics')

@section('page-script')
@vite('resources/assets/js/dashboards-analytics.js')
@endsection

@section('content')

<div class="col-xxl">
    <div class="card mb-6">
        <h5 class="mt-5 ms-5 text-start" style="color: #003366; font-weight: bold;">Create Customers</h5>
        <div class="card-body">
            <form method="POST" action="{{ route('customers.store') }}">
                @csrf
            
                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Name*</label>
                            <input type="text" name="name" class="form-control" required>
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Email*</label>
                            <input type="email" name="email" class="form-control" required>
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Organization Name</label>
                           <input type="postal" name="organization" class="form-control">
                           
                        </div>
                    </div>
                </div>
            
                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Mobile Number*</label>
                            <input type="number" name="mobile_number" class="form-control" required>
                            @error('mobile_number')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" name="address" class="form-control">
                           
                        </div>
                    </div>
                
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="city_id">City*</label>
                             <select name="city_id" class="form-control select2" required>
                                <option value="">Select</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city->id }}">{{ $city->city_name }}</option>
                                @endforeach
                            </select>
                            
                        </div>
                    </div>
                                    
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Country</label>
                            <input type="text" name="country" class="form-control" >
                          
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Postal</label>
                           <input type="text" name="postal" class="form-control">
                           
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Date Of Birth</label>
                            <input type="date" name="dob" class="form-control">
                        </div>
                    </div>
                </div>
                     <div class="row mb-3">
                         <div class="col-md-4">
                             <div class="form-group">
                                <label>Anniversary_date</label>
                                <input type="date" name="anniversary_date" class="form-control">
                            </div>
                        </div>
                    <div class="col-md-4">
                        <input type="checkbox" class="form-check-input ms-5 mt-5" id="is_active" name="is_active" value="Active">
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