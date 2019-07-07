<div class="project-list">
    <table class="table table-hover">
        <tbody>
        <?php $currentUser = auth()->user(); ?>
        @foreach($users as $user)
            <tr>
                <td class="d-none d-md-table-cell d-lg-table-cell d-xl-table-cell">
                    @if(empty($user->email_verified_at))
                        <span class="label label-danger">Not Verified</span>
                    @else
                        <span class="label label-primary">Verified</span>
                    @endif
                </td>
                <td >
                    <strong>{{ Str::title($user->name) }}</strong>
                    <br/>
                    <small>{{ $user->created_at }}</small>
                </td>
                <td class="d-none d-md-table-cell d-lg-table-cell d-xl-table-cell">
                    <i class="fa fa-envelope"></i>&nbsp;{{ $user->email }}
                </td>
                <td class="d-none d-md-table-cell d-lg-table-cell d-xl-table-cell">
                    {{ $user->roles->first()->display_name }}
                </td>
                <td class="project-people d-none d-sm-table-cell d-md-table-cell d-lg-table-cell d-xl-table-cell">
                    <img alt="{{ $user->profile->image }}" class="rounded-circle img-sm" src="{{ $user->gravatar() }}">
                </td>
                <td class="project-actions">
                    <a href="{{ route('users.edit', $user) }}" class="btn btn-white btn-xs"><i class="fa fa-pencil"></i>&nbsp;Edit&nbsp;</a>
                    @if($user->id == config('cms.default_user_id') || $user->id == $currentUser->id)
                        <button onclick="return false" type="submit" class="btn btn-danger btn-xs disabled">
                            <i class="fa fa-trash"></i>&nbsp;Delete&nbsp;
                        </button>
                    @else
                        <a href="{{ route('users.confirm', $user->id) }}" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i>&nbsp;Delete&nbsp;</a>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>