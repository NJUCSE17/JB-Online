@extends('frontend.layouts.app')

@section('title', app_name())
@section('appClass', 'app-center')

@section('content')
    <div class="row justify-content-center align-items-center">
        <div class="col">
            <div class="card">
                <h4 class="card-header">
                    😪 404 Not Found
                </h4>
                <div class="card-body">
                    <p>
                        您想要访问的页面不存在。<br/>
                        The page you are visiting does not exist.
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
                    <p>
                        请检查您的输入/地址并重试。<br/>
                        Check your input/address and try again.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection