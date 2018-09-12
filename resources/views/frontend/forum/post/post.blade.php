<div class="mx-0 my-0">
    <h5 class="py-0 align-middle" style="background-color: #fafafa">
        <img class="img-avatar mr-2" src="{{ $post->author->picture }}"
             style="height: 45px !important;">
        <span> {{$post->author->name}} (#{{ $post->id }}) </span>
        <span class="float-right">
            @if($post->user_id == $userid)
                <a class="btn btn-outline-primary text-dark" href="{{ route('frontend.forum.post.edit', [$course, $assignment, $post]) }}">
                    <i class="fas fa-edit mr-2"></i> {{ __('buttons.general.edit') }}
                </a>
            @else
                @if (Auth::user()->isExecutive())
                    <a class="btn btn-outline-danger text-dark" href="{{ route('frontend.forum.post.edit', [$course, $assignment, $post]) }}">
                        <i class="fas fa-edit mr-2"></i> {{ __('buttons.general.edit') }}
                    </a>
                @endif
            @endif
            <a class="btn btn-outline-success" onclick="triggerCreateModal({{ $post->id }})">
                <i class="fas fa-reply mr-2"></i> {{ __('buttons.general.new_reply') }}
            </a>
        </span>
    </h5>
    <div class="px-0 py-0 border-left">
        <div class="row mx-0 my-0">
            <div class="col pl-3 pr-0 pt-3 pb-0">
                <h5>{!! $post->content !!}</h5>
                <small class="float-right text-muted
                              <?php if(isset($posts[$post->id])) echo "pb-3"; ?>">
                    {{ $post->time_label }}
                </small>
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
@if($post->parent_id == 0)
    <hr />
@endif
