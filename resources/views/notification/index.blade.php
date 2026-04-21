@extends('layout')

@section('main')
    <div class="row sm-vl-base mb-4">
        <div class="col-sm-8 col-md-6">
            <h4 class="fw-bold"> Notificaciones</h4>
            <p>Mantente al día con lo que pasa con tus equipos y tus tareas.</p>
        </div>
        <div class="col-sm-4 col-md-6"></div>
    </div>

    @if(Session::has('team.success'))
    <div class="alert alert-success alert-dismissible" role="alert">
        {{ Session::get('team.success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
        </button>
    </div>
    @endif

    <div class="row sm-vl-base">
        <div class="col-sm-12 col-md-12 fw-bold mb-3">
            HOY
        </div>
        <div class="col-sm-12 col-md-12 fw-bold">
            @if($notificationsToday->isEmpty() == false)
                @foreach($notificationsToday as $notification)
                    <div class="notifi-item card mb-1 @if( $notification->read_at == null ) notification-unread @endif" data-id="{{ $notification->id }}">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex">
                                    <div>
                                        @switch( $notification->type )
                                            @case('TASK')
                                                <img src="{{ asset('assets/img/noti-task.png') }}" alt="Task">
                                                @break
                                            @case('COMMENT')
                                                <img src="{{ asset('assets/img/noti-comment.png') }}" alt="Comment">
                                                @break
                                            @case('CRON')
                                                <img src="{{ asset('assets/img/noti-cron.png') }}" alt="Cron">
                                                @break
                                            @case('MENTION')
                                                <img src="{{ asset('assets/img/noti-mention.png') }}" alt="Mention">
                                                @break
                                        @endswitch
                                    </div>
                                    <div class="ms-3">
                                        <div class="fw-bold">
                                            @if( $notification->link != null)
                                                <a href="{{ $notification->link }}" class="text-decoration-none text-heading">
                                                    {{ $notification->title }} 
                                                </a>
                                            @else
                                                {{ $notification->title }}
                                            @endif
                                        </div>
                                        <div class="fw-light">{{ Str::limit($notification->message, 100) }}</div>
                                    </div>
                                </div>
                                <div>
                                    {{ $notification->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                No tienes notificaciones para hoy.
            @endif
        </div>

        @if($notificationsOld->isEmpty() == false)
        <div class="col-sm-12 col-md-12 fw-bold mb-3 mt-4">
            ANTERIORES
        </div>
        <div class="col-sm-12 col-md-12 fw-bold">
            @foreach($notificationsOld as $notification)
                <div class="notifi-item card mb-1 @if( $notification->read_at == null ) notification-unread @endif" data-id="{{ $notification->id }}">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex">
                                <div>
                                    @switch( $notification->type )
                                        @case('TASK')
                                            <img src="{{ asset('assets/img/noti-task.png') }}" alt="Task">
                                            @break
                                        @case('COMMENT')
                                            <img src="{{ asset('assets/img/noti-comment.png') }}" alt="Comment">
                                            @break
                                        @case('CRON')
                                            <img src="{{ asset('assets/img/noti-cron.png') }}" alt="Cron">
                                            @break
                                        @case('MENTION')
                                            <img src="{{ asset('assets/img/noti-mention.png') }}" alt="Mention">
                                            @break
                                    @endswitch
                                </div>
                                <div class="ms-3">
                                    <div class="fw-bold">
                                        @if( $notification->link != null)
                                            <a href="{{ $notification->link }}" class="text-decoration-none text-heading">
                                                {{ $notification->title }} 
                                            </a>
                                        @else
                                            {{ $notification->title }} 
                                        @endif
                                    </div>
                                    <div class="fw-light">{{ Str::limit($notification->message, 100) }}</div>
                                </div>
                            </div>
                            <div>
                                {{ $notification->created_at->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        @endif
    </div>
@endsection
@section('script')
<script>
    window.addEventListener('load', () => {
        let notifications = document.querySelectorAll('.notifi-item');
        let ids = [];
        for( let i=0; i < notifications.length; i++ ){
            let notification = notifications[i];
            if( notification.classList.contains('notification-unread') ) {
                ids.push(notification.dataset.id);
            }
        };

        if( ids.length > 0 ) {
            fetch("{{ route('notification.read') }}", {
                method: 'post',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    _token: '{{ csrf_token() }}',
                    ids: ids
                })
            }).then(response => response.json())
            .then(data => {
                console.log(data);
            });
        }
    });
</script>
@endsection