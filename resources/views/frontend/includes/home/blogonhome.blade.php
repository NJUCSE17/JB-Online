@if(app_blogonhome())
    <div class="card mb-3">
        <h5 class="card-header py-2 text-center">
            <i class="fab fa-vuejs mr-2"></i>
            {{ __('labels.frontend.home.class_blog') }}
        </h5>
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