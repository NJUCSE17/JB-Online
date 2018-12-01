@extends('frontend.layouts.app')

@section('title', app_name() . ' | '.__('labels.frontend.auth.login_box_title'))
@section('appClass', 'app-center')

@section('content')
    <div class="row justify-content-center align-items-center">
        <div class="col col-sm-8 align-self-center">
            <div class="card">
                <div class="card-header">
                    <strong>
                        <i class='fas fa-sign-in-alt mr-2'></i>
                        {{ __('labels.frontend.auth.login_box_title') }}
                    </strong>
                </div><!--card-header-->

                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="text-center">
                                {!! $socialiteLinks !!}
                            </div>
                        </div><!--col-->
                    </div><!--row-->

                    <div class="row mb-3">
                        <div class="col">
                            <div class="text-center">
                                {{ __('auth.use_credential') }}
                            </div>
                        </div><!--col-->
                    </div><!--row-->

                    {{ html()->form('POST', route('frontend.auth.login.post'))->open() }}
                        <div class="row mb-2">
                            <div class="col">
                                <div class="input-group input-group-seamless">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-user"></i></div>
                                    </div>
                                    {{ html()->text('student_id')
                                        ->class('form-control')
                                        ->placeholder(__('validation.attributes.frontend.student_id'))
                                        ->attribute('maxlength', 191)
                                        ->required() }}
                                </div><!--form-group-->
                            </div><!--col-->
                        </div><!--row-->

                        <div class="row mb-2">
                            <div class="col">
                                <div class="input-group input-group-seamless">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-key"></i></div>
                                    </div>
                                    {{ html()->password('password')
                                        ->class('form-control')
                                        ->placeholder(__('validation.attributes.frontend.password'))
                                        ->required() }}
                                </div><!--form-group-->
                            </div><!--col-->
                        </div><!--row-->

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox d-block align-middle">
                                        <input type="checkbox" class="custom-control-input" name="remember" id="remember" value="1">
                                        <label class="custom-control-label" for="remember">{{ __('labels.frontend.auth.remember_me') }}</label>
                                    </div>
                                </div><!--form-group-->
                            </div><!--col-->
                            <div class="col">
                                <div class="form-group clearfix text-right">
                                    {{ form_submit("<i class='fas fa-sign-in-alt mr-2'></i>".__('labels.frontend.auth.login_button')) }}
                                </div><!--form-group-->
                            </div><!--col-->
                        </div><!--row-->

                        <div class="row">
                            <div class="col">
                                <div class="form-group text-right">
                                    <a href="{{ route('frontend.auth.password.reset') }}">{{ __('labels.frontend.passwords.forgot_password') }}</a>
                                </div><!--form-group-->
                            </div><!--col-->
                        </div><!--row-->
                    {{ html()->form()->close() }}
                </div><!--card body-->
            </div><!--card-->
        </div><!-- col-md-8 -->
    </div><!-- row -->
@endsection
