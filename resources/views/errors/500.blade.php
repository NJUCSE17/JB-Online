@extends('frontend.layouts.app')

@section('title', app_name())
@section('appClass', 'app-center')

@section('content')
    <div class="row justify-content-center align-items-center">
        <div class="col">
            <div class="card">
                <h4 class="card-header">
                    😷 500 Internal Server Error
                </h4>
                <div class="card-body">
                    <p>
                        服务器遭遇了一些内部故障。<br />
                        Server is currently malfunctioning.
                    </p>
                    <p>
                        通常情况下，将下面给出的提示反馈给管理员可以帮助他们找到原因。<br />
                        Reporting the following message can help admin find the cause of errors.
                    </p>
                    <p>
                        具体的错误信息如下：<br/>
                        Detailed error message is given below:
                    </p>
                    <p>
                        <code class="my-3">
                            @if($exception->getMessage())
                                {{ $exception->getMessage() }}
                            @else
                                Sorry, not available. (No message)
                            @endif
                        </code>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection