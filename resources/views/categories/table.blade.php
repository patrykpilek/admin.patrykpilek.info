<table class="table table-bordered">
    <thead>
        <tr>
            <td width="80">Action</td>
            <td>Name</td>
            <td width="120">Post Count</td>
        </tr>
    </thead>
    <tbody>
        @foreach($categories as $category)
            <tr>
                <td>
                    {!! Form::open(['method' => 'DELETE', 'route' => ['categories.destroy', $category]]) !!}
                    <div class="btn-group">
                        <a href="{{ route('categories.edit', $category) }}" title="Edit" class="btn btn-xs btn-default">
                            <i class="fa fa-edit"></i>
                        </a>
                        @if($category->id == config('cms.default_category_id'))
                            <button onclick="return false" type="submit" class="btn btn-xs btn-danger disabled">
                                <i class="fa fa-times"></i>
                            </button>
                        @else
                            <button onclick="return confirm('Are you sure?');" type="submit" class="btn btn-xs btn-danger">
                                <i class="fa fa-times"></i>
                            </button>
                        @endif
                    </div>
                    {!! Form::close() !!}
                </td>
                <td>{{ $category->title }}</td>
                <td>{{ ($tmp = $category->posts) ? $tmp->count() : 0 }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
