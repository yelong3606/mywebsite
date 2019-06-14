@if ($options->count() > 0)
<table class="table table-striped table-sm">
    <thead>
        <tr>
            <th>#</th>
            <th>Option Name</th>
            <th>Option Values</th>
            <th></th>
        </tr>
    </thead>
    @foreach($options as $option)
    <tr>
        <td>{{$option->id}}</td>
        <td>
            <a href="{{ route($route_prefix . 'options.edit', ['shop' => $shop->id, 'option' => $option->id]) }}">{{$option->option_name}}</a>
        </td>
        <td>
            @php
                echo str_replace(["\r\n", "\n", "\r"], '<br />', $option->option_values) ;
            @endphp
        </td>
        <td>
            <div class="btn-group">
                <a class="btn btn-outline-secondary btn-sm"
                    href="{{ route($route_prefix . 'options.edit', ['shop' => $shop->id, 'option' => $option->id]) }}">Edit</a>

                <form
                    action="{{ route($route_prefix . 'options.destroy', ['shop' => $shop->id, 'option' => $option->id]) }}"
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
<p>No Menu Options Found</p>
@endif