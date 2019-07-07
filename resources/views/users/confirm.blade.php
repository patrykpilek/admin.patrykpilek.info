@extends('layouts.app')

@section('title', 'Delete Account')

@section('page-heading')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-6">
            <h2>Delete Confirmation</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('users.index') }}">User</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>Delete</strong>
                </li>
            </ol>
        </div>
        <div class="col-sm-6">
            <div class="title-action d-none d-sm-block">
                <a href="{{ route('users.index')}}" class="btn btn-outline btn-primary btn-xs"><i class="fa fa-angle-double-left"></i>&nbsp;Back</a>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        {!! Form::model($user, ['method' => 'DELETE', 'route' => ['users.destroy', $user->id]]) !!}
        {!! Form::token() !!}

            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="ibox ">
                        <div class="ibox-content">
                            <p>You have specified this user for deletion:</p>
                            <p>ID #{{ $user->id  }} : {{ $user->name }}</p>
                            <p>What should be done with content own by this user?</p>
                            <p><input type="radio" name="delete_option" value="delete" checked> Delete All Content</p>
                            <p>
                                <input type="radio" name="delete_option" value="attribute"> Attribute content to:
                                {!! Form::select('selected_user', $users, null); !!}
                            </p>
                        </div>
                        <div class="ibox-footer text-center">
                            {!! Form::submit('Delete', ['class' => 'btn btn-outline btn-danger']) !!}
                            <a href="{{ route('users.index') }}" class="btn btn-outline btn-dark">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>

        {!! Form::close() !!}
    </div>

@endsection
