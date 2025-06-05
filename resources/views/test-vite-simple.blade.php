<!DOCTYPE html>
<html>
<head>
    <title>Vite Test</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Test if @vite directive works -->
    @vite(['resources/assets/vendor/scss/core.scss'])
    
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
    <h1>Vite Directive Test</h1>
    
    <div class="test-box">
        <h3>@vite Directive Test</h3>
        <p>If this page loads without errors, the @vite directive is working!</p>
        
        <button class="btn btn-primary">Test Button</button>
        
        <div class="alert alert-info mt-3">
            If this button is styled, CSS is loading properly.
        </div>
    </div>
    
    <div class="test-box">
        <h3>Debug Info</h3>
        <p><strong>Vite function exists:</strong> {{ function_exists('vite') ? 'Yes' : 'No' }}</p>
        <p><strong>Laravel version:</strong> {{ app()->version() }}</p>
    </div>
    
    <p><a href="/test-css">Back to CSS Test</a> | <a href="/login">Go to Login</a></p>
</body>
</html> 