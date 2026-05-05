@if( $parent != null)
    <div class="card mt-4">
        <div class="card-body">
            <div class="mb-2"><small>TAREA PRINCIPAL</small></div>
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex justify-content-start align-items-center user-name">
                    <div class="avatar-wrapper">
                        <div class="avatar avatar-md me-3">
                            <a href="{{ route('task.user.list', [$parent['parent']->assign]) }}" class="text-heading text-truncate " title="{{ $parent['parent']->assign->name }}">
                                @if( $parent['parent']->assign->image != null )
                                    <img src="{{ $parent['parent']->assign->image }}" alt="Avatar" class="rounded-2">
                                @else 
                                    <span class="avatar-initial rounded-circle bg-label-danger">{{ $parent['parent']->assign->nameInitial }}</span>
                                @endif
                            </a>
                        </div>
                    </div>
                    <div class="d-flex flex-column">
                        <a href="{{ route('task.view', [$parent['parent']]) }}" class="text-heading text-truncate" style="text-wrap:auto;">
                            <span class="fw-medium">{{ \Str::limit($parent['parent']->title, 35, '...') }}</span>
                        </a>
                    </div>
                </div>
                <div>
                    @if( $parent['parent']->status == 'TOSTART' )
                        <span class="badge rounded-pill bg-label-secondary">Sin empezar</span>
                    @elseif( $parent['parent']->status == 'PROCESS' )
                        <span class="badge rounded-pill bg-label-primary">En proceso</span>
                    @elseif( $parent['parent']->status == 'DELAY' )
                        <span class="badge rounded-pill bg-label-danger">Retrasado</span>
                    @elseif( $parent['parent']->status == 'PAUSED' )
                        <span class="badge rounded-pill bg-label-warning">Pausado</span>
                    @elseif( $parent['parent']->status == 'FINALIZED' )
                        <span class="badge rounded-pill bg-label-success">Finalizado</span>
                    @endif
                </div>
            </div>

            @if( count($parent['childs']) > 0 )
                <div class="mb-2 mt-4"><small>SUBTAREAS</small> ({{ count($parent['childs']) }})</div>

                @foreach ($parent['childs'] as $item)
                    <div class="d-flex justify-content-between align-items-center rounded p-2" @if( $task->id == $item->id) style="background-color: #f8f8f8;" @endif>
                        <div class="d-flex justify-content-start align-items-center user-name">
                            <div class="avatar-wrapper">
                                <div class="avatar avatar-sm me-3">
                                    <a href="{{ route('task.user.list', [$item->assign]) }}" class="text-heading text-truncate" title="{{ $item->assign->name }}">
                                        @if( $item->assign->image != null )
                                            <img src="{{ $item->assign->image }}" alt="Avatar" class="rounded-2">
                                        @else 
                                            <span class="avatar-initial rounded-circle bg-label-danger">{{ $item->assign->nameInitial }}</span>
                                        @endif
                                    </a>
                                </div>
                            </div>
                            <div class="d-flex flex-column">
                                <a href="{{ route('task.view', [$item]) }}" class="text-heading text-truncate" style="text-wrap:auto;">
                                    <small class="fw-medium">{{ \Str::limit($item->title, 35, '...') }}</small>
                                </a>
                            </div>
                        </div>
                        <div>
                            @if( $item->status == 'TOSTART' )
                                <span class="badge rounded-pill bg-label-secondary">Sin empezar</span>
                            @elseif( $item->status == 'PROCESS' )
                                <span class="badge rounded-pill bg-label-primary">En proceso</span>
                            @elseif( $item->status == 'DELAY' )
                                <span class="badge rounded-pill bg-label-danger">Retrasado</span>
                            @elseif( $item->status == 'PAUSED' )
                                <span class="badge rounded-pill bg-label-warning">Pausado</span>
                            @elseif( $item->status == 'FINALIZED' )
                                <span class="badge rounded-pill bg-label-success">Finalizado</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
    @endif 