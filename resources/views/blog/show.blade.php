@extends('layouts.app')

@section('title', $post->title)

@section('page-heading')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-6">
            <h2>Created by: {{ $post->author->full_name }}</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('blog.index') }}">Blog</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>Article</strong>
                </li>
            </ol>
        </div>
        <div class="col-sm-6">
            <div class="title-action d-none d-sm-block">
                <a href="{{ url()->previous() }}" class="btn btn-outline btn-primary btn-xs"><i class="fa fa-angle-double-left"></i>&nbsp;Back</a>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight article">
        <div class="row justify-content-md-center">
            <div class="col-lg-10">
                <div class="ibox">
                    <div class="ibox-content">
                        {!! $post->publicationLabel() !!}
                        <div class="float-right">
                            Category: <button class="btn btn-white btn-xs" type="button">{{ $post->category->title }}</button>
                        </div>
                        <div class="text-center article-title">
                            <span class="text-muted"><i class="fa fa-clock-o"></i> {{ $post->created_at->format('jS M Y g:ia') }}</span>
                            <h1>
                                {{ $post->title }}
                            </h1>
                        </div>
                        <p>
                            {!! $post->body_html !!}
                        </p>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Tags:</h5>
                                {!! $post->tags_html !!}
                            </div>
                            <div class="col-md-6">
                                <div class="small text-right">
                                    <h5>Stats:</h5>
                                    <div> <i class="fa fa-comments-o"> </i> {{ $post->commentsNumber() }} </div>
                                    <i class="fa fa-eye"> </i> {{ $post->viewsNumber() }}
                                </div>
                            </div>
                        </div>

                        <div class="row m-b-lg m-t-lg">
                            <div class="col-lg-12">
                                <div class="profile-image">
                                    @php
                                        $author = $post->author;
                                    @endphp
                                    <img src="{{ $author->gravatar() }}" class="rounded-circle circle-border m-b-md" alt="{{ $author->name }}">
                                </div>
                                <div class="profile-info">
                                    <div class="">
                                        <div>
                                            <h2 class="no-margins">
                                                {{ $author->name }}
                                            </h2>
                                            <h4>
                                                {{ $author->roles->first()->display_name }}
                                                <i class="fa fa-clone"></i>
                                                <?php $postCount = ($tmp = $author->posts()->published()) ? $tmp->count() : 0 ?>
                                                <strong>{{ $postCount }}</strong> {{ str_plural('Article', $postCount) }}
                                            </h4>
                                            <small>
                                                {!! $author->bio_html !!}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>

                        <div class="row m-b-lg m-t-lg">
                            <div class="col-lg-12" id="post-comments">
                                <h2><i class="fa fa-comments"></i> {{ $post->commentsNumber('Comment') }}</h2>
                                @foreach($postComments as $comment)
                                    <div class="social-feed-box">
                                        <div class="social-avatar">
                                            <a href="" class="float-left">
                                                <img alt="image" src="{{ $post->author->gravatar() }}">
                                            </a>
                                            <div class="media-body">
                                                <a href="#">{{ $comment->author_name }}</a>
                                                <small class="text-muted">{{ $comment->date }}</small>
                                            </div>
                                        </div>
                                        <div class="social-body">
                                            <p>{!! $comment->body_html !!}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <nav>
                            {{ $postComments->fragment('post-comments')->links() }}
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection