@extends('layouts.auth')

@section('content')
    <div class="card zindex-100 p-5 shadow hover-shadow-lg text-center">
        <h3 class="display-3">{{ env('APP_NAME') }}</h3>
        <p>南京大学计算机科学与技术系2017级拔尖班作业管理系统</p>
        <div>
            <a href="{{ route('login') }}" class="btn btn-neutral">
                <i class="fas fa-sign-in-alt mr-1"></i> 进入系统
            </a>
        </div>
        <hr/>
        <div>
            <a class="text-dark text-underline--dashed mx-3"
               href="https://njucse17.github.io">
                <i class="fas fa-users-class mr-1"></i> 关于我们(NJUCSE17)
            </a>
            <a class="text-dark text-underline--dashed mx-3 d-none d-md-inline"
               href="https://github.com/NJUCSE17/JB-Online">
                <i class="fas fa-code mr-1"></i> 查看源代码
            </a>
            <a class="text-dark text-underline--dashed mx-3 d-none d-md-inline"
               href="/docs">
                <i class="fas fa-book mr-1"></i> 开发人员手册
            </a>
        </div>
    </div>
@endsection
