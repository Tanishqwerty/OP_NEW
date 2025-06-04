@extends('layouts/contentNavbarLayout')

@section('title', 'Dashboard - Analytics')

@section('vendor-style')
@vite('resources/assets/vendor/libs/apex-charts/apex-charts.scss')
@endsection

@section('vendor-script')
@vite('resources/assets/vendor/libs/apex-charts/apexcharts.js')
@endsection

@section('page-script')
@vite('resources/assets/js/dashboards-analytics.js')
@endsection

@section('content')

<style>
.dashboard-section {
    width: 100%;
    margin-top: 20px;
}
.dashboard-table-wrapper {
    width: 100%;
}

</style>
<div class="card-body row" id="welcomeDiv">
  
    <div class="col-6">    
      <h5 class="card-title text-primary mb-3">Congratulations</h5>
      <p class="mb-6">Welcome to Admin Login Order Processing System Software.</p>
    </div>
  
    <div class="col-6 card-body pb-0 px-0 px-md-6">
      <img src="{{asset('assets/img/illustrations/man-with-laptop.png')}}" height="250" class="scaleX-n1-rtl" alt="View Badge User" style="float: inline-end;">
    </div>
</div>
<br/><br/>

<div class="row g-3 mb-3 row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-2 row-cols-xl-4 justify-content-center">
		<div class="col" onclick="loadDashboardData('customersDiv')" style="padding-right: 20px;">
			<div class="alert-success alert mb-0">
				<div class="d-flex align-items-center">
					<div class="avatar rounded no-thumbnail bg-success text-light"><i class="menu-icon bx bx-user me-1" style="color: white; margin-top: 8px; margin-left: 7px;"></i></div>
					<div class="flex-fill ms-3 text-truncate">
						<div class="h6 mb-0">Registered Customers</div>
						<span class="small">{{$totalCustomers}}</span>
					</div>
				</div>
			</div>
		</div>
		
		<div class="col" onclick="loadDashboardData('ordersComplateDiv')" style="padding-right: 20px;">
			<div class="alert-warning alert mb-0">
				<div class="d-flex align-items-center">
					<div class="avatar rounded no-thumbnail bg-warning text-light"><i class="menu-icon tf-icons bx bx-home-smile" style="color: white; margin-top: 8px; margin-left: 7px;"></i></div>
					<div class="flex-fill ms-3 text-truncate">
						<div class="h6 mb-0">Completed Orders</div>
						<span class="small">{{$completedOrders}}</span>
					</div>
				</div>
			</div>
		</div>
		<div class="col" onclick="loadDashboardData('ordersPendingDiv')" style="padding-right: 20px;">
			<div class="alert-info alert mb-0">
				<div class="d-flex align-items-center">
					<div class="avatar rounded no-thumbnail bg-info text-light"><i class="menu-icon tf-icons bx bx-cart" style="color: white; margin-top: 8px; margin-left: 7px;"></i> </div>
					<div class="flex-fill ms-3 text-truncate">
						<div class="h6 mb-0">Orders to be Delivered</div>
						<span class="small">{{$pendingDeliveries}}</span>
					</div>
				</div>
			</div>
		</div>
	</div>
<div id="workingDiv">
  <div class="container">
      <div class="card">
          <div class="card-header" style="color: #003366; font-weight: bold;padding-bottom: 2px;" id="dashboardSectionTitle">Latest 10 Customers</div>
          <div class="card-body">
                <div class="dashboard-table-wrapper" style="width: 100%;">
                    <div class="table-responsive">
  
                        <table class="table table-bordered dashboard-section w-100" id="customersDiv" >
                            <thead>
                                <tr style="background-color: #e6f2ff; color: #007acc; font-weight: bold;">
                                    <th style="color: #007acc; font-weight: bold;">Sr.No</th>
                                    <th style="color: #007acc; font-weight: bold;">Customer Name</th>
                                    <th style="color: #007acc; font-weight: bold;">Registration Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($customers as $index => $customer)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $customer->name }}</td>
                                        <td>{{ $customer->created_at->format('Y-m-d') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">No customers found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <table class="table table-bordered dashboard-section" id="ordersComplateDiv" style="display:none;">
                            <thead>
                                <tr style="background-color: #e6f2ff; color: #007acc; font-weight: bold;">
                                    <th style="color: #007acc; font-weight: bold;">Sr.No</th>
                                    <th style="color: #007acc; font-weight: bold;">Order No</th>
                                    <th style="color: #007acc; font-weight: bold;">Customer Name</th>
                                    <th style="color: #007acc; font-weight: bold;">Order Date</th>
                                    <th style="color: #007acc; font-weight: bold;">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($ordersComplate as $index => $order)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>#{{ $order->id }}</td>
                                        <td>{{ $order->customer->name ?? 'N/A' }}</td>
                                        <td>{{ $order->created_at->format('Y-m-d') }}</td>
                                        <td>{{ number_format($order->total_amount, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No orders found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <table class="table table-bordered dashboard-section" id="ordersPendingDiv" style="display:none;">
                            <thead>
                                <tr style="background-color: #e6f2ff; color: #007acc; font-weight: bold;">
                                    <th style="color: #007acc; font-weight: bold;">Sr.No</th>
                                    <th style="color: #007acc; font-weight: bold;">Order No</th>
                                    <th style="color: #007acc; font-weight: bold;">Customer Name</th>
                                    <th style="color: #007acc; font-weight: bold;">Order Date</th>
                                    <th style="color: #007acc; font-weight: bold;">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($ordersPending as $index => $order)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>#{{ $order->id }}</td>
                                        <td>{{ $order->customer->name ?? 'N/A' }}</td>
                                        <td>{{ $order->created_at->format('Y-m-d') }}</td>
                                        <td>{{ number_format($order->total_amount, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No orders found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    
                    </div>
                </div> 
          </div>
      </div>
  </div> 
</div> 
@endsection
@push('scripts')
<script>
    window.onload = function () {
        setTimeout(function () {
            document.getElementById("welcomeDiv").style.display = "none";
        }, 1000);
    };

    function loadDashboardData(sectionId) {

        const titleMap = {
            customersDiv: 'Latest 10 Customers',
            ordersComplateDiv: 'Latest 10 Completed Orders',
            ordersPendingDiv: 'Latest 10 Pending Deliveries'
        };

        // Update title text
        document.getElementById('dashboardSectionTitle').textContent = titleMap[sectionId] || 'Dashboard';

         // Hide all sections
        document.querySelectorAll('.dashboard-section').forEach(el => el.style.display = 'none');

        const section = document.getElementById(sectionId);
        section.style.display = 'block';
    }
</script>
@endpush

