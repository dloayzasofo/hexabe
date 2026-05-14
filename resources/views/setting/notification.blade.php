@extends('layout')
@section('main')
	<div class="wrap-toast"></div>

    <div class="loading hide">
        <div class="spinner-border spinner-border-lg text-primary" role="status">
            <span class="visually-hidden"></span>
        </div>
        <div class="mt-2">
            Cargando...
        </div>
    </div>

    <div class="row" style="max-width:680px;margin:auto;">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item" role="presentation">
                <a href="{{ route('setting.perfil.index') }}" class="nav-link">
                Perfil
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="{{ route('setting.notification.index') }}" class="nav-link active fw-bold">
                Notificaciones
                </a>
            </li>
        </ul>

        <h5 class="mt-5"> <span style="color:#FE752F;"><i class="bx bx-envelope" style="font-size:26px;"></i></span> Notificaciones por Correo Electrónico</h5>

        <div class="card mb-1">
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div><b>Resumen diario</b></div>
                            <small>Recibe un resumen cada mañana con tus tareas pendientes y eventos del día.</small>
                        </div>
                        <div>
                            <label class="switch switch-warning">
                                <input type="checkbox" class="switch-input" checked readonly>
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
                </li>
                <li class="list-group-item">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div><b>Nuevas tareas asignadas</b></div>
                            <small>Te avisaremos inmediatamente cuando alguien te asigne una nueva tarea.</small>
                        </div>
                        <div>
                            <label class="switch switch-warning">
                                <input type="checkbox" class="switch-input" checked readonly>
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
                </li>
                <li class="list-group-item">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div><b>Comentarios</b></div>
                            <small>Notificaciones de comentarios en las tareas en las que participas.</small>
                        </div>
                        <div>
                            <label class="switch switch-warning">
                                <input type="checkbox" class="switch-input" checked readonly>
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
                </li>
            </ul>
        </div>

        <h5 class="mt-5"> <span style="color:#FE752F;"><i class="bx bx-bell" style="font-size:26px;"></i></span> Notificaciones Push/Escritorio</h5>

        <div class="card mb-6">
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div><b>Alertas en tiempo real</b></div>
                            <small>Notificaciones emergentes para actualizaciones críticas del proyecto.</small>
                        </div>
                        <div>
                            <label class="switch switch-warning">
                                <input id="pushNotification" type="checkbox" class="switch-input">
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
                </li>
                {{-- 
                <li class="list-group-item">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div><b>Recordatorios de fecha</b></div>
                            <small>Recordatorios de tareas que vencen pronto (1 hora antes).</small>
                        </div>
                        <div>
                            <label class="switch switch-warning">
                                <input type="checkbox" class="switch-input">
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
                </li>
                --}}
            </ul>
        </div>
    </div>
@endsection

@section('script')
<script type="module">
    import { initializeApp } from "https://www.gstatic.com/firebasejs/12.13.0/firebase-app.js";
    import { getMessaging, getToken } from "https://www.gstatic.com/firebasejs/12.13.0/firebase-messaging.js";

    const firebaseConfig = {
        apiKey: "AIzaSyDnoESSREzpXYaGmozBwhfBM-ZJSrgjl0A",
        authDomain: "hexabe-89665.firebaseapp.com",
        projectId: "hexabe-89665",
        storageBucket: "hexabe-89665.firebasestorage.app",
        messagingSenderId: "286270715444",
        appId: "1:286270715444:web:0b558ee31553a6992bbc61",
        measurementId: "G-E2BTDR3VYQ"
    };

    function initRequestNotification(){
        document.querySelector('.loading').classList.remove('hide');
        if ("Notification" in window) {
            Notification.requestPermission().then( (permission) => {
                if (permission === 'granted') {
                    localStorage.setItem('hexabe_permission_notification', 1); //granted browser
                    getTokenFirebase();
                } else {
                    checkStatusNotification();
                    document.querySelector('.loading').classList.add('hide');
                    alert('ERROR: No se pudo obtener permiso para notificar.');
                }
            });
        } else {
            checkStatusNotification();
            document.querySelector('.loading').classList.add('hide');
            alert('ERROR: Su navegador no soportan las notificaciones. Por favor, actualice su navegador.');
        }
    }

    function getTokenFirebase(){
        const app = initializeApp(firebaseConfig);
        const messaging = getMessaging(app);
        const config_push_notification_vapid = "BMk_G6cbLCiCsJECzuIFyOB3_DsaUXVHsuOaX_fCwutenYssTNn--REtAH0hrezra__YakRgWm5CtTPtrBDskJQ";

        getToken(messaging, { 
            vapidKey: config_push_notification_vapid
        }).then((currentToken) => {
            localStorage.setItem('hexabe_permission_notification', 2); //granted firebase
            if (currentToken) {
                saveServerNotificationToken(currentToken);
            } else {
                // Show permission request UI
                checkStatusNotification();
                document.querySelector('.loading').classList.add('hide');
                alert('ERROR: No se pudo generar el token del servidor de notificaciones.');
            }
        }).catch((err) => {
            checkStatusNotification();
            alert('ERROR: No se pudo conectar al servidor de notificaciones. \n' + err.message);
            document.querySelector('.loading').classList.add('hide');
            console.log('An error occurred while retrieving token. ', err.message);
        });
    }

    function saveServerNotificationToken(token){
        let source = localStorage.getItem('hexabe_permission_source');
        if( !source ){
            source = crypto.randomUUID();
            localStorage.setItem('hexabe_permission_source', source);
        }

        let formData = new FormData();
        formData.append('token', token);
        formData.append('source', source);
        formData.append('_token', '{{ csrf_token() }}');

        fetch("{{ route('firebase.save') }}", {
            method: 'POST',
            headers: {
                'Accept': 'application/json'
            },
            body: formData
        }).then(response => {
            return response.json();
        }).then(data => {
            console.log(data);
            renderSuccessServer(data);
        });
    }

    function renderSuccessServer(data){
        document.querySelector('.loading').classList.add('hide');
        if( data.message ) {
            const wrapToast = document.querySelector('.wrap-toast');
            let classAlert = data.success ? 'bg-success' : 'bg-danger';
            let idRandom = Math.random().toString(36).substring(2, 9);
            let html = `
                <div id="${idRandom}" class="bs-toast toast fade hide ${classAlert}" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="3000">
                <div class="toast-header">
                    <i class="icon-base bx bx-bell me-2"></i>
                    <div class="me-auto fw-medium">Tablero</div>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">${ data.message }</div>
                </div>
            `;

            wrapToast.insertAdjacentHTML('beforeend', html);
            setTimeout(() => {
                const toastElement = document.getElementById(idRandom);
                if (toastElement) {
                const toast = new bootstrap.Toast(toastElement);
                toast.show();
                }
            }, 150);
        }
        checkStatusNotification();
    }

    function deleteServerNotificationToken(){
        const source = localStorage.getItem('hexabe_permission_source');
        localStorage.setItem('hexabe_permission_notification', 1); //granted browser
        if( !source ){
            return;
        }

        let formData = new FormData();
        formData.append('source', source);
        formData.append('_token', '{{ csrf_token() }}');

        fetch("{{ route('firebase.delete') }}", {
            method: 'POST',
            headers: {
                'Accept': 'application/json'
            },
            body: formData
        }).then(response => {
            return response.json();
        }).then(data => {
            console.log(data);
            renderSuccessServer(data);
        });
    }

    window.addEventListener('load', function() {
        let checkEnablePush = document.getElementById('pushNotification');
        if( checkEnablePush ){
            checkStatusNotification();
        }

        if( checkEnablePush ){
            checkEnablePush.addEventListener('change', function() {
                if (this.checked) {
                    //saveServerNotificationToken('cHaSZMLEVw7RRB1QjfbVDd:APA91bHTw-hUPRyOBl-En9pmZaSAGnJLDn1or6goJoZ35K1eRP2V2RnEyl0c_UTlVbEz4m529VRSrfycxzavSpFHkaUcCqOdXzzMfaSjKFBz8CHBpnmxIQw');
                    initRequestNotification();
                } else {
                    console.log('Push notification disabled.');
                    deleteServerNotificationToken();
                }
            });
        }
    });

    function checkStatusNotification(){
        let checkEnablePush = document.getElementById('pushNotification');
        checkEnablePush.checked = localStorage.getItem('hexabe_permission_notification') == 2 ? true : false;
    }

</script>
@endsection