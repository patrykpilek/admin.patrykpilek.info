<div class="row">
    <div class="col-md-6 offset-md-3">

        @include('partials.message')

        <div class="ibox">
            <div class="ibox-title">
                Category Details
            </div>
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
            </div>
            <div class="ibox-footer">
                <span class="float-right">
                     @if($category->exists)
                        <button type="submit" class="btn btn-outline btn-primary"><i class="fa fa-save"></i>&nbsp;Update</button>
                    @else
                        <button type="submit" class="btn btn-outline btn-primary"><i class="fa fa-save"></i>&nbsp;Create</button>
                    @endif
                </span>
                <a href="{{ route('categories.index') }}" class="btn btn-outline btn-success">Cancel</a>
            </div>
        </div>
    </div>
</div>
