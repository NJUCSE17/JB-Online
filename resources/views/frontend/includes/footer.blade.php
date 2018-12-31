<footer class="footer border-top bg-white">
    <i class="fas fa-copyright mr-2"></i>
    <a href="{{ route('frontend.about') }}">JB Online</a>
    ({{ date('Y') }}). All rights reserved.
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
    <span class="sm-hidden">
            <span class="mx-2">|</span>
            <a href="https://github.com/doowzs/JB-Online" class="text-dark">
                <i class="far fa-file-code mr-2"></i>
                RTFSC
            </a>
            <span class="mx-2">|</span>
            <a href="https://voice.njujb.com" class="text-dark mr-2">
                <i class="far fa-comment-alt mr-2"></i>
                JB Voice
            </a>
        </span>
</footer>