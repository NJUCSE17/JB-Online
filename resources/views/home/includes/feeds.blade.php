<div id="latest-blog-feeds">
    <div id="assignments-control">
        <p class="h3">最新博客</p>
    </div>
    <hr />
    @foreach($feeds as $feed)
        <div class="card card-stats mb-3">
            <div class="card-body">
                <div class="row flex-column flex-md-row align-items-center">
                    <div class="col ml-md-n2 text-center text-md-left">
                        <a href="#" class="h6 text-sm text-muted mb-0">{{ $feed->user->name }}</a>
                        <a href="{{ route('blog.show', [$feed]) }}">
                            <p class="card-text text-dark mb-0">
                                {{ $feed->title }}
                            </p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>