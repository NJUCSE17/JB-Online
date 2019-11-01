@extends('layouts.app')
@section('header-class', 'bg-warning-dark')

@section('header-left')
    <span class="h2 mb-0 text-white d-block">
        用户列表
    </span>
@endsection

@section('header-right')
    <span class="text-white" style="font-size: 110%;">
        用户总数 {{ $users->total() }} 人
    </span>
@endsection

@section('content')
    @foreach($users as $user)
        <div class="card">
            <div class="card-body">
                <div class="row flex-column flex-md-row align-items-center">
                    <div class="col-auto">
                        <a href="{{ route('user.show', $user) }}"
                           class="avatar rounded-circle">
                            <img alt="Image placeholder" src="{{ $user->getAvatarURL() }}" class="">
                        </a>
                    </div>
                    <div class="col ml-md-n2 text-center text-md-left">
                        <a href="{{ route('user.show', $user) }}"
                           class="h6 text-sm mb-0">
                            {{ $user->student_id }} ({{ $user->id }})
                        </a>
                        <p class="card-text text-muted mb-0">
                            {{ $user->name }}
                        </p>
                    </div>
                    <hr class="divider divider-fade my-3 d-md-none">
                    <div class="col-12 col-md-auto d-flex justify-content-between align-items-center">
                        <a href="{{ route('user.show', [$user]) }}" class="btn btn-sm btn-secondary w-100">查看</a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    {!! $users->render() !!}
@endsection
