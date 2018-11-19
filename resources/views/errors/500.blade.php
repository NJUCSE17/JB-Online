@extends('frontend.layouts.app')

@section('title', app_name())
@section('appClass', 'app-center')

@section('content')
    <div class="row justify-content-center align-items-center">
        <div class="col">
            <div class="card px-5 py-5">
                <div class="page-header">
                    <h3 class="display-3">
                        500 😷 <br /> Internal Server Error
                    </h3>
                </div>
                <hr/>
                <h5 style="font-size: 120%;">The server encounters some internal error.</h5>
                <h5 style="font-size: 120%;">Details of the error are given below:</h5>
                <code class="mb-3">
                    {{ $exception->getMessage() }}
                </code>
                <h5 style="font-size: 120%;">Please contact admin and provide detailed information to him,
                    or you are welcomed to RTFSC and find out what is going wrong.</h5>
            </div>
        </div>
    </div>
@endsection