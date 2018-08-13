<div class="col">
    <div class="table-responsive">
        <table class="table table-hover">
            <tr>
                <th>{{ __('labels.backend.access.users.tabs.content.overview.avatar') }}</th>
                <td><img src="{{ $user->picture }}" class="user-profile-image" /></td>
            </tr>

            <tr>
                <th>{{ __('labels.backend.access.users.tabs.content.overview.student_id') }}</th>
                <td>{{ $user->student_id }}</td>
            </tr>

            <tr>
                <th>{{ __('labels.backend.access.users.tabs.content.overview.name') }}</th>
                <td>{{ $user->name }}</td>
            </tr>

            <tr>
                <th>{{ __('labels.backend.access.users.tabs.content.overview.email') }}</th>
                <td>{{ $user->email }}</td>
            </tr>

            <tr>
                <th>{{ __('labels.backend.access.users.tabs.content.overview.status') }}</th>
                <td>{!! $user->status_label !!}</td>
            </tr>

            <tr>
                <th>{{ __('labels.backend.access.users.tabs.content.overview.confirmed') }}</th>
                <td>{!! $user->confirmed_label !!}</td>
            </tr>

            <tr>
                <th>{{ __('labels.backend.access.users.tabs.content.overview.timezone') }}</th>
                <td>{{ $user->timezone }}</td>
            </tr>

            <tr>
                <th>{{ __('labels.backend.access.users.tabs.content.overview.last_login_at') }}</th>
                <td>
                    @if ($user->last_login_at)
                        {{ timezone()->convertToLocal($user->last_login_at) }}
                    @else
                        N/A
                    @endif
                </td>
            </tr>

            <tr>
                <th>{{ __('labels.backend.access.users.tabs.content.overview.last_login_ip') }}</th>
                <td>{{ $user->last_login_ip or 'N/A' }}</td>
            </tr>
        </table>
    </div>
</div><!--table-responsive-->