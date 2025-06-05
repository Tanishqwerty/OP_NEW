<!-- BEGIN: Vendor JS-->

{{-- Load Essential JS Files Directly from Manifest --}}
<script src="{{ asset('build/assets/jquery-8QpT-S21.js') }}"></script>
<script src="{{ asset('build/assets/popper-DBXphNvS.js') }}"></script>
<script src="{{ asset('build/assets/bootstrap-B-W6M1Y3.js') }}"></script>
<script src="{{ asset('build/assets/perfect-scrollbar-DPYX2UL_.js') }}"></script>
<script src="{{ asset('build/assets/menu-Bldkajpn.js') }}"></script>

@yield('vendor-script')
<!-- END: Page Vendor JS-->
<!-- BEGIN: Theme JS-->
<script src="{{ asset('build/assets/main-CWila6Zz.js') }}"></script>

<!-- END: Theme JS-->
<!-- Pricing Modal JS-->
@stack('pricing-script')
<!-- END: Pricing Modal JS-->
<!-- BEGIN: Page JS-->
@yield('page-script')
<!-- END: Page JS-->
