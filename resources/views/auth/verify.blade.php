@extends('layouts.auth')

@section('content')
    <div class="row row-grid justify-content-center justify-content-lg-between align-items-center">
        <div class="col-sm-8 col-lg-6 col-xl-6 order-lg-2">
            <div class="card shadow zindex-100 mb-0">
                <div class="card-body px-md-5 py-5">
                    <div class="mb-5">
                        <h6 class="h3">验证邮箱地址</h6>
                        <p class="text-muted mb-0">在进入系统前，您必须验证邮箱，并获得管理员许可。</p>
                    </div>
                    <span class="clearfix"></span>
                    @include('includes.messages')
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            一封新的验证邮件已经发送到了您的邮箱。
                        </div>
                    @endif

                    <p>
                        若想要验证邮箱地址，您需要点击已经发送到您的邮箱的邮件中的连接。
                        如果您没有收到邮件，
                        <a href="{{ route('verification.resend') }}">
                            点击这里
                        </a>
                        来重新发送一封。
                    </p>
                </div>
            </div>
        </div>
        <div class="col-lg-5 order-lg-1 d-none d-lg-block">
            {!! \App\Helpers\FrontPageQuotes::getQuote() !!}
        </div>
    </div>
@endsection
