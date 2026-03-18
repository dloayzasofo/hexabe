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
    
	<title>Agencia de bolsa</title>

	<link rel="stylesheet" href="{{asset('/assets/admin/fonts/style.css')}}" />
    <link rel="stylesheet" href="{{asset('/assets/admin/vendor/fonts/boxicons.css')}}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{asset('/assets/admin/vendor/css/core.css')}}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{asset('/assets/admin/vendor/css/theme-default.css')}}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{asset('/assets/admin/vendor/css/pages/page-auth.css')}}" />

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

</head>
<body>
<div style="position:fixed;top:20px;left:20px;">
	<img src="{{ asset('assets/img/hexabe-iso-logo.svg') }}" alt="HexaBe">
</div>
<div class="container-xxl">
     <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
          	<!-- Register -->
          	<div class="card">
            	<div class="card-body">
              		<div class="app-brand justify-content-center">
                		<div class="app-brand-link gap-2 fw-bold">
							<span style='color:#243C78;font-size:32px;font-family:"Poppins",sans-serif;'>Hexa</span>
							<span style='color:#FE7531;font-size:32px;font-family:"Poppins",sans-serif;margin-left:-7px;'>Be</span>
						</div>
              		</div>

              		<!-- /Logo -->
              		<h4 class="mb-2">Bienvenido! 👋</h4>
              		<p class="mb-4">Por favor ingresa los datos a continuación</p>

					<form id="formAuthentication" class="mb-3" action="{{ route('login.signup') }}" method="POST">
						@if(Session::has('login.fail'))
							<p class="error text-center" >
								{{ Session::get('login.fail') }}
							</p>
						@endif
						@csrf
						<div class="mb-3">
							<label for="email" class="form-label">Email</label>
							<input type="text" class="form-control" id="email" name="email" placeholder="Introduzca su email" autofocus required/>
							@error('email')<p class="error">{{ $message }}</p> @enderror
						</div>

						<div class="mb-3 form-password-toggle">
							<div class="d-flex justify-content-between">
								<label class="form-label" for="password">Contraseña</label>
							</div>
							<div class="input-group input-group-merge">
								<input type="password" id="password" class="form-control" name="password" placeholder="······" autocomplete="off" minlength="4" maxlength="20" required/>
							</div>
							@error('password')<p class="error">{{ $message }}</p> @enderror
						</div>
						
						<div class="mb-3">
							<br>
							<button class="btn btn-primary d-grid w-100" type="submit"> Ingresar </button>
						</div>
					</form>
            	</div>
          	</div>
          	<!-- /Register -->
        </div>
    </div>
</div>
</body>
</html>
