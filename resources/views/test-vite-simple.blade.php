<!DOCTYPE html>
<html>
<head>
    <title>Vite Test - Standard Laravel</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Standard Laravel Vite CSS loading -->
    @vite([
        'resources/assets/vendor/scss/core.scss',
        'resources/assets/vendor/scss/theme-default.scss',
        'resources/assets/css/demo.css'
    ])
    
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .test-box { 
            background: #f8f9fa; 
            border: 1px solid #dee2e6; 
            padding: 20px; 
            margin: 10px 0; 
            border-radius: 5px; 
        }
    </style>
</head>
<body>
    <h1>CSS Loading Test - Standard Laravel @vite</h1>
    
    <div class="test-box">
        <h3>Standard Laravel Vite Integration</h3>
        <p>This page uses the standard @vite directive!</p>
        
        <button class="btn btn-primary">Test Button</button>
        
        <div class="alert alert-success mt-3">
            If this button is styled, CSS is loading properly!
        </div>
    </div>
    
    <div class="test-box">
        <h3>Debug Info</h3>
        <p><strong>Vite function exists:</strong> {{ function_exists('vite') ? 'Yes' : 'No' }}</p>
        <p><strong>Laravel version:</strong> {{ app()->version() }}</p>
        <p><strong>Vite class exists:</strong> {{ class_exists('Illuminate\Foundation\Vite') ? 'Yes' : 'No' }}</p>
        <p><strong>Manifest exists:</strong> {{ file_exists(public_path('build/manifest.json')) ? 'Yes' : 'No' }}</p>
    </div>
    
    <p><a href="/test-css">Back to CSS Test</a> | <a href="/login">Go to Login</a></p>
    
    <!-- Standard Laravel Vite JS loading -->
    @vite([
        'resources/assets/vendor/libs/jquery/jquery.js',
        'resources/assets/vendor/js/bootstrap.js'
    ])
</body>
</html> 