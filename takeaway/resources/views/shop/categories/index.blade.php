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
        <td class="w-75">
            <a
                href="{{ route($route_prefix . 'categories.edit', ['shop' => $shop->id, 'category' => $category->id]) }}">{{$category->category_name}}</a>
            <p><small class="description">{!! $category->category_desc !!}</small></p>
        </td>
        <td>{{$category->category_order}}</td>
        <td>
            <div class="btn-group">
                <a class="btn btn-outline-secondary btn-sm"
                    href="{{ route($route_prefix . 'categories.edit', ['shop' => $shop->id, 'category' => $category->id]) }}">Edit</a>

                <form
                    action="{{ route($route_prefix . 'categories.destroy', ['shop' => $shop->id, 'category' => $category->id]) }}"
                    method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger"
                        onclick="return confirm('Are you sure?');">Delete</button>
                </form>
            </div>
        </td>
    </tr>
    @endforeach
</table>
@else
<p>No Categories Found</p>
@endif