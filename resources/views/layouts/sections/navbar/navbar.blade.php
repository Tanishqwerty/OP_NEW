@php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
$containerNav = $containerNav ?? 'container-fluid';
$navbarDetached = ($navbarDetached ?? '');
@endphp

<style>
    .dropdown-toggle:after {
      margin-left: 0.5em !important;
    }
</style>
<!-- Navbar -->
<!-- @if(isset($navbarDetached) && $navbarDetached == 'navbar-detached')
<nav class="layout-navbar {{$containerNav}} navbar navbar-expand-xl {{$navbarDetached}} align-items-center bg-navbar-theme" id="layout-navbar">
@endif -->
@if(isset($navbarDetached) && $navbarDetached == '')
<nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
  <div class="{{$containerNav}}">
    @endif

      <!--  Brand demo (display only for navbar-full and hide on below xl) -->
      @if(isset($navbarFull))
      <div class="navbar-brand app-brand demo d-none d-xl-flex py-0 me-4">
        <a href="{{url('/')}}" class="app-brand-link gap-2">
          <span class="app-brand-logo demo">@include('_partials.macros',["width"=>25,"withbg"=>'var(--bs-primary)'])</span>
          <span class="app-brand-text demo menu-text fw-bold text-heading">{{config('variables.templateName')}}</span>
        </a>
      </div>
      @endif

      <!-- ! Not required for layout-without-menu -->
      @if(!isset($navbarHideToggle))
      <div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0{{ isset($menuHorizontal) ? ' d-xl-none ' : '' }} {{ isset($contentNavbar) ?' d-xl-none ' : '' }}">
        <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
          <i class="bx bx-menu bx-md"></i>
        </a>
      </div>
      @endif

      <!-- start-->
      <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Dynamic Navigation</title>
        <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> -->
      </head>
      <body>

      <nav class="navbar navbar-expand-lg navbar-light bg-light mb-1" style="padding-top: 0px;padding-bottom: 0px;background-color: white !important;">
        <img src="{{ asset('assets/img/logo.jpeg') }}" alt="Logo" width= 150px style = "height: 50px; width: 89px; margin-left: 10px";>
        <div class="container-fluid">
          <!-- <a class="navbar-brand" href="#">Navbar</a> -->
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0" id="menu"></ul>
            <form class="d-flex" onsubmit="return false">
              <a href="{{ route('logout') }}" style="display: inline-block; margin: 20px 30px;">
                <b><span>LogOut</span></b>
              </a>
            </form>
          </div>
        </div>
      </nav>

      <script>
      const userRole = "{{ Auth::user()->role->name ?? '' }}";
      const menuData = {
        "menu": [
          { "url": "/", "name": "Dashboard", "icon": "bx bx-home-smile", "role": ["admin", "user"] },
          { "url": "/order", "name": "Order", "icon": "bx bx-cart", "role": ["admin", "user"] },
          { "url": "#", "name": "Factory Setting", "icon": "bx bx-buildings", "role": ["admin"], "submenu": [
            { "url": "/warehouses", "name": "Warehouse Setting", "role": ["admin"] },
            { "url": "/user", "name": "User Setting", "role": ["admin"] },
            { "url": "/customers", "name": "Customers", "role": ["admin", "customer"] },
            { "url": "/cities", "name": "Cities", "role": ["admin"] }
          ] },
          { "url": "#", "name": "Material Setting", "icon": "bx bx-cog", "role": ["admin"], "submenu": [
            { "url": "/shades", "name": "Shades", "role": ["admin"] },
            { "url": "/patterns", "name": "Patterns", "role": ["admin"] },
            { "url": "/sizes", "name": "Sizes", "role": ["admin"] },
            { "url": "/embroideries", "name": "Embroidery", "role": ["admin"] },
            { "url": "/products", "name": "Items", "role": ["admin"] }
          ] }
        ]
      };

      function createMenu(menuData, userRole) {
        const menu = document.getElementById('menu');
        menuData.menu.forEach(item => {
          if (item.role.includes(userRole)) {
            const li = document.createElement('li');
            li.className = 'nav-item';
            if (item.submenu) {
              li.className += ' dropdown';
              const dropdownLink = `<a class="nav-link dropdown-toggle" href="#" id="${item.name.replace(/\s+/g, '')}" data-bs-toggle="dropdown" aria-expanded="false"> <i class="menu-icon tf-icons ${item.icon}" style="margin-top: -7px; margin-right: 1px; color: #007acc; font-weight: 500;"></i><b style="color: black;">${item.name}</b></a>`;
              li.innerHTML = dropdownLink;
              const dropdownMenu = document.createElement('ul');
              dropdownMenu.className = 'dropdown-menu';
              item.submenu.forEach(sub => {
                if (sub.role.includes(userRole)) {
                  const subLi = document.createElement('li');
                  subLi.innerHTML = `<a class="dropdown-item" href="${sub.url}"> <i class="menu-icon tf-icons ${sub.icon}" style="margin-top: -7px; margin-right: 1px; color: #007acc; font-weight: 500;"></i><b style="color: black;">${sub.name}</b></a>`;
                  dropdownMenu.appendChild(subLi);
                }
              });
              li.appendChild(dropdownMenu);
            } else {
              li.innerHTML = `<a class="nav-link" href="${item.url}"> <i class="menu-icon tf-icons ${item.icon}" style="margin-top: -7px; margin-right: 1px; color: #007acc; font-weight: 500;"></i><b style="color: black;">${item.name}</b></a>`;
            }
            menu.appendChild(li);
          }
        });
      }

      createMenu(menuData, userRole);
      </script>

      </body>
      </html>

      <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <!-- Search -->
        <!-- <div class="navbar-nav align-items-center">
          <div class="nav-item d-flex align-items-center">
            <i class="bx bx-search bx-md"></i>
            <input type="text" class="form-control border-0 shadow-none ps-1 ps-sm-2" placeholder="Search..." aria-label="Search...">
          </div>
        </div> -->
        <!-- /Search -->
    <!-- <ul class="navbar-nav flex-row align-items-center ms-auto">
          <li class="nav-item navbar-dropdown dropdown-user dropdown">
            <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);" data-bs-toggle="dropdown">
              <div class="avatar avatar-online">
                <img src="{{ asset('assets/img/avatars/1.png') }}" alt class="w-px-40 h-auto rounded-circle">
              </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li>
                <a class="dropdown-item" href="javascript:void(0);">
                  <div class="d-flex">
                    <div class="flex-shrink-0 me-3">
                      <div class="avatar avatar-online">
                        <img src="{{ asset('assets/img/avatars/1.png') }}" alt class="w-px-40 h-auto rounded-circle">
                      </div>
                    </div>
                    <div class="flex-grow-1">
                       <h6 class="mb-0">John Doe</h6>
                       <small class="text-muted">Admin</small>
                    </div>
                  </div>
                </a>
              </li> 
              <li>
                <div class="dropdown-divider my-1"></div>
              </li>
              <li>
                <a class="dropdown-item" href="javascript:void(0);">
                  <i class="bx bx-user bx-md me-3"></i><span>My Profile</span>
                </a>
              </li>
              <li>
                <a class="dropdown-item" href="javascript:void(0);">
                  <i class="bx bx-cog bx-md me-3"></i><span>Settings</span>
                </a>
              </li>
              <li>
                <a class="dropdown-item" href="javascript:void(0);">
                  <span class="d-flex align-items-center align-middle">
                    <i class="flex-shrink-0 bx bx-credit-card bx-md me-3"></i><span class="flex-grow-1 align-middle">Billing Plan</span>
                    <span class="flex-shrink-0 badge rounded-pill bg-danger">4</span>
                  </span>
                </a>
              </li>
              <li>
                <div class="dropdown-divider my-1"></div>
              </li>
              <li> 
              <li>
                <a href="{{ route('logout') }}" style="display: inline-block; margin: 20px 30px;">
                  <span>LogOut</span>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </div> -->

      @if(!isset($navbarDetached))
    </div>
    @endif
  </nav>
  <!-- / Navbar -->
