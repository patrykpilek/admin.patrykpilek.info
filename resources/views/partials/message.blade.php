@if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <h4 class="alert-heading">Done !!!</h4>
        <hr>
        <p class="mb-0">{{ $message }}</p>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@elseif($message = Session::get('error-message'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <h4 class="alert-heading">Done !!!</h4>
        <hr>
        <p class="mb-0">{{ $message }}</p>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@elseif(session('trash-message'))
    <?php list($message, $postId) = session('trash-message') ?>
    {!! Form::open(['method' => 'PUT', 'route' => ['blog.restore', $postId]]) !!}
        <div class="alert alert-success alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            {{ $message }}
            <hr>
            <p>
                If you would like to restore post please press&nbsp;
                <button type="submit" class="btn btn-warning btn-rounded btn-xs"><i class="fa fa-undo"></i>&nbsp;Undo</button>
            </p>
        </div>
    {!! Form::close() !!}
@endif

@if (count($errors) > 0)
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <h4 class="alert-heading">Upsss, something's wrong</h4>
        <hr>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif