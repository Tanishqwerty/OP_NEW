@extends('layouts/contentNavbarLayout')

@section('title', 'Users - Analytics')

@section('page-script')
@vite('resources/assets/js/dashboards-analytics.js')
@endsection

@section('content')

<div class="col-xxl">
    <div class="card mb-6">
        <h4 class="mt-5 ms-5 text-start" style="color: #003366; font-weight: bold;">Edit User</h4>
        <div class="card-body">
            <form action="{{ route('user.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" name="firstname" class="form-control" required value="{{ old('firstname', $user->firstname) }}">
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" name="lastname" class="form-control" required value="{{ old('lastname', $user->lastname) }}">
                        </div>
                    </div>
                </div>
            
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" required value="{{ old('email', $user->email) }}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required value="{{ old('password', $user->password) }}">
                        </div>
                    </div>
                </div>
            
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="role_id">Role</label>
                            <select name="role_id" id="role_id" class="form-control" required>
                                <option value="">Select Role</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ $role->id == $user->role_id ? 'selected' : '' }}>{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>name</label>
                            <input type="name" name="name" class="form-control" required value="{{ old('name', $user->name) }}">
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="warehouse_id">Warehouse</label>
                            <select name="warehouse_id" id="warehouse_id" class="form-control" required>
                                <option value="">Select Warehouse</option>
                                @foreach($warehouses as $warehouse)
                                    <option value="{{ $warehouse->id }}" {{ $user->warehouse_id == $warehouse->id ? 'selected' : '' }}>{{ $warehouse->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <input type="checkbox" class="form-check-input ms-5 mt-5" id="is_active" name="is_active" value="Active" {{ $user->is_active == 1 ? 'checked' : '' }}>
                        <label class="form-check-label mt-5" for="is_active">Is Active</label>
                    </div>
                </div>
            


                <div class="d-flex justify-content-center mt-3">
                    <button type="submit" class="btn btn-primary">Update User</button>
                </div>
                </br>
            </form>
        </div>
    </div>
</div>
@endsection