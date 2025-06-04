@extends('layouts/contentNavbarLayout')

@section('title', 'Users - Analytics')

@section('page-script')
@vite('resources/assets/js/dashboards-analytics.js')
@endsection

@section('content')

<div class="col-xxl">
    <div class="card mb-6">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mt-4 mb-3 px-4">
                <h4 class="mb-0 mt-3" style="color: #003366; font-weight: bold;">All Customer</h4>
                <a href="{{ route('customers.create') }}"class="btn btn-primary mt-4 mb-3 px-4">Add New Customer</a>
            </div>
            @csrf
            <table class="table table-bordered custom-table" style="margin-left: 10px; width: 98% !important; margin-bottom: 10px;">
                <div class="table-responsive">
                    <div class="col-md-6">
                        <tr style="background-color: #e6f2ff; color: #007acc; font-weight: bold;">
                        <th width="15%;" style="color: #007acc; font-weight: bold;">Name</th>
                        <th width="15%;" style="color: #007acc; font-weight: bold;">Email</th>
                        <th width="10%;" style="color: #007acc; font-weight: bold;">Mobile Number</th>
                        <th width="10%;" style="color: #007acc; font-weight: bold;">City</th>
                            <!-- <th>Country</th>
                            <th>Postal</th> -->
                        <th width="20%;" style="color: #007acc; font-weight: bold;">Organization</th>
                        <!-- <th style="width: 10%;">Dob</th>
                        <th style="width: 10%;">Anniversary Date</th> -->
                        <th width="5%;" style="color: #007acc; font-weight: bold;">Status</th>
                        <th width="5%;" style="color: #007acc; font-weight: bold;">Action</th>
                        </tr>
                        @foreach ($customers as $customer)
                        <tr>
                            <td>{{ $customer->name }}</td>
                            <td>{{ $customer->email }}</td>
                            <td>{{ $customer->mobile_number }}</td>    
                            <td>{{ $customer->city->city_name  ?? '' }}</td>
                            <!-- <td>{{ $customer->country }}</td> -->
                            <!-- <td>{{ $customer->postal }}</td> -->
                            <td>{{ $customer->organization }}</td>
                            <!-- <td>{{ $customer->dob ?? 'N/A' }}</td>
                            <td>{{ $customer->anniversary_date ?? 'N/A' }}</td> -->
                            <td>{{ $customer->is_active == 1 ? 'Active' : "In-Active" }}</td>
                            <td>
                            <a href="{{ route('customers.edit', $customer->id) }}" title="Edit"><i class="bx bx-edit-alt text-warning" style="font-size: 1.2rem;"></i></a>
                                
                                <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                 
                                    <button type="submit" onclick="return confirm('Are you sure you want to delete this customer?')" style="background: none; border: none; padding: 0;" title="Delete">
                                        <i class="bx bx-trash text-danger" style="font-size: 1.2rem;"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </div>
                </div>
            </table>
        </div>
    </div>
</div>

@endsection