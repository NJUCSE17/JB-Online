<div class="card mb-3">
    <div class="card-body p-3">
        <p class="text-center" style="font-size: 1.2rem;">
            <img class="user-avatar rounded-circle mr-2" src="{{ $logged_in_user->picture }}"
                 style="height: 30px !important;" alt="avatar">
            {{ $logged_in_user->full_name }}
        </p>
        <hr/>
        <div class="row">
            <div class="col text-center">
                {{ count($ongoingCourses) }}<br/>{{ __('labels.general.course') }}
            </div>
            <div class="col text-center">
                <?php
                    $finishedCount = 0;
                    foreach ($assignments as $assignment) {
                        if ($assignment->finish_status) {
                            $finishedCount++;
                        }
                    }
                ?>
                {{ count($assignments) - $finishedCount }} / {{ count($assignments) }}<br/>{{ __('labels.general.assignment') }}
            </div>
        </div>
    </div>
</div>