<!DOCTYPE html>
<html>
<head>
    <title>CSS Test</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Load CSS files directly from manifest -->
    <link rel="stylesheet" href="{{ asset('build/assets/core-DzPXZmyI.css') }}">
    <link rel="stylesheet" href="{{ asset('build/assets/theme-default-AfcCBw0u.css') }}">
    <link rel="stylesheet" href="{{ asset('build/assets/demo-1L0brNjh.css') }}">
    <link rel="stylesheet" href="{{ asset('build/assets/boxicons-BL-Hx8g2.css') }}">
    <link rel="stylesheet" href="{{ asset('build/assets/app-PYZMiv0K.css') }}">
    
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .test-box { 
            background: #f8f9fa; 
            border: 1px solid #dee2e6; 
            padding: 20px; 
            margin: 10px 0; 
            border-radius: 5px; 
        }
        .success { color: #28a745; }
        .error { color: #dc3545; }
    </style>
</head>
<body>
    <h1>CSS Loading Test</h1>
    
    <div class="test-box">
        <h3>Direct CSS Loading Test</h3>
        <p>If you can see styled content below, direct CSS loading is working:</p>
        
        <!-- These should be styled if Bootstrap/Core CSS is loaded -->
        <button class="btn btn-primary">Primary Button</button>
        <button class="btn btn-secondary">Secondary Button</button>
        
        <div class="alert alert-success mt-3">
            This should be a green success alert if Bootstrap CSS is loaded.
        </div>
    </div>
    
    <div class="test-box">
        <h3>Debug Information</h3>
        <p><strong>Manifest exists:</strong> {{ file_exists(public_path('build/manifest.json')) ? 'Yes' : 'No' }}</p>
        <p><strong>Build directory exists:</strong> {{ is_dir(public_path('build')) ? 'Yes' : 'No' }}</p>
        <p><strong>CSS files count:</strong> {{ count(glob(public_path('build/**/*.css'))) }}</p>
        
        @if(file_exists(public_path('build/manifest.json')))
            <p><strong>Manifest content (first 500 chars):</strong></p>
            <pre style="background: #f1f1f1; padding: 10px; font-size: 12px;">{{ substr(file_get_contents(public_path('build/manifest.json')), 0, 500) }}...</pre>
        @endif
    </div>
    
    <div class="test-box">
        <h3>Manual CSS Links Test</h3>
        <p>Testing direct CSS file access:</p>
        
        @php
            $cssFiles = glob(public_path('build/assets/*.css'));
        @endphp
        
        @if(count($cssFiles) > 0)
            @foreach(array_slice($cssFiles, 0, 3) as $cssFile)
                @php
                    $relativePath = str_replace(public_path(), '', $cssFile);
                @endphp
                <p>
                    <a href="{{ $relativePath }}" target="_blank">{{ basename($cssFile) }}</a>
                    ({{ round(filesize($cssFile) / 1024, 2) }} KB)
                </p>
            @endforeach
        @else
            <p class="error">No CSS files found in build/assets directory</p>
        @endif
    </div>
    
    <div class="test-box">
        <h3>Navigation</h3>
        <a href="/debug-assets">View Asset Debug JSON</a> | 
        <a href="/login">Go to Login</a> | 
        <a href="/test">Basic Test</a>
    </div>
</body>
</html> 