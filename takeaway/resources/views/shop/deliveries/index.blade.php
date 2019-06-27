@if ($deliveries->count() > 0)
<table class="table table-striped table-sm">
    <thead>
        <tr>
            <th>#</th>
            <th>Region</th>
            <th class="text-right">Minimum Order Amount</th>
            <th class="text-right">Delivery Fee</th>
            <th></th>
        </tr>
    </thead>
    @foreach($deliveries as $delivery)
    <tr>
        <td>{{$delivery->id}}</td>
        <td>
            <a
                href="{{ route($route_prefix . 'deliveries.edit', ['shop' => $shop->id, 'delivery' => $delivery->id]) }}">{{$delivery->region_name}}</a>
        </td>
        <td class="text-right">{{$delivery->minimum}}</td>
        <td class="text-right">{{$delivery->delivery}}</td>
        <td>
            <div class="btn-group">
                <a class="btn btn-outline-secondary btn-sm"
                    href="{{ route($route_prefix . 'deliveries.edit', ['shop' => $shop->id, 'delivery' => $delivery->id]) }}">Edit</a>

                <form
                    action="{{ route($route_prefix . 'deliveries.destroy', ['shop' => $shop->id, 'delivery' => $delivery->id]) }}"
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
<p>No Delivery Areas Found</p>
@endif