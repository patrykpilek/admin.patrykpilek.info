@extends('layouts.app')

@section('title', 'Edit Post')

@include('blog.styles')

@section('page-heading')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-6">
            <h2>Edit Post</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('blog.index') }}">Blog</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>Edit Post</strong>
                </li>
            </ol>
        </div>
        <div class="col-sm-6">
            <div class="title-action d-none d-sm-block">
                <a href="{{ route('blog.index') }}" class="btn btn-outline btn-primary btn-xs"><i class="fa fa-angle-double-left"></i>&nbsp;Back</a>
                <a href="{{ route('blog.show', $post->id)}}" class="btn btn-outline btn-dark btn-xs"><i class="fa fa-eye"></i>&nbsp;View</a>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        @include('partials.message')
        {!! Form::model($post, [
                'method' => 'PUT',
                'route'  => ['blog.update', $post->id],
                'files'  => TRUE,
                'id' => 'post-form'
            ]) !!}

        @include('blog.form')

        {!! Form::close() !!}
    </div>
@endsection

@include('blog.scripts')
