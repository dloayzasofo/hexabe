<!DOCTYPE html>
<html
  lang="es"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="/assets/admin/"
  data-template="vertical-menu-template-free"
>
<head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />
	
	<meta name="referrer" content="none" />
	<meta name="referrer" content="none-when-downgrade" />
	<meta name="referrer" content="origin" />
	<meta name="referrer" content="origin-when-cross-origin" />
	<meta name="referrer" content="unsafe-url" />
	
    <title>@yield('title')</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="{{asset('/assets/admin/fonts/style.css')}}" />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{asset('/assets/admin/vendor/fonts/boxicons.css')}}" />
    
    <!-- Core CSS -->
    <link rel="stylesheet" href="{{asset('/assets/admin/vendor/css/core.css')}}" class="template-customizer-core-css" />
    <!-- <link rel="stylesheet" href="="{{asset('/assets/admin/vendor/css/core.css')}}" class="template-customizer-core-css" /> -->
    <link rel="stylesheet" href="{{asset('/assets/admin/vendor/css/theme-default.css')}}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{asset('/assets/admin/css/demo.css')}}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{asset('/assets/admin/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />
    <link rel="stylesheet" href="{{asset('/assets/admin/vendor/libs/apex-charts/apex-charts.css')}}" />
    <!-- Page CSS -->

    <!-- Helpers -->
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <script src="{{asset('/assets/admin/vendor/js/helpers.js')}}"></script>
    <script src="{{asset('/assets/admin/js/config.js')}}"></script>

    @yield('header')
	<script>
		let urlSearchUser = "{{ route('user.search-user') }}";
		let urlSearchByKey = "{{ route('user.search-by-key') }}";
	</script>
</head>
<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      	<div class="layout-container">
			<!-- Menu -->
			<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
				<div class="app-brand demo">
					<a href="{{ route('dashboard.index') }}" class="app-brand-link">
						<span class="app-brand-logo demo">
							<div class="app-brand-link gap-2 fw-bold">
								<span style='color:#243C78;font-size:32px;font-family:"Poppins",sans-serif;'>Hexa</span>
								<span style='color:#FE7531;font-size:32px;font-family:"Poppins",sans-serif;margin-left:-7px;'>Be</span>
							</div>
						</span>
					</a>
					<a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block" style="background-color:#266141;">
						<i class="bx bx-chevron-left bx-sm align-middle"></i>
					</a>
				</div>

				<div class="menu-inner-shadow"></div>

				<ul class="menu-inner py-1">
					
					<li id="menu-dashboard" class="menu-item">
						<a href="{{ route('dashboard.index') }}" class="menu-link">
							<svg class="menu-icon" width="20" height="20" fill="currentColor" viewBox="0 0 24 24" transform="" id="injected-svg" xmlns="http://www.w3.org/2000/svg"><!--Boxicons v3.0.8 https://boxicons.com | License  https://docs.boxicons.com/free--><path d="M20 11h-6c-.55 0-1 .45-1 1v8c0 .55.45 1 1 1h6c.55 0 1-.45 1-1v-8c0-.55-.45-1-1-1m-1 8h-4v-6h4zm-9-4H4c-.55 0-1 .45-1 1v4c0 .55.45 1 1 1h6c.55 0 1-.45 1-1v-4c0-.55-.45-1-1-1m-1 4H5v-2h4zM20 3h-6c-.55 0-1 .45-1 1v4c0 .55.45 1 1 1h6c.55 0 1-.45 1-1V4c0-.55-.45-1-1-1m-1 4h-4V5h4zm-9-4H4c-.55 0-1 .45-1 1v8c0 .55.45 1 1 1h6c.55 0 1-.45 1-1V4c0-.55-.45-1-1-1m-1 8H5V5h4z"></path></svg>
							<div>Panel de control</div>
						</a>
					</li>
					<li id="menu-task" class="menu-item">
						<a href="{{ route('task.index') }}" class="menu-link">
							<i class="menu-icon bx bx-bar-chart-square"></i>
							<div>Tareas</div>
						</a>
					</li>
					<li id="menu-popup" class="menu-item">
						<a href="{--{ route('admin.popup.index') }}" class="menu-link">
							<i class="menu-icon bx bx-bar-chart"></i>
							<div>Reportes</div>
						</a>
					</li>
					<li id="menu-popup" class="menu-item">
						<a href="{--{ route('admin.popup.index') }}" class="menu-link">
							<svg class="menu-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20"  
							fill="currentColor" viewBox="0 0 24 24" >
							<!--Boxicons v3.0.8 https://boxicons.com | License  https://docs.boxicons.com/free-->
								<path d="M20 3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2m0 2v7h-3.42c-.4 0-.76.24-.92.6-.64 1.46-2.08 2.4-3.66 2.4s-3.02-.94-3.66-2.4c-.16-.36-.52-.6-.92-.6H4V5zM4 19v-5h2.81c1.06 1.84 3.04 3 5.19 3s4.13-1.16 5.19-3H20v5z"></path>
							</svg>
							<div>Bandeja de entrada</div>
						</a>
					</li>
					<li id="menu-brand" class="menu-item">
						<a href="{{ route('brand.index') }}" class="menu-link">
							<i class="menu-icon bx bx-tag"></i>
							<div>Marcas</div>
						</a>
					</li>
					<li id="menu-team" class="menu-item">
						<a href="{{ route('team.index') }}" class="menu-link">
							<i class='menu-icon bx bx-group'></i> 
							<div>Equipos</div>
						</a>
					</li>
					<li id="menu-setting" class="menu-item">
						<a href="{{ route('setting.perfil.index') }}" class="menu-link">
							<i class='menu-icon bx bx-cog'></i> 
							<div>Ajustes</div>
						</a>
					</li>
					<li id="menu-logout" class="menu-item">
						<a href="{{ route('login.exit') }}" class="menu-link" style="color:#ff3e1d;">
							<i class="menu-icon tf-icons bx bx-log-out"></i>
							<div>Salir</div>
						</a>
					</li>
					<li>
						<br>
					</li>
				</ul>
 
				<div class="menu-footer-fixed border-top p-2">
					<div class="d-flex align-items-center py-3 px-4 border rounded-3 bg-label-warning">
						<div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
							<div class="me-3">
								<p class="mb-0 text-heading text-warning fw-bold">Vista: Super Admin</p>
								<small class="text-secondary">Acceso total</small>
							</div>
						</div>
						<div class="avatar flex-shrink-0">
							<label class="switch switch-warning">
								<input type="checkbox" class="switch-input" checked="" readonly disabled>
								<span class="switch-toggle-slider">
									<span class="switch-on">
										<i class="icon-base bx bx-check"></i>
									</span>
									<span class="switch-off">
										<i class="icon-base bx bx-x"></i>
									</span>
								</span>
							</label>
						</div>
					</div>
				</div>
			</aside>
			<!-- / Menu -->

			<!-- Layout container -->
			<div class="layout-page">
				

				<div class="content-wrapper">
					<div class="container-xxl flex-grow-1 container-p-y">
						@yield('main')
					</div>

					<footer class="content-footer footer bg-footer-theme">
						<div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
							<div class="mb-2 mb-md-0">
								©
								<script>
									document.write(new Date().getFullYear());
								</script>
								, desarrollado por
								<a href="https://sofopolis.com/" target="_blank" class="footer-link fw-bolder">sofopolis.com</a>
							</div>
						</div>
					</footer>

					<div class="content-backdrop fade"></div>
				</div>
			</div>
			<!-- / Layout page -->
		</div>

		<!-- Overlay -->
		<div class="layout-overlay layout-menu-toggle"></div>
	</div>
    <!-- / Layout wrapper -->

	<link rel="stylesheet" href="{{asset('/assets/admin/css/fobo.css')}}?v=1.0.1">

    <script src="{{asset('/assets/admin/vendor/libs/jquery/jquery.js')}}"></script>
    <script src="{{asset('/assets/admin/vendor/js/bootstrap.js')}}"></script>
    <script src="{{asset('/assets/admin/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
    <script src="{{asset('/assets/admin/vendor/js/menu.js')}}"></script>

    <!-- Main JS -->
    <script src="{{asset('/assets/admin/js/main.js')}}"></script>
    <script src="{{asset('/assets/admin/js/fobo.js')}}?v=1.0.2"></script>
    <!-- Place this tag in your head or just before your close body tag. -->
    <!-- <script async defer src="https://buttons.github.io/buttons.js"></script> -->
    @yield('script')
  </body>
</html>
