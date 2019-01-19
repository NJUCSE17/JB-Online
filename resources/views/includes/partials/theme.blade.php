<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownThemeLink">
    @foreach (array_keys(config('theme.themes')) as $theme)
        <a href="{{ '/theme/'.$theme }}" class="dropdown-item">{{ __('menus.theme-picker.themes.'.$theme) }}</a>
    @endforeach
</div>
