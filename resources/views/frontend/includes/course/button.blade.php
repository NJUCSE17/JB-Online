<a class="btn btn-outline-{{ $course->color_label }} text-justify my-1"
   style="width: 100%; line-height: 30px" href="{{ $course->course_link }}">
    {{ __('strings.frontend.home.semester.left') }}
    {{ $course->semester }}
    {{ __('strings.frontend.home.semester.right') }} &nbsp;
    {{ $course->name }}
    <div class="float-right">
                            <span>
                                <i class="fas fa-folder"></i>
                                {{ $course->assignmentsCount() }}
                                <i class="fas fa-comments"></i>
                                {{ $course->postsCount() }}
                            </span>
    </div>
</a>