@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('navs.frontend.blog'))
@section('navBrand', app_name() . ' | ' . __('labels.frontend.home.class_blog'))

@section('content')
    <div class="row">
        <div class="col col-12 col-md-3">
            <div class="sticky-top" style="top: 20px; bottom: 20px;">
                <div class="card my-3">
                    <h4 class="card-header text-center">{{ __('labels.general.contents') }}</h4>
                    <div class="card-body p-3" style="max-height: 75vh;">
                        <nav id="toc" class="nav nav-pills flex-column" style="max-height: 70vh; overflow-y: auto;">
                            <div class="text-center">
                                <div id="toc-spinner" class="spinner-grow" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                        </nav>
                    </div>
                    <div class="card-footer py-2">
                        <div class="row">
                            <div class="col col-3 px-0 text-center">
                                <a class="btn {{ $feeds->currentPage() > 1 ? "text-primary" : ""}}"
                                   href="{{ $feeds->currentPage() > 1 ? $feeds->previousPageUrl() : "#"}}">
                                    <i class="fas fa-arrow-left"></i>
                                </a>
                            </div>
                            <div class="col col-6 px-0 text-center">
                                <div class="col text-center" style="width: 100%; overflow-x: auto;">
                                    <input type="number" class="form-control text-center mx-1 px-0" value=""
                                           id="customPage" data-total-page="{{ $feeds->lastPage() }}"
                                           style="width: 100%; height: 36px;" min="1" max="{{ $feeds->lastPage() }}"
                                           placeholder="{{ $feeds->currentPage() }} / {{ $feeds->lastPage() }}">
                                </div>
                            </div>
                            <div class="col col-3 px-0 text-center">
                                <a class="btn {{ $feeds->lastPage() > $feeds->currentPage() ? "text-primary" : ""}}"
                                   href="{{ $feeds->lastPage() > $feeds->currentPage() ? $feeds->nextPageUrl() : "#"}}">
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col col-12 col-md-9">
            <div id="feedContents">
                @if ($feeds->count())
                    @foreach ($feeds as $feed)
                        <div class="card my-3" id="{{ $feed['title'] }}">
                            <a class="card-header btn-outline-dark" style="font-size: 150%; line-height: 36px"
                               href="{{ $feed['permalink'] }}">
                                <img class="img-avatar mr-2" src="{{ $feed['avatar'] }}"
                                     style="height: 45px !important;">
                                {{ $feed['author'] }} - {{ $feed['title'] }}
                            </a>
                            <div class="card-body content" style="overflow: auto;">
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
        $(function () {
            Toc.init({
                $nav: $('#toc'),
                $scope: $('#feedContents'),
            });
            $('body').scrollspy({
                target: '#toc',
            });
        });

        let customPage = document.getElementById("customPage");
        let maxPage = "{{ $feeds->lastPage() }}";
        customPage.addEventListener("keyup", function(event) {
            event.preventDefault();
            if (event.keyCode === 13) {
                let pageNumber = customPage.value;
                if (pageNumber < 1 || pageNumber > parseInt(maxPage)) {
                    customPage.value = "1";
                } else {
                    document.location.href = ("{{ route('frontend.blog') }}" + '?page=' + pageNumber);
                }
            }
        });
        $('#toc-spinner').hide();
    </script>
@endpush