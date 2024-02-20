  <!-- Title -->
  <title>Admitro - Admin Panel HTML template</title>

  <!--Favicon -->
  <link rel="icon" href="{{ URL::asset('assets/images/brand/favicon.ico') }}" type="image/x-icon" />

  <!--Bootstrap css -->
  <link href="{{ URL::asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

  <!-- Style css -->
  <link href="{{ URL::asset('assets/css/style.css') }}" rel="stylesheet" />
  <link href="{{ URL::asset('assets/css/dark.css') }}" rel="stylesheet" />
  <link href="{{ URL::asset('assets/css/skin-modes.css') }}" rel="stylesheet" />

  <!-- Animate css -->
  <link href="{{ URL::asset('assets/css/animated.css') }}" rel="stylesheet" />

  <!--Sidemenu css -->
  <link href="{{ URL::asset('assets/css/sidemenu.css') }}" rel="stylesheet">

  <!-- P-scroll bar css-->
  <link href="{{ URL::asset('assets/plugins/p-scrollbar/p-scrollbar.css') }}" rel="stylesheet" />

  <!---Icons css-->
  <link href="{{ URL::asset('assets/css/icons.css') }}" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet" />
  @yield('css')
  @stack('styles')
  <!-- Simplebar css -->
  <link rel="stylesheet" href="{{ URL::asset('assets/plugins/simplebar/css/simplebar.css') }}">

  <!-- Color Skin css -->
  <link id="theme" href="{{ URL::asset('assets/colors/color1.css') }}" rel="stylesheet" type="text/css" />
  <link id="theme" href="{{ URL::asset('assets/switcher.css') }}" rel="stylesheet" type="text/css" />
  <link id="theme" href="{{ URL::asset('assets/demo.css') }}" rel="stylesheet" type="text/css" />
  <style>
  table#data_table tbody * {
  font-size: 14px;
  text-align: left;
  font-weight: normal;
  }
  </style>
