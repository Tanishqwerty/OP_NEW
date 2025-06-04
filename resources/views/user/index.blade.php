@extends('layouts/contentNavbarLayout')

@section('title', 'Users - Analytics')

@section('page-script')
@vite('resources/assets/js/dashboards-analytics.js')
@endsection

@section('content')

<div class="col-xxl">
<div class="card mb-6">
    <div class="card-body">
    <div class="d-flex justify-content-between align-items-center mt-0 mb-1 px-4">
    <h4 class="mt-5 mb-0" style="color: #003366; font-weight: bold;">All User</h4>
    <a href="{{ route('user.create') }}"class="btn btn-primary mt-4 mb-3 px-4">Add New User</a>
    </div>
    @csrf
    <table class="table table-bordered" style="margin-left: 10px; width: 98% !important; margin-bottom: 10px;">
    <div class="row mb-3">
    <div class="col-md-6">
        <tr style="background-color: #e6f2ff; color: #007acc; font-weight: bold;">
            <th style="color: #007acc; font-weight: bold;">Name</th>
            <th style="color: #007acc; font-weight: bold;">Email</th>
            <th style="color: #007acc; font-weight: bold;">Role</th>
            <th style="color: #007acc; font-weight: bold;">Status</th>
            <th style="color: #007acc; font-weight: bold;">Action</th>
        </tr>
        @foreach ($users as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->role ? $user->role->name : 'N/A' }}</td>
            <td>{{ $user->is_active == 1 ? 'Active' : "In-Active" }}</td>
            <td>
             <a href="{{ route('user.edit', $user->id) }}" title="Edit"><i class="bx bx-edit-alt text-warning" style="font-size: 1.2rem;"></i></a>
                
                <form action="{{ route('user.destroy', $user->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Are you sure you want to delete this user?')" style="background: none; border: none; padding: 0;" title="Delete">
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
</div>

@endsection