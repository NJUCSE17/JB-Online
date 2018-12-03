@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('navs.frontend.about'))
@section('navBrand', app_name() . ' | ' . __('navs.frontend.about'))
@section('appClass', 'app-center')

@section('content')
    <div class="card">
        <h1 class="card-header text-center">
            <img src="{{ asset('favicon.ico') }}" style="height: 50px;">
            {{ app_name() }}
        </h1>
        <div class="card-body">
            <h3>Email</h3>
            <p>
                服务器每日邮件发送时间：22:30 (Asia/Shanghai)。<br/>
                Server sends daily emails at 22:30 CST (Asia/Shanghai).
            </p>

            <h3>MathJax</h3>
            <p>当前已定义宏指令：<br/>
            Currently defined TeX macros:</p>
            <pre id="preamble" class="border ml-3 mr-4 my-3"><code>@include('includes.preamble')</code></pre>

            <h3>Version</h3>
            <p>
                {{ app_name() }}，当前版本{{ app_version() }}，
                基于<a href="https://github.com/doowzs/Class-Forum" target="_blank">Class-Forum</a>
                Ver. Amber (1.60, 2018-12-03)。
                使用Laravel {{ laravel_version() }}。
            <p>

            <h3>Credit</h3>
            <ul>
                <li><a href="http://getbootstrap.com/" target="_blank" rel="noopener">Bootstrap 4</a> as layout framework.</li>
                <li>
                    <a href="https://carbon.nesbot.com/" target="_blank" rel="noopener">Carbon 2</a>
                    and
                    <a href="https://github.com/kylekatarnls/laravel-carbon-2" target="_blank" rel="noopener">laravel-carbon-2</a>
                    for time localization and display.
                </li>
                <li>
                    <a href="https://github.com/Studio-42/elFinder" target="_blank" rel="noopener">Elfinder</a>
                    and
                    <a href="https://github.com/barryvdh/laravel-elfinder" target="_blank" rel="noopener">laravel-elfinder</a>
                    for file storage.
                </li>
                <li><a href="http://glide.thephpleague.com/" target="_blank" rel="noopener">Glide</a> for image processing.</li>
                <li><a href="https://highlightjs.org/" target="_blank" rel="noopener">Highlight.JS</a> for code formatting.</li>
                <li>
                    <a href="http://jquery.com/" target="_blank" rel="noopener">jQuery</a>,
                    <a href="https://jqueryui.com/" target="_blank" rel="noopener">jQuery UI</a> and
                    <a href="https://github.com/craftpip/jquery-confirm" target="_blank" rel="noopener">jQuery-Confirm v3</a>
                    for JS based utils.
                </li>
                <li><a href="https://laravel.com/" target="_blank" rel="noopener">Laravel 5.6</a> as PHP framework.</li>
                <li><a href="http://laravel-boilerplate.com/" target="_blank" rel="noopener">Laravel Boilerplate</a> as code basement.</li>
                <li><a href="https://www.mathjax.org/" target="_blank" rel="noopener">MathJax</a> for TeX and LaTeX display.</li>
                <li><a href="https://www.tiny.cloud/" target="_blank" rel="noopener">TinyMCE 4</a> as WYSIWYG editor.</li>
                <li>All icons from <a href="https://www.flaticon.com/" target="_blank" rel="noopener">FlatIcon</a>.</li>
            </ul>
        </div>
    </div>
@endsection
