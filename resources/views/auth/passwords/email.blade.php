@extends('layouts.auth')

@section('content')
    <div class="row row-grid justify-content-center justify-content-lg-between align-items-center">
        <div class="col-sm-8 col-lg-6 col-xl-5 order-lg-2">
            <div class="card shadow zindex-100 mb-0">
                <div class="card-body px-md-5 py-5">
                    <div class="mb-5">
                        <h6 class="h3">重置密码</h6>
                        <p class="text-muted mb-0">输入邮箱地址来重置您在{{ env('APP_NAME') }}的账户密码。</p>
                    </div>
                    <span class="clearfix"></span>
                    @include('includes.messages')
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="form-group">
                            <label class="form-control-label">邮箱地址</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                </div>
                                <input id="email" name="email" type="email" value="{{ old('email') }}"
                                       class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                       placeholder="alice@nju.edu.cn" required autofocus>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-sm btn-primary btn-icon w-100">
                                <span class="btn-inner--icon"><i class="fas fa-check-square"></i></span>
                                <span class="btn-inner--text">提交</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-5 order-lg-1 d-none d-lg-block">
            {!! \App\Helpers\FrontPageQuotes::getQuote() !!}
        </div>
    </div>
@endsection
