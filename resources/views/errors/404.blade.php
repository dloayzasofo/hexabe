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
    
    <title>Agencia de bolsa Mercantil</title>

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

    <style>
        .tableInfo td{
            padding: 2px 10px;
        }
        .tableFondo th,
        .tableFondo td{
            padding: 10px 10px;
            width: 50%;
        }
        .tableTickets th:first-child,
        .tableTickets td:first-child{
            width: 15%;
        }
        .tableTickets th:last-child,
        .tableTickets td:last-child{
            width: 85%;
        }
        .tableTickets{
            background: #fff;
            width: 100%;
        }
        .tableTickets th,
        .tableTickets td{
            padding: 7px 10px;
        }
        .tableTickets th{
        }
        .wrap-tickets{
            max-height: 40vh;
            overflow: auto;
        }
    </style>
</head>
<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper">
        <div class="layout-container">
            <div class="content-wrapper">
                
                <div class="flex-grow-1 p-4">
                        

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card" style="min-height:90vh;">
                                <div class="card-header">
                                    <div class="d-flex align-items-center pb-4">
                                        <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" style="max-width:150px;">
                                    </div>
                                    <hr class="m-0">
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 mt-5">
                                            <div class="text-center mt-5">
                                                <h2>ERROR 404 Página no encontrada.</h2>
                                                <p>
                                                    Lo sentimos pero no podemos encontrar lo que buscas
                                                </p>
                                            </div>
                                            <div class="text-center">
                                                {{--
                                                <div class="mt-4">
                                                    <a href="{{ route('dashboard.index') }}" class="btn btn-primary">
                                                        <span>
                                                            <svg class="menu-icon" width="20" height="20" fill="currentColor" viewBox="0 0 24 24" transform="" id="injected-svg" xmlns="http://www.w3.org/2000/svg"><!--Boxicons v3.0.8 https://boxicons.com | License  https://docs.boxicons.com/free--><path d="M20 11h-6c-.55 0-1 .45-1 1v8c0 .55.45 1 1 1h6c.55 0 1-.45 1-1v-8c0-.55-.45-1-1-1m-1 8h-4v-6h4zm-9-4H4c-.55 0-1 .45-1 1v4c0 .55.45 1 1 1h6c.55 0 1-.45 1-1v-4c0-.55-.45-1-1-1m-1 4H5v-2h4zM20 3h-6c-.55 0-1 .45-1 1v4c0 .55.45 1 1 1h6c.55 0 1-.45 1-1V4c0-.55-.45-1-1-1m-1 4h-4V5h4zm-9-4H4c-.55 0-1 .45-1 1v8c0 .55.45 1 1 1h6c.55 0 1-.45 1-1V4c0-.55-.45-1-1-1m-1 8H5V5h4z"></path></svg>
                                                        </span>
                                                        Volver al panel de control
                                                    </a>
                                                </div>
                                                <div class="mt-3">
                                                    <a href="{{ route('task.index') }}" class="btn btn-primary">
                                                        <i class="menu-icon bx bx-bar-chart-square"></i>
                                                        Ir a la sección de tareas
                                                    </a>
                                                </div>
                                                --}}
                                                <div class="mt-3">
                                                    <a href="{{ url()->previous() }}" class="btn btn-label-warning">
                                                        <i class="menu-icon bx bx-undo"></i>
                                                        Vovler atras
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <footer class="content-footer footer bg-footer-theme">
                    <div class=" d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                        <div class="mb-2 mb-md-0" style="padding-left: 1.5rem;">
                            © Copyright
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

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <link rel="stylesheet" href="{{asset('/assets/admin/css/fobo.css')}}?v=1.0.1">

    <script src="{{asset('/assets/admin/vendor/libs/jquery/jquery.js')}}"></script>
    <script src="{{asset('/assets/admin/vendor/js/bootstrap.js')}}"></script>
    <script src="{{asset('/assets/admin/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
    {{--<script src="{{asset('/assets/admin/vendor/js/menu.js')}}"></script>--}}

    <!-- Main JS -->
  </body>
</html>
