@extends('layouts/contentNavbarLayout')

@section('title', 'Users - Analytics')

@section('page-script')
    @vite('resources/assets/js/dashboards-analytics.js')
@endsection

@section('content')


<div class="row">
    
    <form class="row" method="POST" action="{{ route('orders.store') }}">
    
    <div class="col-10 card mb-2">
        <div class="d-flex justify-content-between align-items-center mt-4 mb-3 px-4">
            <h5 class="mt-3 mb-3" style="color: #003366; font-weight: bold;">Add New Order</h5>
        </div>
            @csrf

            @php
                $orderDate = old('order_date', \Carbon\Carbon::now()->format('Y-m-d'));
                $deliveryDate = \Carbon\Carbon::parse($orderDate)->addDays(7)->format('Y-m-d');
            @endphp
            <div class="row mb-3 px-4 align-items-center d-flex">
                <div class="col-md-3">
                    <label>Order Number</label>
                    <input type="text" name="order_number" value="ORD{{ time() }}" class="form-control" readonly>
                </div>
                <div class="col-md-3">
                    <label>Order Date</label>
                    <input type="date" name="order_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="col-md-3 d-flex align-items-center">
                <div style="flex-grow: 1;">
                    <label>Customer</label>
                    
                    <select name="customer_id" class="form-control product-select select2" onchange="handleCityChange(this)" required>
                        <option value="">Select</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" data-price="{{$customer->city->delivery_charge ?? 0 }}">{{ $customer->name }}</option>
                        @endforeach
                    </select>
                </div> 
                    
                    <button type="button" onclick="addCustomer()" class="btn btn-success ms-2 mt-4 px-2 py-1">
                        <i class="bx bx-plus text-white" style="font-size: 1.2 rem;"></i>
                    </button>
                </div>  
                
                <div class="col-md-3">
                    <label>Delivery Date</label>
                    <input type="date" name="delivery_date" class="form-control"
                        min="{{ $deliveryDate }}"
                        value="{{ old('delivery_date', $deliveryDate) }}" required>
                </div>
        
            </div>

            <div class="card-body px-4">
                <h5 class="mb-3">Order Items</h5>
                <div class="table-responsive" style="overflow-x: auto; white-space: nowrap;">
                    <table class="table table-bordered w-100" id="product_table" style="min-width: 1200px;">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 5%;">
                                    <button type="button" onclick="addRow()" class="btn btn-success btn-sm">
                                        <i class="bx bx-plus text-white" style="font-size: 1.2rem;"></i>
                                    </button>
                                </th>

                                <th style="width: 12%;">Product</th>
                                <th style="width: 15%;">Shade</th>
                                <th style="width: 15%;">Size</th>
                                <th style="width: 15%;">Pattern</th>
                                <th style="width: 8%;">Embroidery</th>
                                <th style="width: 10%;">Price</th>
                                <th style="width: 10%;">Qty</th>
                                <th style="width: 1%;" title="Other Charges">O. Cha.</th>
                                <th style="width: 9%;">Total Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="width: 5%;">
                                    <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">
                                        <i class="bx bx-trash text-white" style="font-size: 1.2rem;"></i>
                                    </button>
                                    <button type="button" class="btn btn-success btn-sm" onclick="toggleDetails(0)">
                                        <i class="bx bx-expand text-white" style="font-size: 1.2rem;"></i>
                                    </button>
                                </td>
                                <td style="width: 12%;">
                                    <select name="products[0][product_id]" class="form-control product-select" required>
                                        <option value="">Select</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}" data-price="{{ $product->price }}" data-name="{{ $product->name }}">{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td style="width: 15%;">
                                    <select name="products[0][shade_id]" class="form-control shade-select">
                                        <option value="">Select Shade</option>
                                        @foreach($shades as $shade)
                                            <option value="{{ $shade->id }}" data-price="{{ $shade->base_price }}" data-name="{{ $shade->name }}">{{ $shade->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td style="width: 15%;">
                                    <select name="products[0][size_id]" class="form-control size-select">
                                        <option value="">Select Size</option>
                                        @foreach($sizes as $size)
                                            <option value="{{ $size->id }}" data-price="{{ $size->base_price }}" data-name="{{ $size->name }}">{{ $size->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td style="width: 15%;">
                                    <select name="products[0][pattern_id]" class="form-control pattern-select">
                                        <option value="">Select Pattern</option>
                                        @foreach($patterns as $pattern)
                                            <option value="{{ $pattern->id }}" data-price="{{ $pattern->base_price }}" data-name="{{ $pattern->name }}">{{ $pattern->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td style="width: 15%;">
                                    <select name="products[0][embroidery_id]" class="form-control embroidery-select">
                                        <option value="">Select Embroidery</option>
                                        @foreach($embroideries as $embroidery)
                                            <option value="{{ $embroidery->id }}" data-price="{{ $embroidery->base_price }}" data-name="{{ $embroidery->embroidery_name }}">{{ $embroidery->embroidery_name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td  style="width: 10%;"><input type="text" name="products[0][price]" class="form-control price" readonly style="padding: 3px"></td>
                                <td style="width: 10%;"><input type="number" name="products[0][quantity]" class="form-control quantity" value="1" style="padding: 3px"></td>
                                <td style="width: 1%;"><input type="number" name="products[0][other_charges]" class="form-control other_charges" value="0" style="padding: 3px"></td>
                                <td style="width: 9%;"><input type="text" name="products[0][total_charges]" class="form-control total" readonly style="padding: 3px"></td>
                                
                            </tr>
                            <tr id="details-0" style="display: none;">
                                <td colspan="10">
                                    <strong>Material Details:</strong>
                                    @php $label = 'A'; @endphp
                                    <br/><b>{{ $label++ }}. Shades: </b> <label class="shade-name">NA</label> | Price : &#8377; <label class="shade-price"></label>    
                                    <br/><b>{{ $label++ }}. Size: </b> <label class="size-name">NA</label> | Price : &#8377; <label class="size-price"></label>
                                    <br/><b>{{ $label++ }}. Pattern: </b> <label class="pattern-name">NA</label> | Price : &#8377; <label class="pattern-price"></label> 
                                    <br/><b>{{ $label++ }}. Embroidery: </b> <label class="embroidery-name">NA</label> | Price : &#8377; <label class="embroidery-price"></label>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

             {{-- Submit --}}
         <div class="d-flex justify-content-center px-4">
            <button type="submit" class="btn btn-primary">Submit</button>

            <div>
                @if(session()->has('order_id'))
                    <button type="button" class="btn btn-primary ms-4" id="printButton"
                    onclick="window.location.href='{{ route('order.pdf', session('order_id')) }}'">
                        <i class="fas fa-print"></i> Print PDF
                    </button>

                    <button type="button" class="btn btn-success ms-2" id="shareWhatsapp" onclick="shareOnWhatsapp()">
                        <i class="fab fa-whatsapp"></i> WhatsApp
                    </button>
                @endif
            </div>
        </div>
        </br>
        
    </div>

    <div class="col-2 card mb-2">
        {{-- Payment & Delivery --}}
        <div class="card-body px-4 pt-0">
            <h5 class="mt-8 mb-3" style="color: #003366; font-weight: bold; font-size: 16px;">Payment & Delivery</h5>
            <div class="row">
                <div class="col-md-12">
                    <label>Payment Method</label>
                    <select name="payment_id" class="form-control" required>
                        <option value="">Select</option>
                        @foreach($paymentMethods as $paymentMethod)
                            <option value="{{ $paymentMethod->id }}">{{ $paymentMethod->name }}</option>
                        @endforeach
                    </select>
                </div>
                <br>
                <div class="col-md-12 mt-4">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="pending" selected>Pending</option>
                        <option value="completed">Completed</option>
                        <option value="completed">Delivered</option>
                    </select>
                </div>
                
                <div class="col-md-12 mt-4">
                        <label>Delivery Charge</label>
                        <input type="number" name="delivery_charge" id="deliveryCharge" class="form-control" value="0" step="any">
                </div>

                <div class="col-md-12 mt-4">
                        <label>Discount</label>
                        <input type="number" name="discount" id="discount" class="form-control" value="0" step="any">
                </div>
                
                <div class="col-md-12 mt-4">
                    <label>Payable Amount</label>
                        <input type="text" name="payable_amount" id="payableAmount" class="form-control" value="{{ old('payable_amount') }}"></input>
                </div>
                
                <div class="col-md-12 mt-4">
                    <label>Total Amount</label>
                        <input type="text" name="total_amount" id="totalAmount" class="form-control" readonly value="{{ old('total_amount') }}"></input>
                </div>
                
            </div>
        </div>
    </div>
    
    </form>
</div>

{{-- Script --}}
<script>

    let rowIndex = 1;
    let totalAmount = "";

    function addRow() {
        const table = document.querySelector('#product_table tbody');
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>
                <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">
                    <i class="bx bx-trash text-white" style="font-size: 1.2rem;"></i>
                </button>
                <button type="button" class="btn btn-success btn-sm" onclick="toggleDetails(${rowIndex})">
                    <i class="bx bx-expand text-white" style="font-size: 1.2rem;"></i>
                </button>
            </td>
            <td>
                <select name="products[${rowIndex}][product_id]" class="form-control product-select" required>
                    <option value="">Select</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" data-price="{{ $product->price }}" data-name="{{ $product->name }}">{{ $product->name }}</option>
                    @endforeach
                </select>
            </td>
             <td>
            <select name="products[${rowIndex}][shade_id]" class="form-control shade-select">
                <option value="">Select Shade</option>
                @foreach($shades as $shade)
                    <option value="{{ $shade->id }}" data-price="{{ $shade->base_price }}" data-name="{{ $shade->name }}">{{ $shade->name }}</option>
                @endforeach
            </select>
        </td>
        <td>
            <select name="products[${rowIndex}][size_id]" class="form-control size-select">
                <option value="">Select Size</option>
                @foreach($sizes as $size)
                    <option value="{{ $size->id }}" data-price="{{ $size->base_price }}" data-name="{{ $size->name }}">{{ $size->name }}</option>
                @endforeach
            </select>
        </td>
        <td>
            <select name="products[${rowIndex}][pattern_id]" class="form-control pattern-select">
                <option value="">Select Pattern</option>
                @foreach($patterns as $pattern)
                    <option value="{{ $pattern->id }}" data-price="{{ $pattern->base_price }}" data-name="{{ $pattern->name }}">{{ $pattern->name }}</option>
                @endforeach
            </select>
        </td>
        <td>
            <select name="products[${rowIndex}][embroidery_id]" class="form-control embroidery-select">
                <option value="">Select Embroidery</option>
                @foreach($embroideries as $embroidery)
                    <option value="{{ $embroidery->id }}" data-price="{{ $embroidery->base_price }}" data-name="{{ $embroidery->embroidery_name }}">{{ $embroidery->embroidery_name }}</option>
                @endforeach
            </select>
        </td>
            <td><input type="text" name="products[${rowIndex}][price]" class="form-control price" readonly></td>
            <td><input type="number" name="products[${rowIndex}][quantity]" class="form-control quantity" value="1"></td>
            <td><input type="number" name="products[${rowIndex}][other_charges]" class="form-control other_charges" value="0"></td>
            <td><input type="text" name="products[${rowIndex}][total_charges]" class="form-control total" readonly></td>
        `;
        table.appendChild(row);

        const row2 = document.createElement('tr');
        row2.id = 'details-'+rowIndex; // ID dynamically set
        row2.style.display = 'none'; // Inline style to hide the row initially
    
        row2.innerHTML = `
            <tr>
                <td colspan="10">
                    <strong>Material Details:</strong>
                    @php $label = 'A'; @endphp
                    <br/><b>{{ $label++ }}. Shades: </b> <label class="shade-name">NA</label> | Price : &#8377; <label class="shade-price"></label>    
                    <br/><b>{{ $label++ }}. Size: </b> <label class="size-name">NA</label> | Price : &#8377; <label class="size-price"></label>
                    <br/><b>{{ $label++ }}. Pattern: </b> <label class="pattern-name">NA</label> | Price : &#8377; <label class="pattern-price"></label> 
                    <br/><b>{{ $label++ }}. Embroidery: </b> <label class="embroidery-name">NA</label> | Price : &#8377; <label class="embroidery-price"></label>
                </td>
            </tr>
        `;
        table.appendChild(row2);
        rowIndex++;
    }

    function removeRow(btn) {
        btn.closest('tr').remove();
    }

    document.addEventListener('change', function(e) {
        const row = e.target.closest('tr');
        if (!row) return;

         // Move to the next row
        const nextRow = row.nextElementSibling;

        // product
        const product = row.querySelector('.product-select');
        let price = product.options[product.selectedIndex]?.dataset?.price || 0;
       
        //shard
        const shade = row.querySelector('.shade-select');
        if(shade){
            const shade_base_price = shade.options[shade.selectedIndex]?.dataset?.price || 0;
            if(shade_base_price > 0) {
                price = parseFloat(price) + parseFloat(shade_base_price);

                const shadeLabel = nextRow.querySelector('.shade-price');
                shadeLabel.textContent = shade_base_price;
            }

            const shade_name = shade.options[shade.selectedIndex]?.dataset?.name || 'NA';
            const shadeLabel = nextRow.querySelector('.shade-name');
                  shadeLabel.textContent = shade_name;
        }

        
        //Size
        const size = row.querySelector('.size-select');
        if(size){
            const size_base_price = size.options[size.selectedIndex]?.dataset?.price || 0;
            if(size_base_price > 0) {
                price = parseFloat(price) + parseFloat(size_base_price);

                const sizeLabel = nextRow.querySelector('.size-price');
                sizeLabel.textContent = size_base_price;
            }

            const name = size.options[size.selectedIndex]?.dataset?.name || 'NA';
            const label = nextRow.querySelector('.size-name');
                  label.textContent = name;
        }

        //Pattern
        const pattern = row.querySelector('.pattern-select');
        if(pattern){
            const pattern_base_price = pattern.options[pattern.selectedIndex]?.dataset?.price || 0;
            if(pattern_base_price > 0) {
                price = parseFloat(price) + parseFloat(pattern_base_price);
             
                const patternLabel = nextRow.querySelector('.pattern-price');
                patternLabel.textContent = pattern_base_price;
            }

            const name = pattern.options[pattern.selectedIndex]?.dataset?.name || 'NA';
            const label = nextRow.querySelector('.pattern-name');
                  label.textContent = name;
        }

        //Embroidery
        const embroidery = row.querySelector('.embroidery-select');
        if(embroidery){
            const embroidery_base_price = embroidery.options[embroidery.selectedIndex]?.dataset?.price || 0;
            if(embroidery_base_price > 0) {
                price = parseFloat(price) + parseFloat(embroidery_base_price);

                const embroideryLabel = nextRow.querySelector('.embroidery-price');
                embroideryLabel.textContent = embroidery_base_price;
            }

            const name = embroidery.options[embroidery.selectedIndex]?.dataset?.name || 'NA';
            const label = nextRow.querySelector('.embroidery-name');
                  label.textContent = name;
        }

        const quantity = parseFloat(row.querySelector('.quantity').value) || 1;
        const other = parseFloat(row.querySelector('.other_charges').value) || 0;
        
        row.querySelector('.price').value = price;
        row.querySelector('.total').value = ((price * quantity) + other).toFixed(2);

        calculateTotalAmount();
    });

    function calculateTotalAmount() {
        let totalAmount = 0;
        const rows = document.querySelectorAll('#product_table tbody tr');
        rows.forEach(row => {
            if(row.querySelector('.total') && row.querySelector('.total').value){
                const total = parseFloat(row.querySelector('.total').value) || 0;
                totalAmount += total;
            }
        });

        const deliveryCharge = document.getElementById('deliveryCharge').value || 0;
        const discountCharge = document.getElementById('discount').value || 0;

        totalAmount = (parseFloat(totalAmount) + parseFloat(deliveryCharge)) - parseFloat(discountCharge);
       
        document.getElementById('totalAmount').value = totalAmount.toFixed(2);
    }

    function toggleDetails(itemId) {
        const detailsRow = document.getElementById(`details-${itemId}`);
        detailsRow.style.display = detailsRow.style.display === "none" ? "table-row" : "none";
    }

    // Get the textbox element
    const deliveryChargeTextBox = document.getElementById('deliveryCharge');
    let oldDiliveryCharge = 0;
    // Listen for the 'change' event
    deliveryChargeTextBox.addEventListener('change', function() {
        let deliveryCharge = parseFloat(deliveryChargeTextBox.value | 0);
        
        calculateDeliveryCharge(deliveryCharge);
    });

    function calculateDeliveryCharge(deliveryCharge){
        let totalAmount = document.getElementById('totalAmount').value;
        
            // frist remove oldDiliveryCharge from total
            totalAmount = parseFloat(totalAmount | 0) - parseFloat(oldDiliveryCharge);

            // assign new delivery charge
            oldDiliveryCharge = deliveryCharge;

        totalAmount = parseFloat(totalAmount) + parseFloat(deliveryCharge);
        document.getElementById('totalAmount').value = totalAmount.toFixed(2);
    }


    // Get the textbox element
    const discountTextBox = document.getElementById('discount');
    let oldDiscount = 0;
    // Listen for the 'change' event
    discountTextBox.addEventListener('change', function() {
        let discount = parseFloat(discountTextBox.value | 0);
        let totalAmount = document.getElementById('totalAmount').value;
        
            // frist remove oldDiliveryCharge from total
            totalAmount = parseFloat(totalAmount) + parseFloat(oldDiscount);

            // assign new delivery charge
            oldDiscount = discount;

        totalAmount = parseFloat(totalAmount) - parseFloat(discount);
        document.getElementById('totalAmount').value = totalAmount.toFixed(2);
    });

    function addCustomer() {  
        window.location.href = "{{ route('customers.create') }}";
    }  

    async function shareOnWhatsapp() {

        const orderId = "{{ session('order_id') ?? '' }}";
        
        if (!orderId) {
            alert("Order ID not found in session.");
            return;
        }
        const response = await fetch(`{{ route('download.invoice', ['id' => '__ID__']) }}`.replace('__ID__', orderId));
        
        // Fetching the generated PDF URL using AJAX
        const data = await response.json();
        const pdfUrl = window.location.origin + data.url; // Full URL of PDF

        // Replace with your actual logic to get the customer phone number
        const customerName = data.username;
        const customerPhone = data.mobile;
        
         // Trigger download
        const link = document.createElement('a');
        link.href = pdfUrl;
        link.download = `Invoice ${customerName}.pdf`
        link.click();

        // Custom message with customer name
        const message = `Hello ${customerName}, your invoice is ready. Please download it from this link: ${pdfUrl}`;
        const whatsappUrl = `https://wa.me/${customerPhone}?text=${encodeURIComponent(message)}`;

        // Opening WhatsApp Web
        window.open(whatsappUrl, '_blank');
    }
    
    // Detect page unload and clear session
    window.addEventListener("beforeunload", function (e) {
        navigator.sendBeacon("{{ Session::forget('order_id'); }}");
    });

     function handleCityChange(selectElement){
        // Get the selected option
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        
        // Get the delivery charge from the data attribute
        const deliveryCharge = selectedOption.getAttribute('data-price') || 0;

        // Set the value in the delivery charge textbox
        document.getElementById('deliveryCharge').value = deliveryCharge;

        calculateDeliveryCharge(deliveryCharge);
     }
</script>
@endsection
