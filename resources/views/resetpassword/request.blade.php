<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="{{ asset('img/favicon.png') }}" />

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
                                <p class="text-small color-hint"> Ingrese una nueva contraseña y confirme. </p>
                            </div>

                            <form id="formReset" action="{{ route('resetpassword.reset', ['token'=> $token]) }}" method="POST">
                                @csrf
                                <br>
                                <div class="form-group">
                                    <label for="password" class="label"> Nueva contraseña </label>
                                    <div class="input-group">
                                        <input type="password" name="password" class="form-control" id="password" placeholder="············">
                                        <span id="passwordToggle" class="input-group-text cursor-pointer"><i id="passwordToggleIcon" class="icon-base bx bx-hide"></i></span>
                                    </div>
                                    {{--
                                    <div class="control">
                                        <div class="control-icon">
                                            <img src="{{ asset('img/icons/icon.pass.svg') }}">
                                        </div>
                                        <input id="password" type="password" name="password" placeholder="Introduzca una nueva contraseña" class="control-input">
                                    </div>
                                    --}}
                                    <div id="passwordError" class="error"></div>
                                </div>
                                
                                <div class="form-group mt-4">
                                    <label for="password_confirmed" class="label">Confirme nueva contraseña</label>
                                    <div class="input-group">
                                        <input type="password" name="password_confirmed" class="form-control" id="password_confirmed" placeholder="············">
                                        <span id="passwordToggleConfirm" class="input-group-text cursor-pointer"><i id="passwordToggleIconConfirm" class="icon-base bx bx-hide"></i></span>
                                    </div>
                                    {{-- 
                                    <div class="control">
                                        <div class="control-icon">
                                            <img src="{{ asset('img/icons/icon.pass.svg') }}">
                                        </div>
                                        <input id="password_confirmed" type="password" name="password_confirmed" placeholder="Introduzca la nueva contraseña" class="control-input">
                                    </div>
                                    --}}
                                    <div id="passwordConfirmedError" class="error"></div>
                                </div>
                    
                                <div class="form-group mb-0 mt-4 text-center">
                                    <button type="submit" class="btn btn-primary full-w">Restaurar contraseña</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.addEventListener('load', function(){
            document.getElementById('formReset').addEventListener('submit', handleSubmit);
        });
    
        function handleSubmit(e){
    
            if( validateForm() == false ){
                e.preventDefault();
                return false;
            }
    
            return true;
        }
    
        function validateForm(){
            let password = document.querySelector('#password');
            let passwordConfirmed = document.querySelector('#password_confirmed');
    
            let passwordError = document.querySelector('#passwordError');
            let passwordConfirmedError = document.querySelector('#passwordConfirmedError');
    
            let isOk = true;
    
            if( password.value == '' ){
                passwordError.innerHTML = 'El campo es requerido';
                isOk = false;
            }
    
            if( passwordConfirmed.value == '' ){
                passwordConfirmedError.innerHTML = 'El campo es requerido';
                isOk = false;
            }

            if( password.value !== passwordConfirmed.value ){
                passwordError.innerHTML = 'Los campos no coinciden';
                isOk = false;
            }
    
            return isOk;
        }

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

            document.querySelector('#passwordToggleConfirm').addEventListener('click', () => {
                let inputPassword = document.querySelector('#password_confirmed');
                let icon = document.querySelector('#passwordToggleIconConfirm');
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
        });
    </script>
</body>
</html>