@foreach($menus as $category_id => $cate_menus)
<div class="card mb-2" id="category{{$category_id}}">
    <div class="card-body">
    <div class="card-title">{!!$categories[$category_id]!!}</div>
    <table class="table table-bordered table-striped table-sm">
        @foreach ($cate_menus as $menu)
        @php
            $variants = json_decode($menu->main_option);
            $has_variants = count($variants) >= 2;
        @endphp
        <tr>
            <td class="col-8">
                <a
                    href="{{ route($route_prefix . 'menus.edit', ['shop' => $shop->id, 'menu' => $menu->id]) }}">{!!$menu->title!!}
                </a>
                @if (!$has_variants)
                    <span class="float-right">€{{$menu->price}}</span>
                @endif
                {{-- <p class="description" style="display:none"><small>{!!$menu->description!!}</small></p> --}}
                @if ($has_variants)
                    @foreach ($variants as $variant)
                        <p>
                            <strong>{!!$variant->name!!}</strong>
                            <span class="float-right">€{{$variant->price}}</span>
                        </p>
                    @endforeach
                @endif
            </td>
            <td class="col-2">
                <div class="btn-group">
                    <a class="btn btn-outline-secondary btn-sm"
                        href="{{ route($route_prefix . 'menus.edit', ['shop' => $shop->id, 'menu' => $menu->id]) }}">Edit</a>

                    <form
                        action="{{ route($route_prefix . 'menus.destroy', ['shop' => $shop->id, 'menu' => $menu->id]) }}"
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
</div>
</div>
@endforeach