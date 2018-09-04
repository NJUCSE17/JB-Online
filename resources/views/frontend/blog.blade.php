@extends('frontend.layouts.app')

@section('title', app_name() . ' | '.__('navs.frontend.blog'))

@section('content')
    <div class="page-header">
        <h1 class="display-3">
            {{ __('labels.frontend.home.class_blog') }}
        </h1>
    </div>
    <div class="row">
        <div class="col">
            @if($feeds->lastPage() > 1)
                <span class="d-inline-flex" style="line-height: 35px">
                    Goto:
                    <input type="number" class="form-control text-center mx-1 px-0" value="{{ $feeds->currentPage() }}"
                           id="customPage1" data-total-page="{{ $feeds->lastPage() }}" style="width: 50px; height: 35px;"
                           min="1" max="{{ $feeds->lastPage() }}">
                    / {{ $feeds->lastPage() }}
                </span>
                <span class="float-right">
                    {!! $feeds->render() !!}
                </span>
            @endif
            @if ($feeds->count())
                @foreach ($feeds as $feed)
                    <div class="card my-3" id="feedItem">
                        <a class="card-header py-3 btn-outline-dark" style="font-size: 150%; line-height: 36px"
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
                @if($feeds->lastPage() > 1)
                    <span class="d-inline-flex" style="line-height: 35px">
                        Goto:
                        <input type="number" class="form-control text-center mx-1 px-0" value="{{ $feeds->currentPage() }}"
                               id="customPage2" data-total-page="{{ $feeds->lastPage() }}" style="width: 50px; height: 35px;"
                               min="1" max="{{ $feeds->lastPage() }}">
                        / {{ $feeds->lastPage() }}
                    </span>
                    <span class="float-right">
                        {!! $feeds->render() !!}
                    </span>
                @endif
            @else
                <h3 class="display-4 my-3">
                    {{ __('strings.frontend.home.no_blog') }}
                </h3>
            @endif
        </div>
    </div>

@endsection

@push('after-scripts')
    <script type="text/javascript">
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