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
    
	<title>Hexabe - Invitación de usuario</title>

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
              		
              		<h4 class="mb-2 text-center fw-bold">Crear cuenta! 👋</h4>
              		<p class="mb-4 text-center">Has recibido una invitación para formar parte de un equipo. Por favor ingresa los datos a continuación</p>

					<form class="mb-3" action="{{ route('team.invitation.save', ['token' => $token]) }}" method="POST">
						@if(Session::has('login.fail'))
							<p class="error text-center" >
								{{ Session::get('login.fail') }}
							</p>
						@endif
						@csrf
                        <div class="mb-3">
							<label for="name" class="form-label">Nombre</label>
							<input type="text" class="form-control" id="name" name="name" placeholder="Introduzca su nombre" autofocus required/>
							@error('name')<p class="error">{{ $message }}</p> @enderror
						</div>

                        <div class="mb-3">
							<label for="lastname" class="form-label">Apellidos</label>
							<input type="text" class="form-control" id="lastname" name="lastname" placeholder="Introduzca sus apellidos"/>
							@error('lastname')<p class="error">{{ $message }}</p> @enderror
						</div>

						<div class="mb-3">
							<label for="email" class="form-label">Email</label>
							<input type="text" class="form-control" id="email" name="email" placeholder="Introduzca su email" readonly value="{{ $email }}"/>
						</div>

                        <div class="mb-3">
							<label for="phone" class="form-label">Teléfono</label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text" style="padding:5px 6px;">
                                    <img src="{{ asset('assets/img/flags/flag-bo.svg') }}" style="width:26px;"> <small class="ms-1">+591</small>
                                </span>
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="Introduzca su teléfono"/>
                            </div>
							@error('phone')<p class="error">{{ $message }}</p> @enderror
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

						<div class="mb-3 form-password-toggle">
							<div class="d-flex justify-content-between">
								<label class="form-label" for="password_confirmation">Confirmar contraseña</label>
							</div>
							<div class="input-group input-group-merge">
								<input type="password" id="password_confirmation" class="form-control" name="password_confirmation" placeholder="······" autocomplete="off" minlength="4" maxlength="20" required/>
							</div>
							@error('password_confirmation')<p class="error">{{ $message }}</p> @enderror
						</div>
						
						<div class="mb-3">
							<br>
							<button class="btn btn-primary d-grid w-100" type="submit"> Crear cuenta </button>
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
