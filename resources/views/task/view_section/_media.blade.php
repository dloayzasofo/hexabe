<div class="mt-4 mb-4">
    <div class="fw-bold">Archivos adjuntos y enlaces</div>

    @if( count($taskMedias) == 0 && count($taskLinks) == 0 )
        <div class="border rounded p-3 text-center mt-2" style="background:#F1F5F9;">
            No hay archivos adjuntos ni enlaces relacionados con esta tarea.
        </div>
    @endif
</div>

@if( count($taskMedias) > 0 )
    @foreach( $taskMedias as $taskMedia )
        @if( $taskMedia->media !== null )
        <div class="block border rounded mb-2" >
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <a href="{{ $taskMedia->media->url }}" target="_blank" class="block">
                        <div class="card" style="background:transparent;box-shadow:none;">
                            <div class="card-body" style="padding:10px;">
                                <div class="d-flex justify-content-start align-items-center user-name">
                                    <div class="avatar-wrapper">
                                        <div class="avatar avatar-md me-3">
                                            <span class="avatar-initial rounded bg-label-danger"><i class="icon-base bx bx-file icon-lg"></i></span>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <small>{{ $taskMedia->media->name }}</small>
                                        <small>{{ $taskMedia->media->size_literal }}</small>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </a>
                </div>
                <div class="p-2">
                    <a href="{{ $taskMedia->media->url }}" download="{{ $taskMedia->media->name }}" class="btn btn-icon btn-outline-secondary"
                        title="Descargar: {{ $taskMedia->media->name }}" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top">
                        <i class="bx bx-arrow-to-bottom"></i>
                    </a>
                </div>
            </div>
        </div>
        @endif
    @endforeach
@endif

@if( count($taskLinks) > 0 )
    @foreach( $taskLinks as $taskLink )
        <a href="{{ $taskLink->url }}" class="block" target="_blank">
            <div class="card mt-2" style="background:transparent;box-shadow:none; border: 1px solid #e2e8f0;">
                <div class="card-body" style="padding:10px;">
                    <div class="d-flex justify-content-start align-items-center user-name">
                        <div class="avatar-wrapper">
                            <div class="avatar avatar-md me-3">
                                <span class="avatar-initial rounded bg-label-danger"><i class="icon-base bx bx-link icon-lg"></i></span>
                            </div>
                        </div>
                        <div class="d-flex flex-column">
                            <small>{{ $taskLink->url }}</small>
                        </div>
                    </div>

                </div>
            </div>
        </a>
    @endforeach
@endif