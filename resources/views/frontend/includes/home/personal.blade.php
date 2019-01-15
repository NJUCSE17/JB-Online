{{ html()->form('POST', route('frontend.forum.personal.store'))->class('form-horizontal')->open() }}
<div class="card my-3">
    <div class="card-body p-3" id="add_personal_assignment">
        <div class="row mb-3">
            <div class="col col-md-6 col-12 pr-2">
                {{ html()->text('name')
                    ->class('form-control')
                    ->placeholder(__('validation.attributes.frontend.forum.personal.name'))
                    ->attribute('maxlength', 191)
                    ->required() }}
            </div>
            <div class="col col-md-6 col-12 pl-2">
                {{ html()->text('due_time', date('Y-m-d H:i:s'))
                    ->class('form-control')
                    ->placeholder(__('validation.attributes.frontend.forum.personal.due_time'))
                    ->attribute('maxlength', 191)
                    ->required() }}
            </div>
        </div>
        <div class="row">
            <div class="col col-12">
                {{ html()->textarea('content')
                    ->class('form-control')
                    ->placeholder(__('validation.attributes.frontend.forum.personal.content'))
                    ->attribute('maxlength', 1900) }}
            </div>
        </div>
    </div>

    <div class="card-footer clearfix">
        <div class="row">
            <div class="col">
                假装这里有字数统计
            </div>

            <div class="col text-right">
                <button class="btn btn-sm btn-success pull-right" type="submit">
                    {{ __('buttons.general.crud.create') }}
                </button>
            </div>
        </div>
    </div>
</div>
{{ html()->form()->close() }}