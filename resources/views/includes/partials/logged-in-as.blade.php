@if (auth()->user() && session()->has("admin_user_id") && session()->has("temp_user_id"))
    <div class="alert alert-warning logged-in-as mb-0">
        You are currently logged in as {{ auth()->user()->name }}.
        <a href="{{ route("frontend.auth.logout-as") }}"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                   Re-Login as {{ session()->get("admin_user_name") }} </a>.
    </div><!--alert alert-warning logged-in-as-->
    <form id="logout-form" action="{{ route('frontend.auth.logout-as') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
@endif