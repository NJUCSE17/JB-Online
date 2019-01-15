@extends ('backend.layouts.app')

@section ('title', __('labels.backend.forum.courses.management') . ' | ' . __('labels.backend.forum.courses.create'))

@section('breadcrumb-links')
    @include('backend.forum.course.includes.breadcrumb-links')
@endsection

@section('content')
    <div class="card">
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
                    {{ form_submit(__('buttons.general.crud.create')) }}
                </div>
            </div>
            {{ html()->form()->close() }}
            <hr/>

            <div class="row">
                <div class="col">
                    <h3>Students</h3>
                    <div class="list-group">
                        @foreach($students as $student)
                            <div class="list-group-item">
                                {{ $student->student_id }} - {{ $student->name }}
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col">
                    <h3>Admins</h3>
                    <div class="list-group">
                        @foreach($admins as $admin)
                            <div class="list-group-item">
                                {{ $admin->student_id }} - {{ $admin->name }}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection