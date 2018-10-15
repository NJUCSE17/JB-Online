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

<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/default.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/highlight.min.js"></script>

<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">

<script src="{{ URL::asset('js/tinymce/tinymce.min.js') }}"></script>
<script>
    hljs.initHighlightingOnLoad();
    tinymce.init({
        skin: 'light',
        selector: 'textarea',
        file_browser_callback: elFinderBrowser,
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

    function elFinderBrowser(field_name, url, type, win) {
        tinymce.activeEditor.windowManager.open({
            file: '<?= route('elfinder.tinymce4') ?>',
            title: 'elFinder 2.0',
            lang: '{{ App::getLocale() }}',
            width: 900,
            height: 450,
            resizable: 'yes',
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