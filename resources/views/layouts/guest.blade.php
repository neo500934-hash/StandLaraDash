<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Login') - LiteAdmin</title>
  <meta name="robots" content="noindex, nofollow">
  <meta name="description" content="LiteAdmin - Bootstrap Admin Template">
  <meta name="keywords" content="admin, dashboard, bootstrap">

  <!-- Favicons -->
  <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
  <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <!-- Google Fonts - Inter + JetBrains Mono -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets/vendors/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendors/remixicon/remixicon.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendors/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendors/phosphor-icons/phosphor-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendors/lucide-icons/lucide.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendors/simple-datatables/style.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendors/quill/quill.snow.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendors/quill/quill.bubble.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendors/choices.js/choices.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">

  @stack('styles')

  <!-- =======================================================
    * Template Name: LiteAdmin - Bootstrap Admin Template
    * Template URL: https://bootstrapmade.com/lite-admin-dashboard-template/
    * Updated: Apr 8, 2026 with Bootstrap v5.3.8
    * Author: BootstrapMade.com
    * License: https://bootstrapmade.com/license/
    ======================================================== -->
</head>

<body>
  @yield('content')

  <!-- Vendor JS Files -->
  <script src="{{ asset('assets/vendors/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendors/apexcharts/apexcharts.min.js') }}"></script>
  <script src="{{ asset('assets/vendors/chart.js/chart.umd.js') }}"></script>
  <script src="{{ asset('assets/vendors/echarts/echarts.min.js') }}"></script>
  <script src="{{ asset('assets/vendors/simple-datatables/simple-datatables.js') }}"></script>
  <script src="{{ asset('assets/vendors/quill/quill.js') }}"></script>
  <script src="{{ asset('assets/vendors/tinymce/tinymce.min.js') }}"></script>
  <script src="{{ asset('assets/vendors/choices.js/choices.min.js') }}"></script>
  <script src="{{ asset('assets/vendors/flatpickr/flatpickr.min.js') }}"></script>
  <script src="{{ asset('assets/vendors/php-email-form/validate.js') }}"></script>

  <!-- Template Main JS Files -->
  <script src="{{ asset('assets/js/main.js') }}"></script>

  <!-- App Sidebar Toggle (for app pages with sidebars) -->
  <script src="{{ asset('assets/js/apps-sidebar-toggle.js') }}"></script>

  @stack('scripts')
</body>

</html>
