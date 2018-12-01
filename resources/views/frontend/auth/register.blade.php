@extends('frontend.layouts.app')

@section('title', app_name() . ' | '.__('labels.frontend.auth.register_box_title'))
@section('appClass', 'app-center')

@section('content')
    <div class="row justify-content-center align-items-center">
        <div class="col col-sm-8 align-self-center">
            <div class="card">
                <div class="card-header py-3">
                    <strong>
                        <i class="fas fa-user-plus mr-2"></i>
                        {{ __('labels.frontend.auth.register_box_title') }}
                    </strong>
                </div><!--card-header-->

                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="text-center">
                                {!! $socialiteLinks !!}
                            </div>
                        </div><!--/ .col -->
                    </div><!-- / .row -->

                    {{ html()->form('POST', route('frontend.auth.register.post'))->open() }}
                    <div class="row mb-2">
                        <div class="col">
                            <div class="input-group input-group-seamless">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-id-card"></i></div>
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
                        <div class="col-12 col-md-6">
                            <div class="input-group input-group-seamless">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-user"></i></div>
                                </div>
                                {{ html()->text('first_name')
                                    ->class('form-control')
                                    ->placeholder(__('validation.attributes.frontend.first_name'))
                                    ->attribute('maxlength', 191)
                                    ->required() }}
                            </div><!--col-->
                        </div><!--row-->

                        <div class="col-12 col-md-6">
                            <div class="input-group input-group-seamless">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-users"></i></div>
                                </div>
                                {{ html()->text('last_name')
                                    ->class('form-control')
                                    ->placeholder(__('validation.attributes.frontend.last_name'))
                                    ->attribute('maxlength', 191) }}
                            </div><!--form-group-->
                        </div><!--col-->
                    </div><!--row-->

                    <div class="row mb-2">
                        <div class="col">
                            <div class="input-group input-group-seamless">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-envelope"></i></div>
                                </div>
                                {{ html()->email('email')
                                    ->class('form-control')
                                    ->placeholder(__('validation.attributes.frontend.email'))
                                    ->attribute('maxlength', 191)
                                    ->required() }}
                            </div><!--form-group-->
                        </div><!--col-->
                    </div><!--row-->

                    <div class="row mb-2">
                        <div class="col">
                            <div class="input-group input-group-seamless">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-rss"></i></div>
                                </div>
                                {{ html()->text('blog')
                                    ->class('form-control')
                                    ->placeholder(__('validation.attributes.frontend.blog'))
                                    ->attribute('maxlength', 191) }}
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

                    <div class="row mb-2">
                        <div class="col">
                            <div class="input-group input-group-seamless">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-redo"></i></div>
                                </div>
                                {{ html()->password('password_confirmation')
                                    ->class('form-control')
                                    ->placeholder(__('validation.attributes.frontend.password_confirmation'))
                                    ->required() }}
                            </div><!--form-group-->
                        </div><!--col-->
                    </div><!--row-->

                    @if (config('access.captcha.registration'))
                        <div class="row mb-2">
                            <div class="col">
                                {!! Captcha::display() !!}
                                {{ html()->hidden('captcha_status', 'true') }}
                            </div><!--col-->
                        </div><!--row-->
                    @endif

                    <div class="row">
                        <div class="col">
                            <div class="form-group mb-0 clearfix text-right">
                                {{ form_submit("<i class='fas fa-user-plus mr-2'></i>"
                                    . __('labels.frontend.auth.register_button')) }}
                            </div><!--form-group-->
                        </div><!--col-->
                    </div><!--row-->
                    {{ html()->form()->close() }}
                </div><!-- card-body -->
            </div><!-- card -->
        </div><!-- col-md-8 -->
    </div><!-- row -->
@endsection

@push('after-scripts')
    @if (config('access.captcha.registration'))
        {!! Captcha::script() !!}
    @endif
@endpush
