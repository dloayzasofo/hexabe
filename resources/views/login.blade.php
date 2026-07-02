<!DOCTYPE html>
<html
  lang="es"
  class="light-style customizer-hide"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="/assets/admin/"
  data-template="vertical-menu-template-free"
>
<head>
	<meta charset="utf-8" />
	<meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
	/>
	<link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}" />
    
	<title>Hexabe - Login</title>

	<link rel="stylesheet" href="{{asset('/assets/admin/fonts/style.css')}}" />
    <link rel="stylesheet" href="{{asset('/assets/admin/vendor/fonts/boxicons.css')}}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{asset('/assets/admin/vendor/css/core.css')}}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{asset('/assets/admin/vendor/css/theme-default.css')}}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{asset('/assets/admin/vendor/css/pages/page-auth.css')}}" />

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
	<style>
		.card-login-form{
			font-family: "Poppins", sans-serif;
			min-height: 90vh;
			padding: 0px 30px;
			margin-top: 5vh;
		}
		.card-login-form .app-brand-link{
			color: #3959A9;
			font-weight: 700;
			font-size: 26px;
			margin: auto;
			text-align: center;
			justify-content: center;
		}
		.card-login-form .card-form{
			width: 100%;
			max-width: 440px;
		}
		.card-login-note{
			font-family: "Poppins", sans-serif;
			background:#F1F1F1;
			background-image: url(/assets/img/login-back.png);
			background-repeat: no-repeat;
			background-position: right bottom;
			background-size: 380px;
			border-radius: 40px;
			min-height: 90vh;
			padding: 0px 30px;
			margin-top: 5vh;
		}
		.card-login-note h1{
			font-weight: 800;
			font-size: 48px;
			line-height: 45px;
		}
		.card-login-note p{
			color: #3959A9;
			font-size: 20px;
			line-height: 24px;
			max-width: 340px;
			text-align: justify;
		}
	</style>
</head>
<body>
<div class="container-xxl">
	<div class="row">
		<div class="col-md-6">
			<div class="d-flex align-items-center card-login-note">
				<div>
					<h1>
						<span style="color:#FF7919;">EL ORDEN </span> <br>
						<span style="color:#3959A9;">empieza aquí</span>
					</h1>
					<p class="mt-4">
						<span style="color:#FF7919;">Hexa,</span> es una app de organización y gestión para agencias digitales que centraliza tareas, equipos, marcas, tiempos, entregas y reportes en un solo lugar.
					</p>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="d-flex flex-column align-items-center justify-content-center card-login-form">

				<div class="text-center">
					<img src="{{ asset('assets/img/isologo.svg') }}" alt="Logo" width="70"/>
					<div class="app-brand-link">Hexa</div>
					<h4 class="mb-2 mt-4 fw-bold">Optimiza tu trabajo</h4>
					<p class="mb-4">Gestiona tareas, proyectos y equipos desde un solo lugar.</p>
				</div>

				<div class="card card-form">
            		<div class="card-body">
						<form id="formAuthentication" class="mb-3" action="{{ route('login.signup') }}" method="POST">
							@if(Session::has('login.fail'))
								<p class="error text-center" >
									{{ Session::get('login.fail') }}
								</p>
							@endif
							@csrf
							<div class="mb-3">
								<label for="email" class="form-label">Email</label>
								<input type="text" class="form-control" id="email" name="email" placeholder="Introduzca su email" autofocus required value="{{ old('email') }}"/>
								@error('email')<p class="error">{{ $message }}</p> @enderror
							</div>

							<div class="mb-3 form-password-toggle">
								<div class="d-flex justify-content-between">
									<label class="form-label" for="password">Contraseña</label>
								</div>
								<div class="input-group">
									<input type="password" name="password" class="form-control" id="password" placeholder="············" value="{{ old('password') }}">
									<span id="passwordToggle" class="input-group-text cursor-pointer"><i id="passwordToggleIcon" class="icon-base bx bx-hide"></i></span>
								</div>
								@error('password')<p class="error">{{ $message }}</p> @enderror
							</div>
							
							<div class="mb-3">
								<br>
								<button class="btn btn-primary d-grid w-100 fw-bold" type="submit" style="background:#333D54;"> Iniciar sesión </button>
							</div>
						</form>
						<div class="mt-4 text-center">
							<br> &nbsp;
							<small>
								¿Olvidaste tu contraseña? <b><a href="{{ route('resetpassword.index') }}">Recuperar 🥲</a></b>
							</small>
						</div>
					</div>
		  		</div>
			</div>
		</div>
	</div>
</div>

<script>

	window.addEventListener('load', () => {
		document.querySelector('#passwordToggle').addEventListener('click', () => {
			let inputPassword = document.querySelector('#password');
			let icon = document.querySelector('#passwordToggleIcon');
			if (inputPassword.getAttribute('type') == 'password') {
				inputPassword.setAttribute('type', 'text');
				icon.classList.remove('bx-hide');
				icon.classList.add('bx-show');
			} else {
				inputPassword.setAttribute('type', 'password');
				icon.classList.remove('bx-show');
				icon.classList.add('bx-hide');
			}
		})
	})

</script>
</body>
</html>
