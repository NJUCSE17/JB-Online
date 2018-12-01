<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/headroom/0.9.4/headroom.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/headroom/0.9.4/jQuery.headroom.min.js"></script>

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
<script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.5/latest.js?config=TeX-AMS-MML_SVG.js"></script>

<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/highlight.min.js"></script>
<script src="{{ URL::asset('js/tinymce/tinymce.min.js') }}"></script>
<script type="text/javascript">
    hljs.initHighlightingOnLoad();

    $("textarea").attr('placeholder', '{{ __('strings.frontend.general.textarea_placeholder') }}');
    tinymce.init({
        //skin: 'light',
        language: 'zh_CN',
        selector: 'textarea',
        file_browser_callback: elFinderBrowser,
        height: 200,
        plugins: 'placeholder hr advlist paste textcolor link wordcount codesample code codesample image imagetools tinymceEmoji lists table preview textpattern',
        menubar: '',
        branding: false,
        content_css: '/css/frontend.css',
        body_class: 'px-2 py-2',
        toolbar1:"styleselect fontsizeselect forecolor backcolor | bold italic underline strikethrough | alignleft aligncenter alignright | code",
        toolbar2:"bullist numlist outdent indent | subscript superscript blockquote hr | pastetext removeformat link unlink | image table codesample tinymceEmoji",
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
        textpattern_patterns: [
            {start: '*', end: '*', format: 'italic'},
            {start: '**', end: '**', format: 'bold'},
            {start: '``', end: '``', format: 'code'},
            {start: '#', format: 'h1'},
            {start: '##', format: 'h2'},
            {start: '###', format: 'h3'},
            {start: '####', format: 'h4'},
            {start: '#####', format: 'h5'},
            {start: '######', format: 'h6'},
            {start: '1. ', cmd: 'InsertOrderedList'},
            {start: '* ', cmd: 'InsertUnorderedList'},
            {start: '- ', cmd: 'InsertUnorderedList'}
        ],
        emoji_add_space: true,
        emoji_show_groups: true,
        emoji_show_subgroups: true,
        emoji_show_tab_icons: true
    });

    function elFinderBrowser(field_name, url, type, win) {
        tinymce.activeEditor.windowManager.open({
            file: '<?= route('elfinder.tinymce4') ?>',
            title: 'elFinder 2.0',
            lang: '{{ App::getLocale() }}',
            width: 900,
            height: 450,
            resizable: true,
            commands: [
                'custom', 'open', 'reload', 'home', 'up', 'back', 'forward', 'getfile', 'download',
                'mkdir', 'mkfile', 'upload', 'archive', 'search', 'info', 'view', 'help', 'sort', 'netmount',
                <?php if (Auth::hasUser() && Auth::user()->isExecutive()) echo "'copy', 'cut', 'paste',
                        'edit', 'extract', 'rm', 'duplicate', 'rename', 'resize'" ?>
            ],
            uiOptions: {
                // toolbar configuration
                toolbar: [
                    ['back', 'forward', 'up'],
                    ['mkdir', 'mkfile', 'upload'],
                    ['open', 'download', 'getfile', 'info'],
                        <?php if (Auth::hasUser() && Auth::user()->isExecutive())
                        echo "['copy', 'cut', 'paste', 'rm'],
                            ['duplicate', 'rename', 'edit', 'resize'],
                            ['extract', 'archive'],"
                        ?>
                    ['view', 'sort', 'help'],
                    ['search'],
                ],
                // directories tree options
                tree: {
                    // expand current root on init
                    openRootOnLoad: true,
                    // auto load current dir parents
                    syncTree: true
                },
                // navbar options
                navbar: {
                    minWidth: 150,
                    maxWidth: 500
                },
                // current working directory options
                cwd: {
                    // display parent directory in listing as ".."
                    oldSchool: true,
                }
            },
            contextmenu: {
                // navbarfolder menu
                navbar: ['open', '|',
                    <?php if (Auth::hasUser() && Auth::user()->isExecutive())
                        echo "'copy', 'cut', 'paste', 'duplicate', '|', 'rm', '|',"?>
                        'info'],
                // current directory menu
                cwd: ['reload', 'back', '|', 'upload', 'mkdir', 'mkfile', 'paste', '|', 'info'],
                // current directory file menu
                files: [
                    'getfile', '|', 'open', 'download', '|', 'copy', 'cut', 'paste', 'duplicate', '|',
                    <?php if (Auth::hasUser() && Auth::user()->isExecutive()) echo "'rm',"; ?> '|',
                    'edit', 'rename', 'resize', '|', 'archive', 'extract', '|', 'info'
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