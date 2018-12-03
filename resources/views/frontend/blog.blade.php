@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('navs.frontend.blog'))
@section('navBrand', app_name() . ' | ' . __('labels.frontend.home.class_blog'))

@section('content')
    <div class="row">
        <div class="col">
            <div id="feedContents">
            @if($feeds->lastPage() > 1)
                <div class="row mt-3">
                    <div class="col d-inline-flex" style="width: 100%; overflow-x: auto;">
                        <input type="number" class="form-control text-center mx-1 px-0" value=""
                               id="customPage1" data-total-page="{{ $feeds->lastPage() }}" style="width: 80px; height: 35px;"
                               min="1" max="{{ $feeds->lastPage() }}" placeholder="goto">
                        {!! $feeds->render() !!}
                    </div>
                </div>
            @endif
            @if ($feeds->count())
                <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top with-shadows" id="scrollspy">
                    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
                            data-target="#scrollspyContent" aria-controls="scrollspyContent" aria-expanded="false"
                            aria-label="{{ __('labels.general.toggle_navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-center" id="scrollspyContent">
                        <ul class="nav nav-pills">
                            <li><a class="nav-link" href="{{ $feeds->previousPageUrl() }}"><i class="fas fa-arrow-left"></i></a></li>
                            @foreach($feeds as $feed)
                                <li>
                                    <a class="nav-link" href="#{{ $feed['title'] }}">
                                            {{ $feed['author'] }} : {{ $feed['title'] }}
                                    </a>
                                </li>
                            @endforeach
                            <li><a class="nav-link" href="{{ $feeds->nextPageUrl() }}"><i class="fas fa-arrow-right"></i></a></li>
                        </ul>
                    </div>
                </nav>
                @foreach ($feeds as $feed)
                    <div class="card my-3" id="{{ $feed['title'] }}" >
                        <a class="card-header btn-outline-dark" style="font-size: 150%; line-height: 36px"
                           href="{{ $feed['permalink'] }}">
                            {{ $feed['title'] }}
                            <span class="float-right">
                                <img class="img-avatar mr-2" src="{{ $feed['avatar'] }}"
                                     style="height: 45px !important;">
                                {{ $feed['author'] }}
                            </span>
                        </a>
                        <div class="card-body" style="overflow: auto;">
                            {!! $feed['content'] !!}
                            <div class="text-right">
                                <small class="mb-0 text-muted">
                                    {{ __('labels.general.published') }}
                                    {{ $feed['date'] }}
                                    ({{ $feed['date']->diffForHumans() }})
                                </small>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <h3 class="display-4 my-3">
                    {{ __('strings.frontend.home.no_blog') }}
                </h3>
            @endif
            </div>
        </div>
    </div>
@endsection

@push('after-scripts')
    <script type="text/javascript">
        let offsetHeight = document.getElementById("navbar").offsetHeight;
        $('body').scrollspy({
            target: '#scrollspy',
            offset: offsetHeight,
        });

        let customPage1 = document.getElementById("customPage1");
        let customPage2 = document.getElementById("customPage2");
        let maxPage = "{{ $feeds->lastPage() }}";
        customPage1.addEventListener("keyup", function(event) {
            event.preventDefault();
            if (event.keyCode === 13) {
                let pageNumber = customPage1.value;
                if (pageNumber < 1 || pageNumber > parseInt(maxPage)) {
                    customPage1.value = "1";
                } else {
                    document.location.href = ("{{ route('frontend.blog') }}" + '?page=' + pageNumber);
                }
            }
        });
        customPage2.addEventListener("keyup", function(event) {
            event.preventDefault();
            if (event.keyCode === 13) {
                let pageNumber = customPage2.value;
                if (pageNumber < 1 || pageNumber > parseInt(maxPage)) {
                    customPage2.value = "1";
                } else {
                    document.location.href = ("{{ route('frontend.blog') }}" + '?page=' + pageNumber);
                }
            }
        });
    </script>
@endpush