@extends('layout')

@section('main')
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
                                <input type="checkbox" class="switch-input" checked>
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
                                <input type="checkbox" class="switch-input" checked>
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
                                <input type="checkbox" class="switch-input" checked>
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
            </ul>
        </div>
    </div>
@endsection