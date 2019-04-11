@extends('layouts.auth')

@section('content')
    <div class="row row-grid justify-content-center justify-content-lg-between align-items-center">
        <div class="col-sm-8 col-lg-6 col-xl-6 order-lg-2">
            <div class="card shadow zindex-100 mb-0">
                <div class="card-body px-md-5 py-5">
                    <div class="mb-5">
                        <h6 class="h3">获得使用许可</h6>
                        <p class="text-muted mb-0">在进入系统前，您必须验证邮箱，并获得管理员许可。</p>
                    </div>
                    <span class="clearfix"></span>
                    @include('includes.messages')

                    <p>
                        您还没有获得使用{{ env('APP_NAME') }}的许可，请与网站管理员联系。
                    </p>
                </div>
            </div>
        </div>
        <div class="col-lg-5 order-lg-1 d-none d-lg-block">
            {!! \App\Helpers\FrontPageQuotes::getQuote() !!}
        </div>
    </div>
@endsection
