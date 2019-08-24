@extends('layouts.app')
@section('header-class', 'bg-primary-dark')

@section('header-left')
    <span class="h2 mb-0 text-white d-block">{{ \App\Helpers\UserGreetings::greet(Auth::user()) }}</span>
@endsection

@section('header-right')

@endsection

@section('content')
    <div class="row">
        <div class="col col-md-8 col-12">
            <assignment-list-main
                :timezone="{{ json_encode(Auth::user()->timezone) }}"
            ></assignment-list-main>
        </div>
        <div class="col col-md-4 col-12">
            @if(env('HEWEATHER_API_KEY'))
                <hr class="d-block d-md-none"/>
                <weather-main
                    :weather_data="{{ Auth::user()->weather }}"
                ></weather-main>
            @endif

            @if(($notice = env('APP_NOTICE')))
                <hr class="d-block d-md-none"/>
                <div id="Notice">
                    <div id="NoticeControl">
                        <p class="h3">系统通知</p>
                    </div>
                    <hr/>
                    {!! $notice !!}
                </div>
                <hr />
            @else
                <hr class="d-block d-md-none"/>
            @endif

            <blog-feed-list
                    :simple="true"
                    :limit="5"
            ></blog-feed-list>
        </div>
    </div>
@endsection
