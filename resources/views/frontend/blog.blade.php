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
            @if ($feeds)
                @foreach ($feeds as $feed)
                    <div class="card my-3" id="feedItem" style="max-height: 60vh; width: 100%; overflow:auto;">
                        <a class="card-header py-3 btn-outline-dark" style="font-size: 120%; line-height: 36px"
                           href="{{ $feed['permalink'] }}">
                            {{ $feed['title'] }}
                            <span class="float-right">
                                <img class="img-avatar mr-2" src="{{ $feed['avatar'] }}"
                                     style="height: 45px !important;">
                                {{ $feed['author'] }}
                            </span>
                        </a>
                        <div class="card-body" style="max-height: 60vh; overflow: auto;">
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
                <div class="row jumbotron">
                    <div class="col text-center">
                        <h3 class="display-4">
                            {{ __('strings.frontend.home.no_blog') }}
                        </h3>
                    </div>
                </div>
            @endif
        </div>
    </div>

@endsection