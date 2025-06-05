<!-- BEGIN: Theme CSS-->
<!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

{{-- Load Essential CSS Files Directly from Manifest --}}
<link rel="stylesheet" href="{{ asset('build/assets/core-DzPXZmyI.css') }}">
<link rel="stylesheet" href="{{ asset('build/assets/theme-default-AfcCBw0u.css') }}">
<link rel="stylesheet" href="{{ asset('build/assets/demo-1L0brNjh.css') }}">
<link rel="stylesheet" href="{{ asset('build/assets/boxicons-BL-Hx8g2.css') }}">
<link rel="stylesheet" href="{{ asset('build/assets/perfect-scrollbar-iCvgFzBc.css') }}">
<link rel="stylesheet" href="{{ asset('build/assets/app-PYZMiv0K.css') }}">

@yield('vendor-style')

<!-- Page Styles -->
@yield('page-style')
