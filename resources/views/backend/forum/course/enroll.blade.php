@extends ('backend.layouts.app')

@section ('title', __('labels.backend.forum.courses.management') . ' | ' . __('labels.backend.forum.courses.create'))

@section('breadcrumb-links')
    @include('backend.forum.course.includes.breadcrumb-links')
@endsection

@section('content')
    <div class="card">
        <h2 class="card-header">{{ $course->name }}: Enrollment Control</h2>
        <div class="card-body">
            {{ html()->form('POST', route('admin.forum.course.enroll.edit', [$course]))->class('form-horizontal')->open() }}
            <div class="row">
                <div class="col col-12 col-md-5">
                    {{ html()->text('student_id')
                        ->placeholder('Student ID')
                        ->class('form-control')
                        ->attribute('maxlength', 9)
                        ->required() }}
                </div>
                <div class="col col-12 col-md-5">
                    {{ html()->select('type', [
                        0 => 'Delete User',
                        1 => 'Add as Student',
                        2 => 'Add as Admin'
                    ], 1)
                        ->class('form-control')
                        ->required() }}
                </div>
                <div class="col col-12 col-md-2">
                    {{ html()->button(__('buttons.general.crud.create'))
                        ->class('btn btn-sm btn-success')
                        ->style('width:100%;')
                        ->type('submit') }}
                </div>
            </div>
            {{ html()->form()->close() }}
            <hr/>

            <div class="row">
                <div class="col">
                    <h3>Not Enrolled</h3>
                    <div class="list-group">
                        @foreach($others as $other)
                            <div class="list-group-item" style="line-height: 30px;">
                                {{ $other->student_id }} - {{ $other->name }}
                                <span class="float-right">
                                    {{ html()->form("POST", route('admin.forum.course.enroll.edit', [$course]))->open() }}
                                        {{ html()->text('student_id', $other->student_id)->attribute('hidden') }}
                                        {{ html()->text('type', 1)->attribute('hidden') }}
                                        {{ html()->button('<i class="fas fa-check"></i>')->class('btn btn-sm btn-success')->type('submit') }}
                                    {{ html()->form()->close() }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col">
                    <h3>Students</h3>
                    <div class="list-group">
                        @foreach($students as $student)
                            <div class="list-group-item" style="line-height: 30px;">
                                {{ $student->student_id }} - {{ $student->name }}
                                <span class="float-right">
                                    {{ html()->form("POST", route('admin.forum.course.enroll.edit', [$course]))->open() }}
                                        {{ html()->text('student_id', $student->student_id)->attribute('hidden') }}
                                        {{ html()->text('type', 0)->attribute('hidden') }}
                                        {{ html()->button('<i class="fas fa-times"></i>')->class('btn btn-sm btn-danger')->type('submit') }}
                                    {{ html()->form()->close() }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col">
                    <h3>Admins</h3>
                    <div class="list-group">
                        @foreach($admins as $admin)
                            <div class="list-group-item" style="line-height: 30px;">
                                {{ $admin->student_id }} - {{ $admin->name }}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection