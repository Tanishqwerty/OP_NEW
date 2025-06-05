<!-- BEGIN: Vendor JS-->

@php
// Simple manifest-based JS loading
$manifestPath = public_path('build/manifest.json');
$jsAssets = [
    'resources/assets/vendor/libs/jquery/jquery.js',
    'resources/assets/vendor/libs/popper/popper.js',
    'resources/assets/vendor/js/bootstrap.js',
    'resources/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js',
    'resources/assets/vendor/js/menu.js',
    'resources/assets/js/main.js'
];

if (file_exists($manifestPath)) {
    $manifest = json_decode(file_get_contents($manifestPath), true);
    foreach ($jsAssets as $asset) {
        if (isset($manifest[$asset]['file'])) {
            echo '<script src="' . asset('build/' . $manifest[$asset]['file']) . '"></script>' . "\n";
        }
    }
}
@endphp

@yield('vendor-script')
<!-- END: Page Vendor JS-->
<!-- BEGIN: Theme JS-->

<!-- END: Theme JS-->
<!-- Pricing Modal JS-->
@stack('pricing-script')
<!-- END: Pricing Modal JS-->
<!-- BEGIN: Page JS-->
@yield('page-script')
<!-- END: Page JS-->
