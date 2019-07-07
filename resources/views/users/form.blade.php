<div class="ibox product-detail">
    <div class="ibox-content">
        <div class="col-12">
            @include('partials.message')
        </div>
        <div class="row">
            <div class="col-lg-4 col-xl-4">

                <h2 class="font-bold m-b-xs">
                    @if($user->exists)
                        Update account:
                    @else
                        New account:
                    @endif
                </h2>

                <hr>

                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    {!! Form::label('name', 'Name:', ['class' => 'col-form-label font-bold']); !!}
                    <div>
                        {!! Form::text('name', null, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : '') ] ) !!}
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group{{ $errors->has('slug') ? ' has-error' : '' }}">
                    {!! Form::label('slug', 'Slug:', ['class' => 'col-form-label font-bold']); !!}
                    <div>
                        {!! Form::text('slug', null, ['class' => 'form-control' . ($errors->has('slug') ? ' is-invalid' : '' ), 'readonly' ] ) !!}
                        @error('slug')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    {!! Form::label('email', 'E-mail:', ['class' => 'col-form-label font-bold']) !!}
                    <div>
                        {!! Form::text('email', null, ['class' => 'form-control' . ($errors->has('email') ? ' is-invalid' : '') ] ) !!}
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    {!! Form::label('password', 'Password:', ['class' => 'col-form-label font-bold']) !!}
                    <div>
                        {!! Form::password('password', ['class' => 'form-control' . ($errors->has('password') ? ' is-invalid' : '') ] ) !!}
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                    {!! Form::label('password_confirmation', 'Password Confirmation:', ['class' => 'col-form-label font-bold']) !!}
                    <div>
                        {!! Form::password('password_confirmation', ['class' => 'form-control'] ) !!}
                    </div>
                </div>

            </div>

            <div class="col-lg-4 col-xl-4">

                @if(Auth::user()->hasRole('admin'))
                    <div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
                        {!! Form::label('role', 'Role:', ['class' => 'col-form-label font-bold']) !!}
                        <div>
                            @if ($user->exists && ($user->id == config('cms.default_user_id') || isset($hideRoleDropdown)))
                                {!! Form::hidden('role', $user->roles->first()->id) !!}
                                {!! Form::text(null, $user->roles->first()->display_name, ['class' => 'form-control', 'disabled'] ) !!}
                            @else
                                {!! Form::select('role', App\Role::pluck('display_name', 'id'), $user->exists ? $user->roles->first()->id : null, ['class' => 'form-control' . ($errors->has('password') ? ' is-invalid' : ''), 'placeholder' => 'Choose a role']) !!}
                            @endif

                            @error('role')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                @endif

                <div class="form-group">
                    {!! Form::label('first_name', 'First Name:', ['class' => 'col-form-label font-bold']); !!}
                    <div>
                        {!! Form::text('first_name', $user->profile->first_name, ['class' => 'form-control'] ) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('last_name', 'Last Name:', ['class' => 'col-form-label font-bold']); !!}
                    <div>
                        {!! Form::text('last_name', $user->profile->last_name, ['class' => 'form-control'] ) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('birthday', 'Birthday:', ['class' => 'font-bold']); !!}
                    <div class="input-group date" id="datepickerBirthday" data-target-input="nearest">
                        <input value="{{ $user->profile->birthday }}" id="birthday" type="text" name="birthday" class="form-control datetimepicker-input" data-target="#datepickerBirthday" placeholder="yyyy/mm/dd"/>
                        <div class="input-group-append" data-target="#datepickerBirthday" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('bio', 'Bio:', ['class' => 'col-form-label font-bold']) !!}
                    <div>
                        {!! Form::textarea('bio', $user->profile->bio, ['rows' => 5, 'class' => 'form-control']) !!}
                    </div>
                </div>

            </div>

            <div class="col-lg-4 col-xl-4">
                <div class="form-group">
                    {!! Form::label('avatar', 'Profile Image:', ['class' => 'font-bold']); !!}
                    <div class="form-control fileinput fileinput-new text-center no-borders " data-provides="fileinput">
                        <div class="fileinput-new img-thumbnail" style="width: 200px; height: 150px;">
                            @if($user->exists)
                                <img src="{{ $user->gravatar() }}" alt="{{ $user->profile->image }}">
                            @else
                                <img src="{{ url('storage/avatars/default_avatar.png') }}" alt="Default Avatar">
                            @endif

                        </div>
                        <div class="fileinput-preview fileinput-exists img-thumbnail" style="max-width: 200px; max-height: 150px;"></div>
                        <div>
                            <span class="btn btn-outline btn-success btn-file">
                                <span class="fileinput-new">Select Image</span>
                                <span class="fileinput-exists">Change</span>
                                {!! Form::file('avatar') !!}
                            </span>
                            <a href="#" class="btn btn-outline btn-danger fileinput-exists" data-dismiss="fileinput">Remove</a>
                        </div>
                    </div>
                </div>
                <hr>
                @if($user->exists)
                    <button type="submit" class="btn btn-block btn-outline btn-primary"><i class="fa fa-pencil-square-o"></i>&nbsp;Update</button>
                @else
                    <button type="submit" class="btn btn-block btn-outline btn-primary"><i class="fa fa-save"></i>&nbsp;Create</button>
                @endif
            </div>
        </div>
    </div>
</div>