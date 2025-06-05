@php
use Illuminate\Support\Facades\Vite;
@endphp
<!-- laravel style -->
@php
$manifestPath = public_path('build/manifest.json');
$jsAssets = [
    'resources/assets/vendor/js/helpers.js',
    'resources/assets/js/config.js'
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

<!-- Place this tag in your head or just before your close body tag. -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
