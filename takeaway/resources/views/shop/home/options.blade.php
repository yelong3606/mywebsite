<h5>{!!$menu->title!!}</h5>
@foreach(json_decode($menu->side_options) as $options)
<label for="">Choose one from option {{$loop->iteration}}</label>
<select class="form-control" size="{{count($options)}}">
    @foreach($options as $o)
    <option value="{{$o->name}}" @if($loop->first) selected @endif>{!!$o->name!!}@if($o->price > 0)(+{{$o->price}})@endif</option>
    @endforeach
</select>
@endforeach
<input type="hidden" name="menu_id" value="{{$menu->id}}">
<input type="hidden" name="variant" value="{{$variant}}">
<button class="btn btn-primary btn-sm" onclick="addOptions(this);">Add To Cart</button>