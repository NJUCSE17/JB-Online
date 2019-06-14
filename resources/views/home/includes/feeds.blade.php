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
                        <a href="{{ route('user', $feed->user->student_id) }}"
                           class="h6 text-sm text-muted mb-0">
                            {{ $feed->user->name }}
                            @ <span>{{ $feed->published_at }}</span>
                        </a>
                        <a href="{{ route('blog.show', [$feed]) }}">
                            <p class="card-text text-dark mt-3">
                                {{ $feed->title }}
                            </p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>