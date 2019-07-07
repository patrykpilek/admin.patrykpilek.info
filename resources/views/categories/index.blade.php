@extends('layouts.app')

@section('title', 'Categories')

@section('page-heading')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-12">
            <h2>List of all categories</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Home</a>
                </li>
                <li class="breadcrumb-item active">
                    <a href="{{ route('categories.index') }}">Categories</a>
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
                        <h5>Categories</h5>
                        <div class="ibox-tools">
                            <a href="{{ route('categories.create') }}" class="btn btn-primary btn-xs"><i class="fa fa-plus"></i>&nbsp;Add Category</a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        @if( ! $categories)
                            <div class="alert alert-danger alert-dismissable">
                                <strong>No record found</strong>
                            </div>
                        @else
                            @include('categories.table')
                        @endif
                    </div>
                    <div class="ibox-footer clearfix">
                        <span class="float-left">
                            {{ $categories->appends( request()->query() )->render() }}
                        </span>
                        <span class="float-right">
                            {{ $categoriesCount }} {{ Str::plural('Item', $categoriesCount) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
