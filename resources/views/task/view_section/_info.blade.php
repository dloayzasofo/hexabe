<div class="card mt-4">
    <div class="card-body">
        <div class="mb-2"><small>DUEÑO DEL PROYECTO</small></div>
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex justify-content-start align-items-center user-name">
                <div class="avatar-wrapper">
                    <div class="avatar avatar-md me-3">
                        @if( $task->user->image != null )
                            <img src="{{ $task->user->image }}" alt="Avatar" class="rounded-2">
                        @else 
                            <span class="avatar-initial rounded-circle bg-label-danger">{{ $task->user->nameInitial }}</span>
                        @endif
                    </div>
                </div>
                <div class="d-flex flex-column">
                    <a href="{{ route('task.user.list', [$task->user]) }}" class="text-heading text-truncate">
                        <span class="fw-medium">{{ $task->user->name }}</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="mb-2 mt-4"><small>RESPONSABLE</small></div>
        <div class="d-flex justify-content-between align-items-center hoverEdit">
            <div class="d-flex justify-content-start align-items-center user-name">
                <div class="avatar-wrapper">
                    <div id="assignImage" class="avatar avatar-md me-3">
                        @if( $task->assign->image != null )
                            <img src="{{ $task->assign->image }}" alt="Avatar" class="rounded-2">
                        @else 
                            <span class="avatar-initial rounded-circle bg-label-danger">{{ $task->assign->nameInitial }}</span>
                        @endif
                    </div>
                </div>
                <div class="d-flex flex-column">
                    <a id="assignUrl" href="{{ route('task.user.list', [$task->assign]) }}" class="text-heading text-truncate">
                        <span id="assignName" class="fw-medium">{{ $task->assign->name }}</span>
                    </a>
                </div>
            </div>
            <div>
                <button id="btnEditAssign" class="btn rounded-pill btn-icon btn-outline-secondary me-2 btnTaskEdit" data-bs-toggle="modal" data-bs-target="#userModal">
                    <i class="bx bx-pencil"></i> 
                </button>
            </div>
        </div>

        <div class="mb-2 mt-4"><small>FECHA LÍMITE</small></div>
        <div class="d-flex justify-content-between hoverEdit">
            <div class="d-flex align-items-center">
                <div class="me-2">
                    <i class="bx bx-calendar"></i>
                </div>
                <div id="modelDate">
                    {{ Carbon\Carbon::parse($task->date_delivery)->format('d/m/Y') }}
                </div>
            </div>
            <div>
                <button id="btnEditDate" class="btn rounded-pill btn-icon btn-outline-secondary me-2 btnTaskEdit" data-bs-toggle="modal" data-bs-target="#dateModal"> 
                    <i class="bx bx-pencil"></i> 
                </button>
            </div>
        </div>
    </div>
</div>