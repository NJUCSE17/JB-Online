<div class="card my-3">
    <h4 class="card-header">
        <i class="fas fa-book-open mr-2"></i>
        {{ __('labels.frontend.home.ongoing') }}
        @auth
            @if(Auth::user()->isExecutive())
                <span class="float-right d-flex">
                    <a class="text-sm-center text-dark" href="{{ route('admin.forum.course.index') }}">
                        <i class="fas fa-cog"></i>
                    </a>
                </span>
            @endif
        @endauth
    </h4>
    <div class="card-body">
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
        <span class="float-left">
            <a class="btn btn-outline-dark text-justify"
               href="{{ route('frontend.forum.personal.index') }}">
                <i class="fas fa-user mr-1"></i>{{ __('labels.frontend.home.personal') }}
            </a>
            <a class="btn btn-outline-dark text-justify"
               href="{{ route('frontend.forum.personal.create') }}">
                <i class="fas fa-plus"></i>
            </a>
        </span>
        <a class="btn btn-outline-dark text-justify float-right"
           href="{{ route('frontend.forum.course') }}">
            {{ __('labels.frontend.home.course') }} <i class="fas fa-angle-right"></i>
        </a>
    </div>
</div>