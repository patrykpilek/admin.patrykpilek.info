<table class="table table-bordered">
    <thead>
        <tr>
            <td width="80">
                Action
            </td>
            <td>
                Title
            </td>
            <td width="120" class="d-none d-md-table-cell d-lg-table-cell d-xl-table-cell">
                Author
            </td>
            <td width="150" class="d-none d-lg-table-cell d-xl-table-cell">
                Category
            </td>
            <td class="d-none d-lg-table-cell d-xl-table-cell">
                Views
            </td>
            <td class="d-none d-xl-table-cell">
                Comments
            </td>
            <td width="170" class="d-none d-lg-table-cell d-xl-table-cell">
                Date | Status
            </td>
        </tr>
    </thead>
    <tbody>
        <?php $request = request(); ?>

        @foreach($posts as $post)

            <tr>
                <td>
                    {!! Form::open(['method' => 'DELETE', 'route' => ['blog.destroy', $post->id]]) !!}
                    <div class="btn-group">
                        <a href="{{ route('blog.show', $post->id) }}" class="btn btn-white btn-xs" title="View"><i class="fa fa-eye"></i></a>

                        @if (check_user_permissions($request, "Blog@edit", $post->id))
                            <a href="{{ route('blog.edit', $post->id) }}" class="btn btn-xs btn-default">
                                <i class="fa fa-edit"></i>
                            </a>
                        @else
                            <a href="#" class="btn btn-xs btn-default disabled">
                                <i class="fa fa-edit"></i>
                            </a>
                        @endif

                        @if (check_user_permissions($request, "Blog@destroy", $post->id))
                            <button type="submit" class="btn btn-xs btn-danger">
                                <i class="fa fa-trash"></i>
                            </button>
                        @else
                            <button type="button" onclick="return false;" class="btn btn-xs btn-danger disabled">
                                <i class="fa fa-trash"></i>
                            </button>
                        @endif
                    </div>
                    {!! Form::close() !!}
                </td>
                <td>
                    {{ $post->title }}
                </td>
                <td class="d-none d-md-table-cell d-lg-table-cell d-xl-table-cell">
                    {{ $post->author->name }}
                </td>
                <td class="d-none d-lg-table-cell d-xl-table-cell">
                    {{ $post->category->title }}
                </td>
                <td class="d-none d-lg-table-cell d-xl-table-cell">
                    {{ $post->view_count }}
                </td>
                <td class="d-none d-xl-table-cell">
                    {{ $post->comments->count() }}
                </td>
                <td class="d-none d-lg-table-cell d-xl-table-cell">
                    <abbr title="{{ $post->dateFormatted(true) }}">{{ $post->dateFormatted() }}</abbr> |
                    {!! $post->publicationLabel() !!}
                </td>
            </tr>

        @endforeach
    </tbody>
</table>
