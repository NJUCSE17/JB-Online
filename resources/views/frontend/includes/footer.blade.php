<footer class="footer bg-light">
    <i class="fas fa-copyright mr-1"></i>
    <a href="{{ route('frontend.about') }}">JB Online</a>
    (2018 - {{ date('Y') }})
    &nbsp;
    Page load: {{ round(microtime(true) - LARAVEL_START, 2) }}ms
    @if (config('locale.status') && count(config('locale.languages')) > 1)
        <span class="mx-2">|</span>
        <span class="dropdown">
            <a href="#" class="dropdown-toggle text-dark" id="navbarDropdownLanguageLink"
               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-language"></i>
            </a>
            @include('includes.partials.lang')
        </span>
    @endif
    <span class="d-none d-lg-inline-block">
            <span class="mx-2">|</span>
            <a target="_blank" href="https://github.com/NJUCSE17/JB-Online" class="text-dark">
                <i class="far fa-file-code mr-2"></i>
                RTFSC
            </a>
        </span>
</footer>