<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="{{ asset('/assets/img/favicon.png') }}" />

    <title>Recuperar contraseña</title>

    <link rel="stylesheet" href="{{asset('/assets/admin/fonts/style.css')}}" />
    <link rel="stylesheet" href="{{asset('/assets/admin/vendor/fonts/boxicons.css')}}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{asset('/assets/admin/vendor/css/core.css')}}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{asset('/assets/admin/vendor/css/theme-default.css')}}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{asset('/assets/admin/vendor/css/pages/page-auth.css')}}" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body class="back-green">
    <div style="position:fixed;top:20px;left:20px;">
        <img src="{{ asset('assets/img/hexabe-iso-logo.svg') }}" alt="HexaBe">
    </div>
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <div class="card">
            	    <div class="card-body">

                        <div class="panel mg-auto" style="max-width:365px;">
                            <div class="text-center">
                                <h4 class="mb-2">Restaurar Contraseña 🫣</h4>
                                <p class="text-small color-hint"> Ingrese su correo electrónico y restablezca su contraseña. </p>
                            </div>
                    
                            <form id="formReset" action="{{ route('resetpassword.request', ['token' => $token]) }}" method="POST">
                                @csrf
                                <br>
                                <div class="form-group">
                                    <label for="email" class="label"><b> E-mail: </b></label>

                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text" id="basic-addon-search31"><i class="icon-base bx bx-envelope"></i></span>
                                        <input id="email" name="email" type="text" class="form-control" placeholder="Introduzca su e-mail" value="{{ old('email') }}">
                                    </div>
                                    <div id="emailError" class="error">{{$errors->first()}}</div>
                                </div>
                                <div class="text-center mt-4">
                                    <p class="text-small color-hint"> Le llegará un correo con instrucciones para restablecer su contraseña </p>
                                </div>
                    
                                <div class="form-group mb-0 mt-3">
                                    <button type="submit" class="btn btn-primary d-grid w-100">Enviar solicitud</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>