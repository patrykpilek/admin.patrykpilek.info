@extends('layouts.app')

@section('title', 'Edit Profile')

@push('styles')
    <link href="{{ asset('css/plugins/jasnyBootstrap/jasny-bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/tempusdominus-bootstrap-4/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet">
@endpush

@section('page-heading')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-6">
            <h2>Update: <strong>{{ Str::title($user->full_name) }}</strong></h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('users.index') }}">Users</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>Profile</strong>
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
        {!! Form::model($user, ['method' => 'PUT', 'route'  => ['users.update', $user], 'files' => TRUE ]) !!}
        {!! Form::token() !!}
            @include('users.form')
        {!! Form::close() !!}
    </div>
@endsection

@include('users.scripts')
