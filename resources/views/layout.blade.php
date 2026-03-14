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
</head>
<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      	<div class="layout-container">
			<!-- Menu -->
			<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
				<div class="app-brand demo">
					<a href="{--{ route('admin.index') }}" class="app-brand-link">
						<span class="app-brand-logo demo">
							<svg
							width="25"
							viewBox="0 0 25 42"
							version="1.1"
							xmlns="http://www.w3.org/2000/svg"
							xmlns:xlink="http://www.w3.org/1999/xlink"
							>
								<defs>
									<path
									d="M13.7918663,0.358365126 L3.39788168,7.44174259 C0.566865006,9.69408886 -0.379795268,12.4788597 0.557900856,15.7960551 C0.68998853,16.2305145 1.09562888,17.7872135 3.12357076,19.2293357 C3.8146334,19.7207684 5.32369333,20.3834223 7.65075054,21.2172976 L7.59773219,21.2525164 L2.63468769,24.5493413 C0.445452254,26.3002124 0.0884951797,28.5083815 1.56381646,31.1738486 C2.83770406,32.8170431 5.20850219,33.2640127 7.09180128,32.5391577 C8.347334,32.0559211 11.4559176,30.0011079 16.4175519,26.3747182 C18.0338572,24.4997857 18.6973423,22.4544883 18.4080071,20.2388261 C17.963753,17.5346866 16.1776345,15.5799961 13.0496516,14.3747546 L10.9194936,13.4715819 L18.6192054,7.984237 L13.7918663,0.358365126 Z"
									id="path-1"
									></path>
									<path
									d="M5.47320593,6.00457225 C4.05321814,8.216144 4.36334763,10.0722806 6.40359441,11.5729822 C8.61520715,12.571656 10.0999176,13.2171421 10.8577257,13.5094407 L15.5088241,14.433041 L18.6192054,7.984237 C15.5364148,3.11535317 13.9273018,0.573395879 13.7918663,0.358365126 C13.5790555,0.511491653 10.8061687,2.3935607 5.47320593,6.00457225 Z"
									id="path-3"
									></path>
									<path
									d="M7.50063644,21.2294429 L12.3234468,23.3159332 C14.1688022,24.7579751 14.397098,26.4880487 13.008334,28.506154 C11.6195701,30.5242593 10.3099883,31.790241 9.07958868,32.3040991 C5.78142938,33.4346997 4.13234973,34 4.13234973,34 C4.13234973,34 2.75489982,33.0538207 2.37032616e-14,31.1614621 C-0.55822714,27.8186216 -0.55822714,26.0572515 -4.05231404e-15,25.8773518 C0.83734071,25.6075023 2.77988457,22.8248993 3.3049379,22.52991 C3.65497346,22.3332504 5.05353963,21.8997614 7.50063644,21.2294429 Z"
									id="path-4"
									></path>
									<path
									d="M20.6,7.13333333 L25.6,13.8 C26.2627417,14.6836556 26.0836556,15.9372583 25.2,16.6 C24.8538077,16.8596443 24.4327404,17 24,17 L14,17 C12.8954305,17 12,16.1045695 12,15 C12,14.5672596 12.1403557,14.1461923 12.4,13.8 L17.4,7.13333333 C18.0627417,6.24967773 19.3163444,6.07059163 20.2,6.73333333 C20.3516113,6.84704183 20.4862915,6.981722 20.6,7.13333333 Z"
									id="path-5"
									></path>
								</defs>
								<g id="g-app-brand" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
									<g id="Brand-Logo" transform="translate(-27.000000, -15.000000)">
									<g id="Icon" transform="translate(27.000000, 15.000000)">
										<g id="Mask" transform="translate(0.000000, 8.000000)">
										<mask id="mask-2" fill="white">
											<use xlink:href="#path-1"></use>
										</mask>
										<use fill="#266141" xlink:href="#path-1"></use>
										<g id="Path-3" mask="url(#mask-2)">
											<use fill="#266141" xlink:href="#path-3"></use>
											<use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-3"></use>
										</g>
										<g id="Path-4" mask="url(#mask-2)">
											<use fill="#266141" xlink:href="#path-4"></use>
											<use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-4"></use>
										</g>
										</g>
										<g
										id="Triangle"
										transform="translate(19.000000, 11.000000) rotate(-300.000000) translate(-19.000000, -11.000000) "
										>
										<use fill="#266141" xlink:href="#path-5"></use>
										<use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-5"></use>
										</g>
									</g>
									</g>
								</g>
							</svg>
						</span>
						<span class="app-brand-text menu-text fw-bolder ms-2" style="text-transform:capitalize;font-size:20px;">Agencia Bolsa</span>
					</a>

					<a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block" style="background-color:#266141;">
						<i class="bx bx-chevron-left bx-sm align-middle"></i>
					</a>
				</div>

				<div class="menu-inner-shadow"></div>

				<ul class="menu-inner py-1">
					<!-- Dashboard -->
					<li id="menu-admin" class="menu-item">
						<a href="{--{ route('admin.index') }}" class="menu-link">
							<i class="menu-icon tf-icons bx bx-home-circle"></i>
							<div data-i18n="Analytics">Dashboard</div>
						</a>
					</li>
					<li id="menu-logout" class="menu-item">
						<a href="{--{ route('admin.login.exit') }}" class="menu-link" style="color:#ff3e1d;">
							<i class="menu-icon tf-icons bx bx-log-out"></i>
							<div>Salir</div>
						</a>
					</li>

					<li class="menu-header small text-uppercase">
						<span class="menu-header-text">Novedades</span>
					</li>
					<li id="menu-blog-article" class="menu-item">
						<a href="{--{ route('admin.blog.article.index') }}" class="menu-link">
							<i class="menu-icon bx bx-edit"></i>
							<div>Artículos</div> 
						</a>
					</li>
					<li id="menu-blog-category" class="menu-item">
						<a href="{--{ route('admin.blog.category.index') }}" class="menu-link">
							<i class="menu-icon bx bx-tag"></i>
							<div>Categorías</div>
						</a>
					</li>

					<li class="menu-header small text-uppercase">
						<span class="menu-header-text">Aula Bursatil</span>
					</li>
					<li id="menu-bursatil-article" class="menu-item">
						<a href="{--{ route('admin.bursatil.article.index') }}" class="menu-link">
							<i class="menu-icon bx bx-edit"></i>
							<div>Artículos</div> 
						</a>
					</li>
					<li id="menu-bursatil-category" class="menu-item">
						<a href="{--{ route('admin.bursatil.category.index') }}" class="menu-link">
							<i class="menu-icon bx bx-tag"></i>
							<div>Categorías</div>
						</a>
					</li>
					<li id="menu-bursatil-video" class="menu-item">
						<a href="{--{ route('admin.bursatil.video.index') }}" class="menu-link">
							<i class="menu-icon bx bx-play-circle"></i>
							<div>Videos</div>
						</a>
					</li>
					
					<li class="menu-header small text-uppercase">
						<span class="menu-header-text">Estructuración</span>
					</li>
					<li id="menu-gestion" class="menu-item">
						<a href="{--{ route('admin.structure.gestion.index') }}" class="menu-link">
							<i class="menu-icon bx bx-calendar"></i>
							<div>Gestión</div>
						</a>
					</li>
					<li id="menu-bono" class="menu-item">
						<a href="{--{ route('admin.structure.bono.index') }}" class="menu-link">
							<i class="menu-icon bx bx-dollar"></i>
							<div>Bonos</div>
						</a>
					</li>
					<li id="menu-archivo" class="menu-item">
						<a href="{--{ route('admin.structure.archivo.index') }}" class="menu-link">
							<i class="menu-icon bx bx-file"></i>
							<div>Archivos</div>
						</a>
					</li>

					<li class="menu-header small text-uppercase">
						<span class="menu-header-text">Simuladores</span>
					</li>
					<li id="menu-pagare" class="menu-item">
						<a href="{--{ route('admin.simulator.pagare.index') }}" class="menu-link">
							<i class="menu-icon bx bx-pen"></i>
							<div>Pagaré</div>
						</a>
					</li>
					

					<li class="menu-header small text-uppercase">
						<span class="menu-header-text">Módulos</span>
					</li>
					<li id="menu-service" class="menu-item drop">
						<a href="javascript:void(0);" class="menu-link menu-toggle">
						  <i class="menu-icon tf-icons bx bx-analyse"></i>
						  <div>Servicios</div>
						</a>
						<ul class="menu-sub">
							<li id="menu-requisitos" class="menu-item">
								<a href="{--{ route('admin.service.requisitos.index') }}" class="menu-link">
									<div>Requisitos</div>
								</a>
							</li>
							<li id="menu-tarifario" class="menu-item">
								<a href="{--{ route('admin.tarifario.index') }}" class="menu-link">
									<div>Tarifario</div>
								</a>
							</li>
						</ul>
					</li>
					<li id="menu-memory" class="menu-item">
						<a href="{--{ route('admin.memory.index') }}" class="menu-link">
							<i class="menu-icon bx bx-history"></i>
							<div>Memorias</div>
						</a>
					</li>
					<li id="menu-financial" class="menu-item">
						<a href="{--{ route('admin.financial.index') }}" class="menu-link">
							<i class="menu-icon bx bx-chart"></i>
							<div>Estados financieros</div>
						</a>
					</li>
					<li id="menu-award" class="menu-item">
						<a href="{--{ route('admin.award.index') }}" class="menu-link">
							<i class="menu-icon bx bx-medal"></i>
							<div>Reconocimientos</div>
						</a>
					</li>
					<li id="menu-team" class="menu-item">
						<a href="{--{ route('admin.team.index') }}" class="menu-link">
							<i class='menu-icon bx bx-group'></i> 
							<div>Equipo</div>
						</a>
					</li>
					<li id="menu-ask" class="menu-item">
						<a href="{--{ route('admin.ask.index') }}" class="menu-link">
							<i class="menu-icon bx bx-task"></i>
							<div>Preguntas</div>
						</a>
					</li>
					<li id="menu-job" class="menu-item">
						<a href="{--{ route('admin.job.index') }}" class="menu-link">
							<i class="menu-icon bx bxs-graduation"></i>
							<div>Trabajos</div>
						</a>
					</li>
					<li id="menu-popup" class="menu-item">
						<a href="{--{ route('admin.popup.index') }}" class="menu-link">
							<i class="menu-icon bx bx-copy"></i>
							<div>Popups</div>
						</a>
					</li>
					

					<li class="menu-header small text-uppercase">
						<span class="menu-header-text">Formularios</span>
					</li>
					<li id="menu-forms-postulations" class="menu-item drop">
						<a href="{--{ route('admin.forms.postulations.index') }}" class="menu-link">
						  <i class="menu-icon bx bxs-food-menu"></i>
						  <div>Postulaciones</div>
						</a>
					</li>
					<li id="menu-forms-cv" class="menu-item drop">
						<a href="{--{ route('admin.forms.cv.index') }}" class="menu-link">
						  <i class="menu-icon bx bxs-food-menu"></i>
						  <div>Curriculums</div>
						</a>
					</li>
					<li id="menu-forms-contact" class="menu-item drop">
						<a href="{--{ route('admin.forms.contact.index') }}" class="menu-link">
						  <i class="menu-icon bx bxs-food-menu"></i>
						  <div>Contacto</div>
						</a>
					</li>
					<li id="menu-forms-service" class="menu-item drop">
						<a href="{--{ route('admin.forms.service.index') }}" class="menu-link">
						  <i class="menu-icon bx bxs-food-menu"></i>
						  <div>Pre apertura</div>
						</a>
					</li>
					<li id="menu-forms-boletin" class="menu-item drop">
						<a href="{--{ route('admin.forms.boletin.index') }}" class="menu-link">
						  <i class="menu-icon bx bxs-food-menu"></i>
						  <div>Boletín</div>
						</a>
					</li>
				
					<!-- Misc -->
					<li class="menu-header small text-uppercase"><span class="menu-header-text">Configuración</span></li>
					<li id="menu-contact" class="menu-item">
						<a href="{--{ route('admin.config.contact.index') }}" class="menu-link">
							<i class="menu-icon bx bx-envelope"></i>
							<div>Correos</div>
						</a>
					</li>
					<li id="menu-user" class="menu-item">
						<a href="{--{ route('admin.user.index') }}" class="menu-link">
							<i class="menu-icon bx bx-user"></i>
							<div>Usuarios</div>
						</a>
					</li>
					<!-- Misc -->
					<li class="menu-header small text-uppercase"><span class="menu-header-text">Logs</span></li>
					<li id="menu-historial" class="menu-item">
						<a href="{--{ route('admin.logs.index') }}" class="menu-link">
							<i class='menu-icon bx bx-time-five'></i>
							<div>Historial</div>
						</a>
					</li>
					<li>
						<br>
					</li>
				</ul>
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
    @yield('footer')
  </body>
</html>
