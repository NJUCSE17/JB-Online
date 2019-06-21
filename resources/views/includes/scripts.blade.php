<script src="{{ mix('js/app.js') }}" type="text/javascript"></script>
@if(\Auth::hasUser())
    <script src="{{ mix('js/sw-register.js') }}" type="text/javascript"></script>
@endif