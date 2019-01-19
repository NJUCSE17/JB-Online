<div class="card mb-3">
    <div class="card-body p-3">
        <p class="text-center">
            <img class="user-avatar rounded-circle mr-2" src="{{ $logged_in_user->picture }}"
                 style="height: 25px !important;" alt="avatar">
            {{ $logged_in_user->full_name }}
        </p>
        <hr/>
        <div class="row">
            <div class="col text-center">
                {{ count($ongoingCourses) }} <br/> {{ __('labels.general.course') }}
            </div>
            <div class="col text-center">
                {{ count($assignments) }} <br/> {{ __('labels.general.assignment') }}
            </div>
        </div>
    </div>
</div>