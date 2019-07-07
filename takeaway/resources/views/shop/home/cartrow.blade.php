<tr class="cart-{{$cart->id}}">
    <td><button class="btn btn-secondary btn-sm" onclick="removeFromCart({{$cart->id}});">-</button></td>
    <td>{!!$cart->title!!}</td>
    <td class="text-right">€{{number_format($cart->base_price, 2)}}</td>
</tr>
@foreach (json_decode($cart->options) as $o)
<tr class="cart-{{$cart->id}}">
    <td></td>
    <td>{!!$o->name!!}</td>
    <td class="text-right">{{$o->price > 0 ? '+€' . number_format($o->price, 2) : ''}}</td>
</tr>
@endforeach