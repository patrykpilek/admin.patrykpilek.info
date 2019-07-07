@extends('layouts.app')

@section('title', 'Create Account')

@include('users.styles')

@section('page-heading')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-6">
            <h2>Create new account</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('users.index') }}">Users</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>Create</strong>
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
        {!! Form::model($user, ['method' => 'POST', 'route'  => 'users.store', 'files' => TRUE ]) !!}
        {!! Form::token() !!}
            @include('users.form')
        {!! Form::close() !!}
    </div>
@endsection

@include('users.scripts')
