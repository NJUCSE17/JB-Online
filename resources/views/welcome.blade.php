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
        <hr />
        <div class="d-none d-md-flex justify-content-center">
            <a class="text-dark text-underline--dashed mx-3"
               href="https://njucse17.github.io">
                <i class="fas fa-users-class mr-1"></i> 关于我们(NJUCSE17)
            </a>
            <a class="text-dark text-underline--dashed mx-3"
               href="https://github.com/NJUCSE17/JB-Online">
                <i class="fas fa-code mr-1"></i> 查看源代码
            </a>
            <a class="text-dark text-underline--dashed mx-3"
               href="/docs">
                <i class="fas fa-book mr-1"></i> 开发文档
            </a>
        </div>
        <div class="d-flex d-md-none justify-content-center">
            <a class="text-dark mx-3" title="关于我们(NJUCSE17)"
               href="https://njucse17.github.io" target="_blank">
                <i class="fas fa-users-class"></i>
            </a>
            <a class="text-dark mx-3" title="查看源代码"
               href="https://github.com/NJUCSE17/JB-Online" target="_blank">
                <i class="fas fa-code"></i>
            </a>
            <a class="text-dark mx-3" title="开发人员手册"
               href="/docs" target="_blank">
                <i class="fas fa-book"></i>
            </a>
        </div>
    </div>
@endsection
