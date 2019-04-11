<div class="card mb-3 hover-shadow-lg">
    <div class="card-body py-3">
        <div class="row flex-column flex-md-row align-items-center">
            <div class="col-auto">
                <a href="#" class="avatar rounded-circle">
                    <img alt="Image placeholder" src="{{ $feed->user->getAvatarURL() }}" class="">
                </a>
            </div>
            <div class="col ml-md-n2 text-center text-md-left">
                <a href="#" class="h6 text-sm mb-0">{{ $feed->user->name }}</a>
                <p class="card-text text-muted mb-0">
                    {{ $feed->title }}
                </p>
            </div>
            <hr class="divider divider-fade my-3 d-md-none">
            <div class="col-12 col-md-auto d-flex justify-content-between align-items-center">
                <a href="{{ route('blog.show', [$feed]) }}" class="btn btn-sm btn-secondary w-100">阅读</a>
            </div>
        </div>
    </div>
</div>