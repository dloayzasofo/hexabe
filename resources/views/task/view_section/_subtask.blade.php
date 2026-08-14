@if( count($childs) > 0 )
<div class="mt-3">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <div>
                    <h5 class="fw-bold">Subtareas</h5>
                </div>
                <div>
                    {{ $task->progress }}% Completado
                </div>
            </div>
            <div class="mt-2">
                <div class="progress" style="height: 16px;">
                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ $task->progress }}%;" aria-valuenow="{{ $task->progress }}" aria-valuemin="0" aria-valuemax="100">
                        {{ $task->progress }}%
                    </div>
                </div>
            </div>
            
            <div>
                @foreach ($childs as $child)
                @if( isset($child->assign) == false ) @continue @endif
                <div class="d-flex align-items-center border-primary py-1 px-2 border rounded mt-2" style="border-color:#F1F5F9 !important;">
                    <div class="me-3">
                        @if( $child->status != 'FINALIZED' )
                        <button id="taskStatus-{{ $child->id }}" type="button" 
                            data-bs-toggle="tooltip" 
                            data-href="{{ $child->id }}" 
                            data-message="<mark>Finalizar</mark> la tarea <b>{{$child->title}}</b>."
                            class="openModalMessage"
                            data-bs-offset="0,6" 
                            data-bs-placement="top" 
                            data-bs-html="true" 
                            data-bs-original-title="Finalizar subtarea" 
                            style="background:transparent;border:0px;">
                            <i class="icon-base bx bx-circle" style="font-size:25px;"></i>
                        </button>
                        @else
                        <span id="taskStatus-{{ $child->id }}" class="timeline-indicator-advanced timeline-indicator-success border-0 shadow-none" style="color:#22C55E;">
                            <i class="icon-base bx bx-check-circle" style="font-size:25px;"></i>
                        </span>
                        @endif
                    </div>
                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                        <div class="me-3">
                            <div>
                                <a href="{{ route('task.view', $child->id) }}" class="mb-0 text-heading" 
                                    @if( $child->status == 'FINALIZED' ) style="text-decoration: line-through;" @endif>
                                    {{ $child->title }} <br>
                                </a>
                                <small class="mt-auto mb-1 text-heading"> {{ $child->register_at }} </small>
                            </div>
                        </div>
                        <div class="user-progress">
                            <div class="d-flex justify-content-center">
                                <button data-href="{{ route('task.view', [$child]) }}" 
                                    data-bs-toggle="tooltip"
                                    class="btn btn-icon delete-record text-primary btnCopyLink"
                                    data-bs-placement="top" 
                                    data-task="{{ $child->title }}"
                                    aria-label="Copiar enlace"
                                    data-bs-original-title="Copiar enlace">
                                    <i class="icon-base bx bx-link icon-md"></i>
                                </button>
                                
                                <div class="avatar avatar-sm">
                                    <div data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar pull-up" aria-label="{{ $child->assign->name }}" data-bs-original-title="{{ $child->assign->name }}">
                                        @if( $child->assign->image != null )
                                            <img src="{{ $child->assign->image }}" class="avatar rounded-circle">
                                        @else
                                            <span class="avatar-initial rounded-circle bg-label-danger">{{ $child->assign->nameInitial }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div> 
@endif