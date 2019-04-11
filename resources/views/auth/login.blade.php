@extends('layouts.auth')

@section('content')
    <div class="row row-grid justify-content-center justify-content-lg-between align-items-center">
        <div class="col-sm-8 col-lg-6 col-xl-5 order-lg-2">
            <div class="card shadow zindex-100 mb-0">
                <div class="card-body px-md-5 py-5">
                    <div class="mb-5">
                        <h6 class="h3">登陆</h6>
                        <p class="text-muted mb-0">登陆您的{{ env('APP_NAME') }}账户来继续操作。</p>
                    </div>
                    <span class="clearfix"></span>
                    @include('includes.messages')
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group">
                            <label class="form-control-label">NJU ID</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                <input id="student_id" class="form-control" name="student_id"
                                       value="{{ old('student_id') }}" placeholder="170000001"
                                       required autofocus>
                            </div>
                        </div>
                        <div class="form-group mb-4">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <label class="form-control-label">密码</label>
                                </div>
                                <div class="mb-2">
                                    <a href="{{ route('password.request') }}"
                                       class="small text-muted text-underline--dashed border-primary">
                                        忘记密码
                                    </a>
                                </div>
                            </div>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                                </div>
                                <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                       id="password" type="password" name="password"
                                       placeholder="password" required>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col col-md-6">
                                <div class="custom-control custom-checkbox my-1">
                                    <input class="custom-control-input" type="checkbox" name="remember"
                                           id="remember">
                                    <label class="custom-control-label" for="remember">保持登陆</label>
                                </div>
                            </div>
                            <div class="col col-md-6 text-right">
                                <button type="submit" class="btn btn-sm btn-primary btn-icon rounded-pill">
                                    <span class="btn-inner--text">登陆</span>
                                    <span class="btn-inner--icon">
                                        <i class="fas fa-long-arrow-alt-right"></i>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                @if(Route::has('register'))
                    <div class="card-footer px-md-5">
                        <small>没有账户？</small>
                        <a href="{{ route('register') }}" class="small font-weight-bold">
                            注册账户
                        </a>
                    </div>
                @endif
            </div>
        </div>
        <div class="col-lg-5 order-lg-1 d-none d-lg-block">
            {!! \App\Helpers\FrontPageQuotes::getQuote() !!}
        </div>
    </div>
@endsection
