@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('navs.frontend.filehub'))
@section('navBrand', app_name() . ' | ' . __('navs.frontend.filehub'))

@section('content')
    <!-- Element where elFinder will be created (REQUIRED) -->
    <div id="elfinder"></div>
@endsection

@push('after-scripts')
    <!-- jQuery and jQuery UI (REQUIRED) -->

    <!-- elFinder CSS (REQUIRED) -->
    <link rel="stylesheet" type="text/css" href="{{ asset($dir.'/css/elfinder.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset($dir.'/css/theme.css') }}">

    <!-- elFinder JS (REQUIRED) -->
    <script src="{{ asset($dir.'/js/elfinder.min.js') }}"></script>

    @if($locale)
        <!-- elFinder translation (OPTIONAL) -->
        <script src="{{ asset($dir."/js/i18n/elfinder.$locale.js") }}"></script>
    @endif

    <!-- elFinder initialization (REQUIRED) -->
    <script type="text/javascript" charset="utf-8">
        // Documentation for client options:
        // https://github.com/Studio-42/elFinder/wiki/Client-configuration-options
        $().ready(function() {
            $('#elfinder').elfinder({
                // set your elFinder options here
                lang: '{{ App::getLocale() }}',
                customData: {
                    _token: '{{ csrf_token() }}'
                },
                url : '{{ route("elfinder.connector") }}',  // connector URL
                soundPath: '{{ asset($dir.'/sounds') }}',
                height: '90%',
                resizable: false,
                commands : [
                    'custom', 'open', 'reload', 'home', 'up', 'back', 'forward', 'getfile', 'download',
                    'mkdir', 'mkfile', 'upload', 'archive', 'search', 'info', 'view', 'help', 'sort', 'netmount',
                    <?php if (Auth::user()->isExecutive()) echo "'copy', 'cut', 'paste', 'edit',
                    'extract', 'rm', 'duplicate', 'rename', 'resize'" ?>
                ],
                uiOptions : {
                    // toolbar configuration
                    toolbar : [
                        ['back', 'forward', 'up'],
                        ['mkdir', 'mkfile', 'upload'],
                        ['open', 'download', 'getfile', 'info'],
                        <?php if (Auth::user()->isExecutive())
                            echo "['copy', 'cut', 'paste', 'rm'],
                            ['duplicate', 'rename', 'edit', 'resize'],
                            ['extract', 'archive'],"
                        ?>
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
                    navbar : ['open', '|',
                        <?php if (Auth::user()->isExecutive()) echo "'copy', 'cut', 'paste', 'duplicate', '|', 'rm', '|',"?>
                        'info'],
                    // current directory menu
                    cwd    : ['reload', 'back', '|', 'upload', 'mkdir', 'mkfile', 'paste', '|', 'info'],
                    // current directory file menu
                    files  : [
                        'getfile', '|','open', 'download', '|', 'copy', 'cut', 'paste', 'duplicate', '|',
                        <?php if (Auth::user()->isExecutive()) echo "'rm',"; ?> '|', 'edit', 'rename', 'resize', '|', 'archive', 'extract', '|', 'info'
                    ]
                },
            });
        });
    </script>
@endpush
