@if ($categories->count() > 0)
<table class="table table-striped table-sm">
    <caption>List of Categories, sorted by "Display Order"</caption>
    <thead>
        <tr>
            <th>#</th>
            <th>Category Name</th>
            <th>Display Order</th>
            <th></th>
        </tr>
    </thead>
    @foreach($categories as $category)
    <tr>
        <td>{{$category->id}}</td>
        <td><a
                href="{{ route($route_prefix . 'edit', ['shop' => $shop->id, 'category' => $category->id]) }}">{{$category->category_name}}</a>
                <small>{!! $category->category_desc !!}</small>
        </td>
        <td>{{$category->category_order}}</td>
        <td>
            <div class="btn-group">
                <a class="btn btn-outline-secondary btn-sm" href="{{ route($route_prefix . 'edit', ['shop' => $shop->id, 'category' => $category->id]) }}">Edit</a>

                <form action="{{ route($route_prefix . 'destroy', ['shop' => $shop->id, 'category' => $category->id]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?');">Delete</button>
                </form>
            </div>
        </td>
    </tr>
    @endforeach
</table>
@else
<p>No Categories Found</p>
@endif