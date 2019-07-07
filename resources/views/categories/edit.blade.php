@extends('layouts.app')

@section('title', 'Update Category')

@section('page-heading')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-8">
            <h2>Update: "<strong>{{ Str::title($category->title) }}</strong>" category</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('categories.index') }}">Categories</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>Category</strong>
                </li>
            </ol>
        </div>
        <div class="col-sm-4">
            <div class="title-action d-none d-sm-block">
                <a href="{{ route('categories.index')}}" class="btn btn-outline btn-primary btn-xs"><i class="fa fa-angle-double-left"></i>&nbsp;Back</a>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        {!! Form::model($category, [ 'method' => 'PUT', 'route'  => ['categories.update', $category] ]) !!}
            @include('categories.form')
        {!! Form::close() !!}
    </div>
@endsection

@include('categories.scripts')
