@extends('layouts.app')

@section('title', 'Add New Post')

@include('blog.styles')

@section('page-heading')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-6">
            <h2>Create New Post</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('blog.index') }}">Blog</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>Post</strong>
                </li>
            </ol>
        </div>
        <div class="col-sm-6">
            <div class="title-action d-none d-sm-block">
                <a href="{{ route('blog.index') }}" class="btn btn-outline btn-primary btn-xs"><i class="fa fa-angle-double-left"></i>&nbsp;Back</a>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        {!! Form::model($post, [
                  'method' => 'POST',
                  'route'  => 'blog.store',
                  'files'  => TRUE,
                  'id' => 'post-form'
              ]) !!}
            @include('blog.form')
        {!! Form::close() !!}
    </div>
@endsection

@include('blog.scripts')