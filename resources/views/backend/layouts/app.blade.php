<!DOCTYPE html>
@langrtl
    <html lang="{{ app()->getLocale() }}" dir="rtl">
@else
    <html lang="{{ app()->getLocale() }}">
@endlangrtl
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', app_name())</title>
    <meta name="description" content="@yield('meta_description', 'Homework Forum Backend')">
    <meta name="author" content="@yield('meta_author', 'Anthony Rappa + doowzs')">

    <script type="text/x-mathjax-config">
            MathJax.Hub.Config({
                tex2jax: {
                    inlineMath: [['$','$'], ["\\(","\\)"]],
                        displayMath: [['$$', '$$'], ["\\[", "\\]"]],
                        processEscapes: true
                    },
                TeX: {
                    extensions: ["AMSmath.js", "AMSsymbols.js", "mhchem.js"],
                        equationNumbers: {autoNumber: "AMS",
                                          useLabelIds: true}
                }
            });
        </script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.5/latest.js?config=TeX-AMS-MML_SVG.js"></script>

    <script src="{{ URL::asset('js/tinymce/tinymce.min.js') }}"></script>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/default.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/highlight.min.js"></script>
    <script>
        hljs.initHighlightingOnLoad();
        tinymce.init({
            skin: 'light',
            selector:'textarea',
            file_browser_callback : elFinderBrowser,
            plugins: 'paste, textcolor, link, wordcount, codesample, code, image, lists, table, preview, autoresize',
            menubar: '',
            toolbar: 'styleselect | undo redo | forecolor backcolor | numlist bullist' +
                ' | outdent indent | pastetext link image codesample table | code preview',
            codesample_languages: [
                {text: 'C', value: 'c'},
                {text: 'C++', value: 'cpp'},
                {text: 'C#', value: 'csharp'},
                {text: 'CSS', value: 'css'},
                {text: 'HTML/XML', value: 'markup'},
                {text: 'Java', value: 'java'},
                {text: 'JavaScript', value: 'javascript'},
                {text: 'PHP', value: 'php'},
                {text: 'Python', value: 'python'},
                {text: 'Ruby', value: 'ruby'},
                {text: 'Shell', value: 'shell'},
                {text: 'SQL', value: 'sql'}
            ],
        });
        function elFinderBrowser (field_name, url, type, win) {
            tinymce.activeEditor.windowManager.open({
                file: '<?= route('elfinder.tinymce4') ?>',
                title: 'elFinder 2.0',
                lang: '{{ App::getLocale() }}',
                width: 900,
                height: 450,
                resizable: 'yes',
                commands : [
                    'custom', 'open', 'reload', 'home', 'up', 'back', 'forward', 'getfile', 'download',
                    'mkdir', 'mkfile', 'upload', 'archive', 'search', 'info', 'view', 'help', 'sort', 'netmount',
                    'copy', 'cut', 'paste', 'edit', 'extract', 'rm', 'duplicate', 'rename', 'resize'
                ],
                uiOptions : {
                    // toolbar configuration
                    toolbar : [
                        ['back', 'forward', 'up'],
                        ['mkdir', 'mkfile', 'upload'],
                        ['open', 'download', 'getfile', 'info'],
                        ['copy', 'cut', 'paste', 'rm'],
                        ['duplicate', 'rename', 'edit', 'resize'],
                        ['extract', 'archive'],
                        ['view', 'sort', 'help'],
                        ['search'],
                    ],
                    // directories tree options
                    tree : {
                        // expand current root on init
                        openRootOnLoad : true,
                        // auto load current dir parents
                        syncTree : true
                    },
                    // navbar options
                    navbar : {
                        minWidth : 150,
                        maxWidth : 500
                    },
                    // current working directory options
                    cwd : {
                        // display parent directory in listing as ".."
                        oldSchool : true,
                    }
                },
                contextmenu : {
                    // navbarfolder menu
                    navbar: ['open', '|', 'copy', 'cut', 'paste', 'duplicate', '|', 'rm', '|', 'info'],
                    // current directory menu
                    cwd: ['reload', 'back', '|', 'upload', 'mkdir', 'mkfile', 'paste', '|', 'info'],
                    // current directory file menu
                    files: [
                        'getfile', '|', 'open', 'download', '|', 'copy', 'cut', 'paste', 'duplicate', '|',
                        'rm', '|', 'edit', 'rename', 'resize', '|', 'archive', 'extract', '|', 'info'
                    ]
                },
            }, {
                setUrl: function (url) {
                    win.document.getElementById(field_name).value = url;
                }
            });
            return false;
        }
    </script>

    @yield('meta')

    {{-- See https://laravel.com/docs/5.5/blade#stacks for usage --}}
    @stack('before-styles')

    <!-- Check if the language is set to RTL, so apply the RTL layouts -->
    <!-- Otherwise apply the normal LTR layouts -->
    {{ style(mix('css/backend.css')) }}

    @stack('after-styles')
</head>

<body id="backend">
    <div id="app">
        @include('includes.partials.logged-in-as')
        @include('backend.includes.nav')
        @include('backend.includes.sidebar')
        <div id="app" class="@yield('appClass', '')">
            <div class="container-fluid my-4">
                @include('includes.partials.messages')
                @yield('content')
            </div><!-- container -->
        </div><!-- #app -->
    </div><!-- #app -->

    <!-- Scripts -->
    @stack('before-scripts')
    {!! script(mix('js/frontend.js')) !!}
    @stack('after-scripts')

    @include('includes.partials.ga')
</body>
</html>
