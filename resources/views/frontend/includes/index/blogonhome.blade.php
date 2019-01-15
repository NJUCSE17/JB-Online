@if(app_blogonhome())
    <div class="card my-3">
        @if ($feeds->count())
            <div class="card-body p-0">
                <div class="list-group list-group-flush" id="assignments"
                     style="height: auto; overflow: auto;">
                    @foreach($feeds as $feed)
                        <a class="list-group-item list-group-item-action flex-column align-items-start px-3"
                           id="class-blog-posts" href="{{ $feed['permalink'] }}">
                            <div class="d-flex w-100 justify-content-between">
                                {{ $feed['title'] }}
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @else
            <div class="card-body">
                <div class="row">
                    <div class="col text-center">
                        {{ __('strings.frontend.home.no_blog') }}
                    </div>
                </div>
            </div>
        @endif
    </div>
@endif