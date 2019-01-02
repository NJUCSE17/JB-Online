<div class="card my-3" id="copyright">
    <h3 class="card-header">版权声明</h3>
    <div class="card-body">
        <p class="text-center">
            {{ app_name() }}，当前版本{{ app_version() }}，
            基于<a href="https://github.com/doowzs/JB-Online" target="_blank">JB Online (GitHub)</a>。
            框架版本 {{ laravel_version() }}。
        </p>
        <p class="text-center">
            &copy; JB Online
            (2018 - {{ date('Y') }})，保留所有权利。
        </p>

        <p>使用的组件/脚本：</p>
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
                for JQuery based utils.
            </li>
            <li><a href="https://laravel.com/" target="_blank" rel="noopener">Laravel 5.6</a> as PHP framework.</li>
            <li><a href="http://laravel-boilerplate.com/" target="_blank" rel="noopener">Laravel Boilerplate</a> as code basement.</li>
            <li><a href="https://www.mathjax.org/" target="_blank" rel="noopener">MathJax</a> for TeX and LaTeX display.</li>
            <li><a href="https://www.tiny.cloud/" target="_blank" rel="noopener">TinyMCE 4</a> as WYSIWYG editor.</li>
            <li>All icons from <a href="https://www.flaticon.com/" target="_blank" rel="noopener">FlatIcon</a>.</li>
        </ul>
    </div>
    <div class="card-footer text-right">
        <i class="fas fa-clock mr-2"></i> 最后更新于：2019-01-02
    </div>
</div>