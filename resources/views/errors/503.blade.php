@extends('frontend.layouts.app')

@section('title', app_name())
@section('appClass', 'app-center')

@section('content')
    <div class="row justify-content-center align-items-center">
        <div class="col">
            <div class="card">
                <h4 class="card-header">
                    😴 503 Service Unavailable
                </h4>
                <div class="card-body">
                    <p>
                        您所访问的服务暂时不可用。<br />
                        The service is shortly unavailable.
                    </p>
                    <p>
                        通常情况下，这个错误可能是为了维护而手动设置，并非意外引发的。<br />
                        The 503 error is often triggered manually instead of a server malfunction.
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