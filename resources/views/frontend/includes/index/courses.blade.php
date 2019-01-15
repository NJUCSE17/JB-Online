<div class="card my-3">
    <div class="card-body p-3">
        @if ($ongoingCourses->count())
            @foreach($ongoingCourses as $course)
                <a class="btn btn-outline-{{ $course->color_label }} text-justify my-1"
                   style="width: 100%;" href="{{ $course->course_link }}">
                    {{ __('strings.frontend.home.semester.left') }}
                    {{ $course->semester }}
                    {{ __('strings.frontend.home.semester.right') }} &nbsp;
                    {{ $course->name }}
                    <span class="float-right">
                        <i class="fas fa-folder"></i>
                        {{ $course->assignmentsCount() }}
                    </span>
                </a>
            @endforeach
        @else
            <div class="row">
                <div class="col text-center">
                    {{ __('strings.frontend.home.no_ongoing') }}
                </div>
            </div>
        @endif
        <hr />
        <div class="row">
            <div class="col col-md-8 col-6 pr-2">
                <a class="btn btn-outline-dark text-center" style="width: 100%;"
                   href="{{ route('frontend.forum.personal.index') }}">
                    <i class="fas fa-user mr-1"></i>{{ __('labels.frontend.home.personal') }}
                </a>
            </div>
            <div class="col col-md-4 col-6 pl-2">
                <a class="btn btn-outline-dark text-center" style="width: 100%;"
                   href="{{ route('frontend.forum.personal.create') }}">
                    <i class="fas fa-plus"></i>
                </a>
            </div>
        </div>
    </div>
    <a class="card-footer btn text-center"
       href="{{ route('frontend.forum.course') }}">
        {{ __('labels.frontend.home.course') }} <i class="fas fa-angle-right"></i>
    </a>
</div>