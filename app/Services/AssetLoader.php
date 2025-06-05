<?php

namespace App\Services;

class AssetLoader
{
    private $manifest = null;
    
    public function __construct()
    {
        $this->loadManifest();
    }
    
    private function loadManifest()
    {
        $manifestPath = public_path('build/manifest.json');
        
        if (file_exists($manifestPath)) {
            $this->manifest = json_decode(file_get_contents($manifestPath), true);
        }
    }
    
    public function loadCss($assets = null)
    {
        if (!$this->manifest) {
            return '<!-- Vite manifest not found -->';
        }
        
        $cssFiles = [];
        
        // If specific assets are requested
        if ($assets) {
            $assetList = is_array($assets) ? $assets : [$assets];
            
            foreach ($assetList as $asset) {
                $asset = trim($asset, '"\'');
                if (isset($this->manifest[$asset]) && isset($this->manifest[$asset]['file'])) {
                    $file = $this->manifest[$asset]['file'];
                    if (str_ends_with($file, '.css')) {
                        $cssFiles[] = $file;
                    }
                }
            }
        } else {
            // Load all CSS files from manifest
            foreach ($this->manifest as $key => $asset) {
                if (isset($asset['file']) && str_ends_with($asset['file'], '.css')) {
                    $cssFiles[] = $asset['file'];
                }
            }
        }
        
        $output = '';
        foreach ($cssFiles as $cssFile) {
            $url = asset('build/' . $cssFile);
            $output .= '<link rel="stylesheet" href="' . $url . '">' . "\n";
        }
        
        return $output;
    }
    
    public function loadJs($assets = null)
    {
        if (!$this->manifest) {
            return '<!-- Vite manifest not found -->';
        }
        
        $jsFiles = [];
        
        // If specific assets are requested
        if ($assets) {
            $assetList = is_array($assets) ? $assets : [$assets];
            
            foreach ($assetList as $asset) {
                $asset = trim($asset, '"\'');
                if (isset($this->manifest[$asset]) && isset($this->manifest[$asset]['file'])) {
                    $file = $this->manifest[$asset]['file'];
                    if (str_ends_with($file, '.js')) {
                        $jsFiles[] = $file;
                    }
                }
            }
        } else {
            // Load all JS files from manifest
            foreach ($this->manifest as $key => $asset) {
                if (isset($asset['file']) && str_ends_with($asset['file'], '.js')) {
                    $jsFiles[] = $asset['file'];
                }
            }
        }
        
        $output = '';
        foreach ($jsFiles as $jsFile) {
            $url = asset('build/' . $jsFile);
            $output .= '<script src="' . $url . '"></script>' . "\n";
        }
        
        return $output;
    }
    
    public function getAllAssets()
    {
        return $this->manifest;
    }
} 