@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="row border-bottom white-bg dashboard-header">
        <div class="col-12">
            <h2>Welcome back - {{ Auth::user()->name }}</h2>
        </div>
    </div>

    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-sm-6 col-md-6 col-lg-4">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5><a href="{{ route('blog.index') }}">Blog</a></h5>
                    </div>
                    <div class="ibox-content">
                        <ul class="list-group clear-list m-t">
                            <li class="list-group-item fist-item">
                                <span class="float-right"><span class="label">{{ $allPosts }}</span></span>
                                All
                            </li>
                            <li class="list-group-item">
                                <span class="float-right"><span class="label">{{ $ownPosts }}</span></span>
                                Own
                            </li>
                            <li class="list-group-item">
                                <span class="float-right"><span class="label">{{ $published }}</span></span>
                                Published
                            </li>
                            <li class="list-group-item">
                                <span class="float-right"><span class="label">{{ $scheduled }}</span></span>
                                Scheduled
                            </li>
                            <li class="list-group-item">
                                <span class="float-right"><span class="label">{{ $draft }}</span></span>
                                Draft
                            </li>
                            <li class="list-group-item">
                                <span class="float-right"><span class="label">{{ $trash }}</span></span>
                                Trash
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-4">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5><a href="{{ route('categories.index') }}">Categories</a></h5>
                    </div>
                    <div class="ibox-content">
                        <ul class="list-group clear-list m-t">
                            <li class="list-group-item fist-item">
                                <span class="float-right"><span class="label">{{ $allCategories }}</span></span>
                                All
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-4">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5><a href="{{ route('users.index') }}">Users</a></h5>
                    </div>
                    <div class="ibox-content">
                        <ul class="list-group clear-list m-t">
                            <li class="list-group-item fist-item">
                                <span class="float-right"><span class="label">{{ $allUsers }}</span></span>
                                All
                            </li>
                            <li class="list-group-item">
                                <span class="float-right"><span class="label">{{ $admin }}</span></span>
                                Admin
                            </li>
                            <li class="list-group-item">
                                <span class="float-right"><span class="label">{{ $author }}</span></span>
                                Author
                            </li>
                            <li class="list-group-item">
                                <span class="float-right"><span class="label">{{ $editor }}</span></span>
                                Editor
                            </li>
                            <li class="list-group-item">
                                <span class="float-right"><span class="label">{{ $users }}</span></span>
                                User
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
