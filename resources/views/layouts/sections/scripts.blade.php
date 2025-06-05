<!-- BEGIN: Vendor JS-->

@loadjs('resources/assets/vendor/libs/jquery/jquery.js')
@loadjs('resources/assets/vendor/libs/popper/popper.js')
@loadjs('resources/assets/vendor/js/bootstrap.js')
@loadjs('resources/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')
@loadjs('resources/assets/vendor/js/menu.js')

@yield('vendor-script')
<!-- END: Page Vendor JS-->
<!-- BEGIN: Theme JS-->
@loadjs('resources/assets/js/main.js')

<!-- END: Theme JS-->
<!-- Pricing Modal JS-->
@stack('pricing-script')
<!-- END: Pricing Modal JS-->
<!-- BEGIN: Page JS-->
@yield('page-script')
<!-- END: Page JS-->
