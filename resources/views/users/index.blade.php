@extends('layouts.app')

@section('title', 'Users')

@section('page-heading')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-12">
            <h2>List of all account</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">
                    <a href="{{ route('users.index') }}">Users</a>
                </li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-12">
                <div class="ibox">
                    @include('partials.message')
                    <div class="ibox-title">
                        <h5>Users Accounts</h5>
                        <div class="ibox-tools">
                            <a href="{{ route('users.create') }}" class="btn btn-primary btn-xs"><i class="fa fa-plus"></i>&nbsp;Add User</a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        @if( ! $users)
                            <div class="alert alert-danger alert-dismissable">
                                <strong>No record found</strong>
                            </div>
                        @else
                            @include('users.table')
                        @endif
                    </div>
                    <div class="ibox-footer clearfix">
                        <span class="float-left">
                            {{ $users->appends( request()->query() )->render() }}
                        </span>
                        <span class="float-right">
                            {{ $usersCount }} {{ Str::plural('Item', $usersCount) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection