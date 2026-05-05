<div class="comment-wrapper">
    @foreach($comments as $comment)
        <div id="comment-{{ $comment->id }}" class="d-flex overflow-hidden mb-3">
            <div class="user-avatar flex-shrink-0 me-4">
                <div class="avatar avatar-md">
                    @if( $comment->user->image )
                        <img src="{{ $comment->user->image }}" alt="Avatar" class="rounded-circle">
                    @else
                        <span class="avatar-initial rounded-circle bg-label-danger">{{ $comment->user->nameInitial }}</span>
                    @endif
                </div>
            </div>
            <div class="chat-message-wrapper flex-grow-1">
                <div class="chat-message-text p-3" style="background:#fff;border-radius:0px 12px 12px 12px;">
                    <div class="d-flex justify-content-between mb-2">
                        <div class="fw-bold">
                            {{ $comment->user->name }}
                        </div>
                        <div>
                            {{ $comment->created_at->diffForHumans() }}
                        </div>
                    </div>
                    <p class="mb-0">
                        {{ $comment->description }}
                    </p>
                    <div class="d-flex mt-3 ">
                        @foreach( $comment->commentmedias as $commentmedia )
                        <a href="{{  $commentmedia->media->url }}" target="_blank" class="text-nowrap mb-0 me-2" download>
                            @if( str_contains($commentmedia->media->mime, 'image') )
                                <i class="icon-base bx bx-image align-bottom"></i>        
                            @else
                                <i class="icon-base bx bx-file align-bottom"></i>        
                            @endif
                                <small style="transform:translateY(2px);display:inline-block;">{{ $commentmedia->media->size_literal }}</small>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>