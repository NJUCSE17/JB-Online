<div class="mx-0 my-3">
    <h5 class="py-0 align-middle" style="height: 100%; overflow-x: auto;">
        <img class="img-avatar mr-2" src="{{ $post->author->picture }}"
             style="height: 45px !important;">
        <span> {{$post->author->name}} </span>
        |
        <span class="voteBtnContainer" id="voteBtnContainer-post-{{ $post->id }}">
            {!!  $post->vote_buttons !!}
        </span>
        |
        <small class="text-muted">#{{ $post->id }}</small>
        <span class="float-right" style="line-height: 45px">
            @if($post->user_id == $userid)
                <a class="btn btn-sm btn-outline-primary text-dark" href="{{ route('frontend.forum.post.edit', [$course, $assignment, $post]) }}">
                    <i class="fas fa-edit mr-2"></i> {{ __('buttons.general.edit') }}
                </a>
            @else
                @if (Auth::user()->isExecutive())
                    <a class="btn btn-sm btn-outline-danger text-dark" href="{{ route('frontend.forum.post.edit', [$course, $assignment, $post]) }}">
                        <i class="fas fa-edit mr-2"></i> {{ __('buttons.general.edit') }}
                    </a>
                @endif
            @endif
            <a class="btn btn-sm btn-outline-success" onclick="triggerCreateModal({{ $post->id }})">
                <i class="fas fa-reply mr-2"></i> {{ __('buttons.general.new_reply') }}
            </a>
        </span>
    </h5>
    <div class="px-0 py-0 my-0 border-left">
        <div class="row mx-0 my-0">
            <div class="col pl-3 pr-0 py-0">
                <h5>{!! $post->content !!}</h5>
                <p class="float-right text-muted my-0">
                    {{ $post->time_label }}
                </p>
            </div>
        </div>
        <div class="row ml-0 mr-0">
            <div class="col pl-3 pr-0">
                @if(isset($posts[$post->id]))
                    @include('frontend.forum.post.list', ['group'=>$posts[$post->id]])
                @endif
            </div>
        </div>
    </div>
</div>
