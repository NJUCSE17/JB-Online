@extends('frontend.layouts.app')

@section('title', app_name())
@section('appClass', 'app-center')

@section('content')
    <div class="row justify-content-center align-items-center">
        <div class="col">
            <div class="card">
                <h4 class="card-header">
                    🤔 405 Method Not Allowed
                </h4>
                <div class="card-body">
                    <p>
                        您采用了被禁止的访问方式。<br />
                        A forbidden HTTP verb is detected.
                    </p>
                    <p>
                        注意：你不能直接访问登出(/logout)页面。<br/>
                        Note that you cannot visit /logout page directly.
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
                        如果您确定这是网站的bug，请联系管理员。<br/>
                        Contact with admin in case where you believe this is not your fault.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection