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
                <h4 class="mb-0" style="color: #003366; font-weight: bold;">City List</h4>
                <a href="{{ route('cities.create') }}"class="btn btn-primary mt-4 mb-3 px-4">Add City</a>
            </div>
            @csrf
            <table class="table table-bordered custom-table" style="margin-left: 10px; width: 98% !important; margin-bottom: 10px;">
                <div class="table-responsive">
                    <div class="col-md-6">
                        <tr style="background-color: #e6f2ff; color: #007acc; font-weight: bold;">
                            <th style="color: #007acc; font-weight: bold;">City Name</th>
                            <th style="color: #007acc; font-weight: bold;">Delivery Charge</th>
                            <th style="color: #007acc; font-weight: bold;">Status</th>
                            <th style="color: #007acc; font-weight: bold;">Actions</th>
                        </tr>
                       @foreach($cities as $city)
                <tr>
                    <td>{{ $city->city_name }}</td>
                    <td>{{ $city->delivery_charge }}</td>
                    <td>{{ $city->is_active == 1 ? 'Active' : "In-Active" }}</td>
                            <td>
                            <a href="{{ route('cities.edit', $city->id) }}" title="Edit"><i class="bx bx-edit-alt text-warning" style="font-size: 1.2rem;"></i></a>
                                
                                <form action="{{ route('cities.destroy', $city->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                 
                                    <button type="submit" onclick="return confirm('Are you sure you want to delete this city?')" style="background: none; border: none; padding: 0;" title="Delete">
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