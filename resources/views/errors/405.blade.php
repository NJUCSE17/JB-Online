@extends('frontend.layouts.app')

@section('title', app_name())
@section('appClass', 'app-center')

@section('content')
    <div class="row justify-content-center align-items-center">
        <div class="col">
            <div class="card px-5 py-5">
                <div class="page-header">
                    <h3 class="display-3">
                        405 🤔 <br /> Method Not Allowed
                    </h3>
                </div>
                <hr/>
                <h5 style="font-size: 120%;">A request method is not supported for the requested resource.</h5>
                <h5 style="font-size: 120%;">You were not trying to hack our server, were you?</h5>
                <h5 style="font-size: 120%;">Details of the error are given below:</h5>
                <code class="mb-3">
                    {{ $exception->getMessage() }}
                </code>
                <h5 style="font-size: 120%;">Anyway, we are sorry about the error.
                    If you believe the error is not caused by yourself, please contact admin or RTFSC.</h5>
            </div>
        </div>
    </div>
@endsection