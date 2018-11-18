@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('navs.frontend.about'))
@section('navBrand', app_name() . ' | ' . __('navs.frontend.about'))

@section('content')
    <div class="card px-3 py-3">
        <h1 class="text-center">
            <img src="{{ asset('favicon.ico') }}" style="height: 50px;">
            {{ app_name() }}
            <small>{{ app_version() }}</small>
        </h1>
        <i class="text-center">A hidden(?) place for we students.</i>
        <hr />

        <h2>Introduction</h2>
        <p>
            {{ app_name() }} (originally called JBEX) was designed for us NJU students to share knowledge on
            University Physics and relieve pain from learning physics, but it grew up into a complete forum.
            <s>(Believe it or not, that is BS.)</s>
        </p>
        <p>
            All forum users shall obey the following <s>old-school BS</s> rules:
        </p>
        <ol>
            <li>Never copy answers to assignments from other students.</li>
            <li>Never share answers directly in some strict courses.</li>
            <li>Never upload files that is illegal or <b>attack the server.</b></li>
        </ol>

        <hr />
        <h2>How to Use</h2>
        <p>
            {{ app_name() }} uses many great projects to enhance user experience. Below is a brief description
            of what you can utilize on {{ app_name() }}.
        </p>
        <ol>
            <li>
                We employed the latest version of <a href="https://www.mathjax.org/" target="_blank" rel="noopener">
                MathJax</a> to display beautiful LaTeX contents. You can write fluently just as you do when doing
                Problem Solving assignments. As an example, \$ ... \$ will transform into inline-math like
                $y = x^2$, and \$\$ ... \$\$ would transform into display-math like $$ S = \sum\limits_{i=1}^{n} i $$.
                If you want to insert the dollar sign, just type '\\\$'. Please note that the current preamble
                config on this server is
                <pre id="preamble" class="border ml-3 mr-4 my-3"><code>@include('includes.preamble')</code></pre>
            </li>
            <li>
                <a href="https://highlightjs.org/" target="_blank" rel="noopener">Highlight.JS</a> makes codes
                pretty to look at. <pre class="language-cpp border ml-3 mr-4 my-3"><code>#include
using namespace std;
int main() {
  cout &lt;&lt; "Hello, World!";
  return 0;
}</code></pre>
                To insert a code, just click 'insert code' in  editor, and select your language, paste and
                click 'OK'.
            </li>
            <li class="mt-3">
                The server would check assignments at 22:30 every day. If there is homework due tonight or next
                day, you will get an e-mail notification (as long as the server is alive). If you feel it is
                annoying, you can stop getting notified in your account info page. However, by turning off the
                notification, <b>you will no longer be notified if someone replies your post</b>.
            </li>
        </ol>

        <hr />
        <h2>Contact <s>Us</s> Me</h2>
        <p style="font-size: 140%">If you find a vulnerability, or have any ideas about how to improve this site,
            please open an issue at
            <a href="https://github.com/doowzs/Class-Forum" target="_blank" rel="noopener">
                the GitHub page
            </a>
            of this project.
        </p>

        <hr />
        <h2>License and Credit</h2>
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
@endsection
