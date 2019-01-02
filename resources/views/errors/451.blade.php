@extends('frontend.layouts.app')

@section('title', app_name())
@section('appClass', 'app-center')

@section('content')
    <div class="row justify-content-center align-items-center">
        <div class="col">
            <div class="card">
                <h4 class="card-header">
                    😷 451 Unavailable For Legal Reasons
                </h4>
                <div class="card-body">
                    <p>
                        本服务在您所在的国家/地区不可用。<br />
                        This service is not available in your country/region.
                    </p>
                    <p>
                        如您使用了代理软件，请设置本网站不使用代理，或是关闭代理后重新访问。<br />
                        If you are using proxies, you may turn them off and try again.
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