@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('navs.frontend.course'))
@section('navBrand', app_name() . ' | ' . __('navs.frontend.course'))

@section('content')
    {!! Breadcrumbs::render() !!}
    <div class="card">
        <h4 class="card-header">
            <i class="fas fa-book-open mr-2"></i>
            {{ __('labels.frontend.home.course') }}
            @auth
                @if(Auth::user()->isExecutive())
                    <span class="float-right d-flex">
                        <a class="text-sm-center text-dark" href="{{ route('admin.forum.course.index') }}">
                            <i class="fas fa-cog"></i>
                        </a>
                    </span>
                @endif
            @endauth
        </h4>
        <div class="card-body">
            @if ($courses->count())
                @foreach($courses as $course)
                    <div class="row">
                        <div class="col col-12 col-md-9">
                            @include('frontend.includes.course.button', [$course])
                        </div>
                        <div id="enrollBtnContainer-{{ $course->id }}"
                             class="col col-12 col-md-3 d-none d-md-block enrollBtnContainer">
                            @include('frontend.includes.course.enroll', [$course])
                        </div>
                    </div>
                @endforeach
                <div class="row mt-3 mb-0">
                    <div class="col">
                        <div class="float-left">
                            {{ __('strings.frontend.home.total.left') }}
                            {!! $courses->total() !!}
                            {{ __('strings.frontend.home.total.right') }}
                        </div>
                    </div>
                    <div class="col">
                        <div class="float-right">
                            {!! $courses->render() !!}
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col text-center">
                        {{ __('strings.frontend.home.no_course') }}
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@if($courses->count())
    @push('after-scripts')
        <script type="text/javascript" id="enrollBtnScript">
            $('.enrollBtnContainer').on('click', '.enrollBtn', function (e) {
                e.preventDefault();
                let api = this.dataset.api;
                let cid = this.dataset.cid;
                axios.post(api, {})
                    .then(function (response) {
                        $('#enrollBtnContainer-' + cid).html(response.data.button_html);
                    })
                    .catch(function (error) {
                        alertError(error);
                    });
            });
        </script>
    @endpush
@endif