{{ html()->modelForm($logged_in_user, 'PATCH', route('frontend.user.profile.update'))->class('form-horizontal')->attribute('enctype', 'multipart/form-data')->open() }}
    <div class="row">
        <div class="col">
            <div class="form-group">
                {{ html()->label(__('validation.attributes.frontend.avatar'))->for('avatar') }}

                <div class="row mx-3">
                    <div class="custom-control custom-radio col">
                        <input type="radio" id="avatar_type_1" name="avatar_type" value="gravatar" class="custom-control-input" {{ $logged_in_user->avatar_type == 'gravatar' ? 'checked' : '' }}>
                        <label class="custom-control-label" for="avatar_type_1">Gravatar</label>
                    </div>
                    <div class="custom-control custom-radio col">
                        <input type="radio" id="avatar_type_2" name="avatar_type" value="storage" class="custom-control-input" {{ $logged_in_user->avatar_type == 'storage' ? 'checked' : '' }}>
                        <label class="custom-control-label" for="avatar_type_2">Upload</label>
                    </div>

                    @foreach ($logged_in_user->providers as $provider)
                        @if (strlen($provider->avatar))
                            <div class="custom-control custom-radio col">
                                <input type="radio" id="avatar_type_3" name="avatar_type" value="{{ $provider->provider }}" class="custom-control-input"  {{ $logged_in_user->avatar_type == $provider->provider ? 'checked' : '' }}>
                                <label class="custom-control-label" for="avatar_type_3">{{ ucfirst($provider->provider) }}</label>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div><!--form-group-->

            <div class="form-group" id="avatar_location">
                {{ __('strings.frontend.user.avatar_restriction') }}
                {{ html()->file('avatar_location')->class('form-control') }}
            </div><!--form-group-->
        </div><!--col-->
    </div><!--row-->

    <div class="row">
        <div class="col">
            <div class="form-group">
                {{ html()->label(__('validation.attributes.frontend.first_name'))->for('first_name') }}

                {{ html()->text('first_name')
                    ->class('form-control')
                    ->placeholder(__('validation.attributes.frontend.first_name'))
                    ->attribute('maxlength', 191)
                    ->required()
                    ->autofocus() }}
            </div><!--form-group-->
        </div><!--col-->

        <div class="col">
            <div class="form-group">
                {{ html()->label(__('validation.attributes.frontend.last_name'))->for('last_name') }}

                {{ html()->text('last_name')
                    ->class('form-control')
                    ->placeholder(__('validation.attributes.frontend.last_name'))
                    ->attribute('maxlength', 191) }}
            </div><!--form-group-->
        </div><!--col-->

        <div class="col">
            <div class="form-group">
                {{ html()->label(__('validation.attributes.frontend.want_mail'))->for('want_mail') }}

                {{ html()->select('want_mail', [
                        0=>__('labels.general.no'),
                        1=>__('labels.general.yes')])
                    ->class('form-control')
                    ->required() }}
            </div><!--form-group-->
        </div><!--col-->
    </div><!--row-->

    <div class="row">
        <div class="col">
            <div class="form-group">
                {{ html()->label(__('validation.attributes.frontend.blog'))->for('blog') }}

                {{ html()->text('blog')
                    ->class('form-control')
                    ->placeholder(__('validation.attributes.frontend.blog'))
                    ->attribute('maxlength', 191) }}
            </div><!--form-group-->
        </div><!--col-->
    </div><!--row-->

    @if ($logged_in_user->canChangeEmail())
        <div class="row">
            <div class="col">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> {{  __('strings.frontend.user.change_email_notice') }}
                </div>

                <div class="form-group">
                    {{ html()->label(__('validation.attributes.frontend.email'))->for('email') }}

                    {{ html()->email('email')
                        ->class('form-control')
                        ->placeholder(__('validation.attributes.frontend.email'))
                        ->attribute('maxlength', 191)
                        ->required() }}
                </div><!--form-group-->
            </div><!--col-->
        </div><!--row-->
    @endif

    <div class="row">
        <div class="col">
            <div class="form-group mb-0 clearfix text-right">
                {{ form_submit(__('labels.general.buttons.update')) }}
            </div><!--form-group-->
        </div><!--col-->
    </div><!--row-->
{{ html()->closeModelForm() }}

@push('after-scripts')
    <script>
        $(function() {
            var avatar_location = $("#avatar_location");

            if ($('input[name=avatar_type]:checked').val() === 'storage') {
                avatar_location.show();
            } else {
                avatar_location.hide();
            }

            $('input[name=avatar_type]').change(function() {
                if ($(this).val() === 'storage') {
                    avatar_location.show();
                } else {
                    avatar_location.hide();
                }
            });
        });
    </script>
@endpush