<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dashboard\Analytics;
use App\Http\Controllers\layouts\WithoutMenu;
use App\Http\Controllers\layouts\WithoutNavbar;
use App\Http\Controllers\layouts\Fluid;
use App\Http\Controllers\layouts\Container;
use App\Http\Controllers\layouts\Blank;
use App\Http\Controllers\pages\AccountSettingsAccount;
use App\Http\Controllers\pages\AccountSettingsNotifications;
use App\Http\Controllers\pages\AccountSettingsConnections;
use App\Http\Controllers\pages\MiscError;
use App\Http\Controllers\pages\MiscUnderMaintenance;
use App\Http\Controllers\authentications\UserLogin;
use App\Http\Controllers\authentications\AdminLogin;
use App\Http\Controllers\authentications\RegisterBasic;
use App\Http\Controllers\authentications\ForgotPasswordBasic;
use App\Http\Controllers\cards\CardBasic;
use App\Http\Controllers\user_interface\Accordion;
use App\Http\Controllers\user_interface\Alerts;
use App\Http\Controllers\user_interface\Badges;
use App\Http\Controllers\user_interface\Buttons;
use App\Http\Controllers\user_interface\Carousel;
use App\Http\Controllers\user_interface\Collapse;
use App\Http\Controllers\user_interface\Dropdowns;
use App\Http\Controllers\user_interface\Footer;
use App\Http\Controllers\user_interface\ListGroups;
use App\Http\Controllers\user_interface\Modals;
use App\Http\Controllers\user_interface\Navbar;
use App\Http\Controllers\user_interface\Offcanvas;
use App\Http\Controllers\user_interface\PaginationBreadcrumbs;
use App\Http\Controllers\user_interface\Progress;
use App\Http\Controllers\user_interface\Spinners;
use App\Http\Controllers\user_interface\TabsPills;
use App\Http\Controllers\user_interface\Toasts;
use App\Http\Controllers\user_interface\TooltipsPopovers;
use App\Http\Controllers\user_interface\Typography;
use App\Http\Controllers\extended_ui\PerfectScrollbar;
use App\Http\Controllers\extended_ui\TextDivider;
use App\Http\Controllers\icons\Boxicons;
use App\Http\Controllers\form_elements\BasicInput;
use App\Http\Controllers\form_elements\InputGroups;
use App\Http\Controllers\form_layouts\VerticalForm;
use App\Http\Controllers\form_layouts\HorizontalForm;
use App\Http\Controllers\tables\Basic as TablesBasic;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ShadeController;
use App\Http\Controllers\PatternController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\EmbroideryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\ItemController;
use Illuminate\Support\Facades\DB;

// Simple test route for debugging
Route::get('/test', function () {
    return 'Laravel is working! ' . now();
});

// Debug route to check database and environment
Route::get('/debug', function () {
    try {
        $dbStatus = DB::connection()->getPdo() ? 'Connected' : 'Failed';
    } catch (Exception $e) {
        $dbStatus = 'Error: ' . $e->getMessage();
    }
    
    return response()->json([
        'status' => 'Laravel is working!',
        'time' => now(),
        'database' => $dbStatus,
        'app_name' => config('app.name'),
        'app_env' => config('app.env'),
        'app_debug' => config('app.debug'),
    ]);
});

// Asset debug route to check Vite assets
Route::get('/debug-assets', function () {
    $manifestPath = public_path('build/manifest.json');
    $manifestExists = file_exists($manifestPath);
    $manifestContent = $manifestExists ? json_decode(file_get_contents($manifestPath), true) : null;
    
    $buildDir = public_path('build');
    $cssFiles = [];
    $jsFiles = [];
    
    if (is_dir($buildDir)) {
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($buildDir));
        foreach ($files as $file) {
            if ($file->isFile()) {
                $relativePath = str_replace($buildDir . '/', '', $file->getPathname());
                if (str_ends_with($file->getFilename(), '.css')) {
                    $cssFiles[] = $relativePath;
                } elseif (str_ends_with($file->getFilename(), '.js')) {
                    $jsFiles[] = $relativePath;
                }
            }
        }
    }
    
    return response()->json([
        'manifest_exists' => $manifestExists,
        'manifest_path' => $manifestPath,
        'manifest_content' => $manifestContent,
        'css_files' => $cssFiles,
        'js_files' => $jsFiles,
        'build_directory_exists' => is_dir($buildDir),
        'vite_function_exists' => function_exists('vite'),
    ]);
});

// Test route to check Vite CSS generation
Route::get('/test-css', function () {
    return view('test-css');
});

// Test route to check Vite functionality
Route::get('/test-vite', function () {
    return response()->json([
        'vite_function_exists' => function_exists('vite'),
        'vite_facade_exists' => class_exists('Illuminate\Support\Facades\Vite'),
        'vite_class_exists' => class_exists('Illuminate\Foundation\Vite'),
        'laravel_version' => app()->version(),
        'available_facades' => array_keys(app()->getLoadedProviders()),
    ]);
});

// Test route to verify our custom CSS loader
Route::get('/test-css-loader', function () {
    $assetLoader = app('App\Services\AssetLoader');
    
    return response()->json([
        'css_output' => $assetLoader->loadCss('resources/assets/vendor/scss/core.scss'),
        'js_output' => $assetLoader->loadJs('resources/assets/js/main.js'),
        'all_assets' => $assetLoader->getAllAssets(),
        'manifest_exists' => file_exists(public_path('build/manifest.json')),
    ]);
});

// Redirect root to login for unauthenticated users
Route::get('/', function () {
    return redirect('/login');
});

// layout
Route::get('/layouts/without-menu', [WithoutMenu::class, 'index'])->name('layouts-without-menu');
Route::get('/layouts/without-navbar', [WithoutNavbar::class, 'index'])->name('layouts-without-navbar');
Route::get('/layouts/fluid', [Fluid::class, 'index'])->name('layouts-fluid');
Route::get('/layouts/container', [Container::class, 'index'])->name('layouts-container');
Route::get('/layouts/blank', [Blank::class, 'index'])->name('layouts-blank');

// pages
Route::get('/pages/account-settings-account', [AccountSettingsAccount::class, 'index'])->name('pages-account-settings-account');
Route::get('/pages/account-settings-notifications', [AccountSettingsNotifications::class, 'index'])->name('pages-account-settings-notifications');
Route::get('/pages/account-settings-connections', [AccountSettingsConnections::class, 'index'])->name('pages-account-settings-connections');
Route::get('/pages/misc-error', [MiscError::class, 'index'])->name('pages-misc-error');
Route::get('/pages/misc-under-maintenance', [MiscUnderMaintenance::class, 'index'])->name('pages-misc-under-maintenance');


// cards
Route::get('/cards/basic', [CardBasic::class, 'index'])->name('cards-basic');

// User Interface
Route::get('/ui/accordion', [Accordion::class, 'index'])->name('ui-accordion');
Route::get('/ui/alerts', [Alerts::class, 'index'])->name('ui-alerts');
Route::get('/ui/badges', [Badges::class, 'index'])->name('ui-badges');
Route::get('/ui/buttons', [Buttons::class, 'index'])->name('ui-buttons');
Route::get('/ui/carousel', [Carousel::class, 'index'])->name('ui-carousel');
Route::get('/ui/collapse', [Collapse::class, 'index'])->name('ui-collapse');
Route::get('/ui/dropdowns', [Dropdowns::class, 'index'])->name('ui-dropdowns');
Route::get('/ui/footer', [Footer::class, 'index'])->name('ui-footer');
Route::get('/ui/list-groups', [ListGroups::class, 'index'])->name('ui-list-groups');
Route::get('/ui/modals', [Modals::class, 'index'])->name('ui-modals');
Route::get('/ui/navbar', [Navbar::class, 'index'])->name('ui-navbar');
Route::get('/ui/offcanvas', [Offcanvas::class, 'index'])->name('ui-offcanvas');
Route::get('/ui/pagination-breadcrumbs', [PaginationBreadcrumbs::class, 'index'])->name('ui-pagination-breadcrumbs');
Route::get('/ui/progress', [Progress::class, 'index'])->name('ui-progress');
Route::get('/ui/spinners', [Spinners::class, 'index'])->name('ui-spinners');
Route::get('/ui/tabs-pills', [TabsPills::class, 'index'])->name('ui-tabs-pills');
Route::get('/ui/toasts', [Toasts::class, 'index'])->name('ui-toasts');
Route::get('/ui/tooltips-popovers', [TooltipsPopovers::class, 'index'])->name('ui-tooltips-popovers');
Route::get('/ui/typography', [Typography::class, 'index'])->name('ui-typography');

// extended ui
Route::get('/extended/ui-perfect-scrollbar', [PerfectScrollbar::class, 'index'])->name('extended-ui-perfect-scrollbar');
Route::get('/extended/ui-text-divider', [TextDivider::class, 'index'])->name('extended-ui-text-divider');

// icons
Route::get('/icons/boxicons', [Boxicons::class, 'index'])->name('icons-boxicons');

// form elements
Route::get('/forms/basic-inputs', [BasicInput::class, 'index'])->name('forms-basic-inputs');
Route::get('/forms/input-groups', [InputGroups::class, 'index'])->name('forms-input-groups');

// form layouts
Route::get('/form/layouts-vertical', [VerticalForm::class, 'index'])->name('form-layouts-vertical');
Route::get('/form/layouts-horizontal', [HorizontalForm::class, 'index'])->name('form-layouts-horizontal');

// tables
Route::get('/tables/basic', [TablesBasic::class, 'index'])->name('tables-basic');

// Route::get('/register', [RegisterController::class, 'create'])->middleware('guest')->name('register');
// Route::post('/register', [RegisterController::class, 'store'])->middleware('guest')->name('register.perform');
// Route::get('/login', [LoginController::class, 'show'])->middleware('guest')->name('login');
// Route::post('/login', [LoginController::class, 'login'])->middleware('guest')->name('login.perform');


// User Login
// Route::get('/', [UserLogin::class, 'show'])->middleware('auth')->name('/');
Route::get('/login', [UserLogin::class, 'index'])->middleware('guest')->name('login');
Route::post('/login', [UserLogin::class, 'login'])->name('login.perform');
Route::get('/logout', [UserLogin::class, 'logout'])->name('logout');

//Admin Login
Route::get('/admin', [AdminLogin::class, 'show'])->middleware('auth')->name('admin');
Route::get('/adminlogin', [AdminLogin::class, 'index'])->middleware('guest')->name('adminlogin');
Route::post('/adminlogin', [AdminLogin::class, 'login'])->name('adminlogin.perform');


// Route::middleware(['auth', 'is_admin'])->group(function () {
Route::get('/user', [UserController::class, 'index'])->name('user.index');
Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
Route::post('/user', [UserController::class, 'store'])->name('user.store');
Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.destroy');
Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');



// Route::middleware(['auth', 'is_admin'])->group(function () {
Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
Route::get('/customers/create', [CustomerController::class, 'create'])->name('customers.create');
Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
Route::get('/customers/{id}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
Route::delete('/customers/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');
Route::put('/customers/{id}', [CustomerController::class, 'update'])->name('customers.update');


Route::get('/auth/forgot-password-basic', [ForgotPasswordBasic::class, 'index'])->name('auth-reset-password-basic');

// Dashboard route
Route::get('/dashboard', [Analytics::class, 'index'])->middleware('auth')->name('dashboard-analytics');
Route::get('/user/dashboard', [UserController::class, 'dashbord'])->name('user.dashboard');
Route::get('/warehouse/dashboard', [WarehouseController::class, 'index'])->name('warehouse.dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('orders', [OrderController::class, 'store'])->name('orders.store');

});


Route::get('/shades', [ShadeController::class, 'index'])->name('shades.index');
Route::get('shades/create', [ShadeController::class, 'create'])->name('shades.create');
Route::post('shades', [ShadeController::class, 'store'])->name('shades.store');
Route::resource('shades', ShadeController::class);

Route::get('/patterns', [PatternController::class, 'index'])->name('patterns.index');
Route::get('patterns/create', [PatternController::class, 'create'])->name('patterns.create');
Route::post('patterns', [PatternController::class, 'store'])->name('patterns.store');
Route::resource('patterns', PatternController::class);

 Route::get('/sizes', [SizeController::class, 'index'])->name('sizes.index');
 Route::get('sizes/create', [SizeController::class, 'create'])->name('sizes.create');
 Route::post('sizes', [SizeController::class, 'store'])->name('sizes.store');
 Route::resource('sizes', SizeController::class);

 Route::get('/embroideries', [EmbroideryController::class, 'index'])->name('embroideries.index');
 Route::get('embroideries/create', [EmbroideryController::class, 'create'])->name('embroideries.create');
 Route::post('embroideries', [EmbroideryController::class, 'store'])->name('embroideries.store');
 Route::resource('embroideries', EmbroideryController::class);

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('products/create', [ProductController::class, 'create'])->name('products.create');
Route::post('products', [ProductController::class, 'store'])->name('products.store');
Route::resource('products', ProductController::class);

Route::resource('items', ItemController::class);

Route::get('/order', [OrderController::class, 'index'])->name('order.index');
Route::get('/order/create', [OrderController::class, 'create'])->name('order.create');
Route::post('/order', [OrderController::class, 'store'])->name('order.store');
Route::resource('order', OrderController::class);

Route::get('/order/{id}/pdf', [OrderController::class, 'generatePDF'])->name('order.pdf');
// Route to download and generate PDF
Route::get('/download-invoice/{id}', [OrderController::class, 'downloadInvoice'])->name('download.invoice');

// Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
// Route::get('/customers', [CustomerController::class, 'create'])->name('customers.create');
// Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
// Route::resource('customers', CustomerController::class);

Route::get('/items', [OrderItemController::class, 'index']);

Route::resource('warehouses', WarehouseController::class);

Route::resource('cities', CityController::class);

// Manual CSS loading route as Vite workaround
Route::get('/load-css', function () {
    $manifestPath = public_path('build/manifest.json');
    
    if (!file_exists($manifestPath)) {
        return response('Manifest not found', 404);
    }
    
    $manifest = json_decode(file_get_contents($manifestPath), true);
    $cssFiles = [];
    
    // Extract CSS files from manifest
    foreach ($manifest as $key => $asset) {
        if (isset($asset['file']) && str_ends_with($asset['file'], '.css')) {
            $cssFiles[] = $asset['file'];
        }
    }
    
    $cssContent = '';
    foreach ($cssFiles as $cssFile) {
        $cssPath = public_path('build/' . $cssFile);
        if (file_exists($cssPath)) {
            $cssContent .= file_get_contents($cssPath) . "\n";
        }
    }
    
    return response($cssContent)
        ->header('Content-Type', 'text/css')
        ->header('Cache-Control', 'public, max-age=31536000');
});
