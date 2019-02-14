@extends('frontend.layouts.app')

@section('title', app_name() . ' | OAuth')
@section('appClass', 'app-center')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card card-default">
                <div class="card-header">
                    鉴权请求 / Authorization Request
                </div>
                <div class="card-body">
                    <!-- Introduction -->
                    <p>
                        第三方客户端 <strong>{{ $client->name }}</strong> 请求访问您的用户的权限。<br/>
                        3rd party client <strong>{{ $client->name }}</strong> is requesting permission to access your account.
                    </p>

                    <!-- Scope List -->
                    @if (count($scopes) > 0)
                        <div class="scopes">
                            <p><strong>此应用将可以：<br/>This application will be able to:</strong></p>

                            <ul>
                                @foreach ($scopes as $scope)
                                    <li>{{ $scope->description }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col col-12 col-md-6">
                            <!-- Authorize Button -->
                            <form method="post" action="{{ url('/oauth/authorize') }}">
                                {{ csrf_field() }}

                                <input type="hidden" name="state" value="{{ $request->state }}">
                                <input type="hidden" name="client_id" value="{{ $client->id }}">
                                <button type="submit" class="btn btn-success" style="width: 100%;">授权 / Authorize</button>
                            </form>
                        </div>

                        <div class="col col-12 col-md-6">
                            <!-- Cancel Button -->
                            <form method="post" action="{{ url('/oauth/authorize') }}">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}

                                <input type="hidden" name="state" value="{{ $request->state }}">
                                <input type="hidden" name="client_id" value="{{ $client->id }}">
                                <button class="btn btn-danger" style="width: 100%;">取消 / Cancel</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection