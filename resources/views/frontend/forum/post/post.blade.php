<div class="card mx-0 mb-3">
    <h5 class="card-header align-middle">
        <img class="img-avatar mr-2" src="{{ $post->author->picture }}"
             alt="{{ $post->author->name }}" style="height: 38px !important;">
        <span> {{$post->author->name}} </span>
        <span class="float-right">
            @if($post->user_id == $userid || Auth::user()->isExecutive())
                <a class="btn btn-outline-danger text-dark" href="{{ route('frontend.forum.post.edit', [$course, $assignment, $post]) }}">
                    <i class="fas fa-edit"></i> {{ __('buttons.general.edit') }}
                </a>
            @endif
            <a class="btn btn-outline-success" onclick="triggerCreateModal({{ $post->id }})">
                <i class="fas fa-reply"></i> {{ __('buttons.general.new_reply') }}
            </a>
        </span>
    </h5>
    <div class="card-body px-0 py-0">
        <div class="row mx-3 my-3">
            <div class="col">
                <h5>{!! $post->content !!}</h5>
                <small class="float-right text-muted">{{ $post->time_label }}</small>
            </div>
        </div>
        <div class="row ml-3 mr-0">
            <div class="col">
                @if(isset($posts[$post->id]))
                    @include('frontend.forum.post.list', ['group'=>$posts[$post->id]])
                @endif
            </div>
        </div>
    </div>
</div>
