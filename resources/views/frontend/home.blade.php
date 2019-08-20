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
                <div id="Weather">
                    <div id="WeatherControl">
                        <p class="h3">天气预报（半成品）</p>
                    </div>
                    <hr/>
                    <weather-main
                        :api_username="{{ json_encode(env('HEWEATHER_API_USERNAME')) }}"
                        :api_key="{{ json_encode(env('HEWEATHER_API_KEY')) }}"
                        :ip="{{ json_encode(geoip()->getClientIP()) }}"
                        :location="{{ json_encode(geoip()->getLocation()) }}"
                    ></weather-main>
                </div>
                <hr />
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
<script>
    import WeatherMain
    export default {
        components: {WeatherMain}
    }
</script>
