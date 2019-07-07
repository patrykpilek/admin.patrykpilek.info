@extends('layouts.app')

@section('title', 'Blog')

@section('page-heading')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-6 d-none d-sm-block">
            <h2>Display all posts</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Home</a>
                </li>
                <li class="breadcrumb-item active">
                    <a href="{{ route('blog.index') }}">Blog</a>
                </li>
            </ol>
        </div>
        <div class="col-sm-6">
            <div class="title-action">
                @php $links = []; @endphp
                @foreach($statusList as $key => $value)
                    @if($value)
                        @php
                            $selected = request()->get('status') == $key ? 'badge badge-success' : '';
                            $links[] = "<a class= \"{$selected}\" href=\"?status={$key}\">" . ucwords($key) . " [{$value}]</a>";
                        @endphp
                    @endif
                @endforeach
                {!! implode(' | ', $links) !!}
            </div>
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
                        <h5>All Posts</h5>
                        <div class="ibox-tools">
                            <a href="{{ route('blog.create') }}" class="btn btn-primary btn-xs"><i class="fa fa-plus"></i>&nbsp;Add Post</a>
                        </div>
                    </div>
                    <div class="ibox-content">

                        @if( ! $posts->count())
                            <div class="alert alert-danger alert-dismissable">
                                <strong>No record found</strong>
                            </div>
                        @else
                            @if($onlyTrashed)
                                @include('blog.table-trash')
                            @else
                                @include('blog.table')
                            @endif
                        @endif
                    </div>
                    <div class="ibox-footer clearfix">
                        <span class="float-left">
                            {{ $posts->appends( request()->query() )->render() }}
                        </span>
                        <span class="float-right">
                            {{ $postCount }} {{ Str::plural('Item', $postCount) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
