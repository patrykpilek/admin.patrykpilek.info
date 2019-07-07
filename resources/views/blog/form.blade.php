<div class="row">
    <div class="col-12 col-lg-8 col-xl-9">

        <div class="ibox">

            @include('partials.message')

            <div class="ibox-title">Post Details</div>
            <div class="ibox-content">

                <div class="row form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                    {!! Form::label('title', 'Title:', ['class' => 'col-sm-2 col-form-label']); !!}
                    <div class="col-sm-10">
                        {!! Form::text('title', null, ['class' => 'form-control' . ($errors->has('title') ? ' is-invalid' : '') ]) !!}
                        @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row form-group{{ $errors->has('slug') ? ' has-error' : '' }}">
                    {!! Form::label('slug', 'Slug:', ['class' => 'col-sm-2 col-form-label']); !!}
                    <div class="col-sm-10">
                        {!! Form::text('slug', null, ['class' => 'form-control' . ($errors->has('slug') ? ' is-invalid' : ''), 'readonly' ]) !!}
                        @error('slug')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row form-group excerpt">
                    {!! Form::label('excerpt', 'Excerpt:', ['class' => 'col-sm-2 col-form-label']); !!}
                    <div class="col-sm-10">
                        {!! Form::textarea('excerpt', null, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="row form-group{{ $errors->has('body') ? ' has-error' : '' }}">
                    {!! Form::label('body', 'Body:', ['class' => 'col-sm-2 col-form-label']); !!}
                    <div class="col-sm-10">
                        {!! Form::textarea('body', null, ['class' => 'form-control'. ($errors->has('body') ? ' is-invalid' : '')]) !!}
                        @error('body')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="col-12 col-lg-4 col-xl-3">
        <div class="ibox ">
            <div class="ibox-content">
                <div class="col-12">
                    <div class="row form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                        {!! Form::label('image', 'Feature Image:'); !!}
                    </div>
                    <div class="form-control fileinput fileinput-new text-center{{ $errors->has('image') ? ' is-invalid' : '' }}" data-provides="fileinput">
                        <div class="fileinput-new img-thumbnail" style="width: 200px; height: 150px;">
                            <img src="{{ $post->image_thumb_url }}"  alt="Post Image">
                        </div>
                        <div class="fileinput-preview fileinput-exists img-thumbnail" style="max-width: 200px; max-height: 150px;"></div>
                        <div>
                        <span class="btn btn-outline btn-success btn-xs btn-file">
                            <span class="fileinput-new">Select Image</span>
                            <span class="fileinput-exists">Change</span>
                            {!! Form::file('image') !!}
                        </span>
                            <a href="#" class="btn btn-outline btn-danger btn-xs fileinput-exists" data-dismiss="fileinput">Remove</a>
                        </div>
                    </div>
                    @error('image')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="ibox ">
            <div class="ibox-content">
                <div class="row form-group{{ $errors->has('category_id') ? ' has-error' : '' }}">
                    <div class="col-12">
                        {!! Form::label('category_id', 'Category:'); !!}
                        {!! Form::select('category_id', App\Category::pluck('title', 'id'), null, ['class' => 'form-control', 'placeholder' => 'Choose category']) !!}
                        @error('category_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="ibox ">
            <div class="ibox-content">
                <div class="row form-group">
                    <div class="col-12">
                        {!! Form::label('post_tags', 'Tags:'); !!}
                        {!! Form::text('post_tags', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="ibox ">
            <div class="ibox-content">
                <div class="row form-group{{ $errors->has('published_at') ? ' has-error' : '' }}">
                    <div class="col-12">
                        {!! Form::label('published_at', 'Published Date:'); !!}
                        <div class="input-group date" id="datetimepicker1" data-target-input="nearest">
                            <input id="published_at" type="text" name="published_at" value="{{ $post->published_at }}" class="form-control datetimepicker-input{{ $errors->has('published_at') ? ' is-invalid' : '' }}" data-target="#datetimepicker1" placeholder="Y-m-d H:i:s"/>
                            <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                            @error('published_at')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="clearfix">
                    <div class="pull-left">
                        <button type="button" id="draft-btn" class="btn btn-outline btn-success">Save Draft</button>
                    </div>
                    <div class="pull-right">
                        @if($post->exists)
                            {!! Form::submit('Update', ['class' => 'btn btn-outline btn-primary']) !!}
                        @else
                            {!! Form::submit('Publish Post', ['class' => 'btn btn-outline btn-primary']) !!}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>