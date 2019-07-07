@extends('layouts.shop')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="d-none d-lg-block col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">Categories</div>
                    <ul class="list-group list-group-flush">
                        @foreach($menus as $category_id => $cate_menus)
                        <li class="list-group-item">
                            <a href="#category{{$category_id}}">
                                {!!$categories[$category_id]->category_name!!}

                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>

            </div>
        </div>
        <div class="col-lg-6 col-md-8">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                        aria-controls="home" aria-selected="true">Menus</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                        aria-controls="profile" aria-selected="false">Info</a>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    @foreach($menus as $category_id => $cate_menus)
                    @php
                    $category = $categories[$category_id];
                    @endphp
                    <div class="card border-primary mt-2" id="category{{$category_id}}">
                        <div class="card-body">
                            <h4 class="card-title">{!!$category->category_name!!}</h4>
                            <p class="card-text">{!!$category->category_desc!!}</p>
                            <ul class="list-group">
                                @foreach ($cate_menus as $menu)
                                @php
                                $variants = json_decode($menu->main_option);
                                $has_variants = count($variants) >= 2;
                                @endphp
                                <li class="list-group-item">
                                    <div class="clearfix">
                                        <h5 class="d-inline-flex">{!!$menu->title!!}</h5>
                                        @if (!$has_variants)
                                        <span class="float-right">€{{$menu->price}}
                                            <button class="btn btn-primary btn-sm"
                                                onclick="addToCart({{$menu->id}});">+</button></span>
                                        @endif
                                    </div>
                                    <p>{!!$menu->description!!}</p>
                                    @if ($has_variants)
                                    @foreach ($variants as $variant)
                                    <div class="clearfix">
                                        <strong>{!!$variant->name!!}</strong>
                                        <span class="float-right">
                                            €{{$variant->price}}
                                            <button class="btn btn-primary btn-sm"
                                                onclick="addToCart({{$menu->id}}, '{!!$variant->name!!}');">+</button>
                                        </span>
                                    </div>
                                    @endforeach
                                    @endif
                                </li>
                            </ul>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="tab-pane" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="card mt-2">
                        <div class="card-body">
                            <h3 class="card-title">About {{$shop->title}}</h3>
                            <div class="cart-text">{!!$shop->description!!}</div>
                            <div class="row mt-3">
                                <div class="col">
                                    <h3>Opening hours</h3>
                                    <table class="table table-sm">
                                        @php
                                        $hours = json_decode($shop->opening_hours);
                                        @endphp
                                        <tr>
                                            <td>Monday</td>
                                            <td class="text-right">{{$hours->Monday->from}} - {{$hours->Monday->to}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Tuesday</td>
                                            <td class="text-right">{{$hours->Tuesday->from}} - {{$hours->Tuesday->to}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Wednesday</td>
                                            <td class="text-right">{{$hours->Wednesday->from}} - {{$hours->Wednesday->to}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Thursday</td>
                                            <td class="text-right">{{$hours->Thursday->from}} - {{$hours->Thursday->to}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Friday</td>
                                            <td class="text-right">{{$hours->Friday->from}} - {{$hours->Friday->to}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Saturday</td>
                                            <td class="text-right">{{$hours->Saturday->from}} - {{$hours->Saturday->to}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Sunday</td>
                                            <td class="text-right">{{$hours->Sunday->from}} - {{$hours->Sunday->to}}
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col">
                                    <h3>Delivery areas</h3>
                                    <table class="table table-sm">
                                        <tr>
                                            <th>Area</th>
                                            <th>Minimum</th>
                                            <th>Delivery</th>
                                        </tr>
                                        @foreach ($deliveries as $d)
                                        <tr>
                                            <td>{{$d->region_name}}</td>
                                            <td>€{{$d->minimum}}</td>
                                            <td>€{{$d->delivery}}</td>
                                        </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </div>
        <div class="col-lg-3 col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="card-title border-bottom">Cart</div>
                    <table id="cart" class="table table-sm table-borderless">
                        <tbody>
                            @foreach($carts as $cart)
                            @include('shop.home.cartrow')
                            @endforeach
                        </tbody>
                        <tfoot class="border-top">
                            <tr>
                                <td></td>
                                <td>Subtotal</td>
                                <td id="subtotal" class="text-right">€{{$subtotal}}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content p-3">
            ...
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });
    
    /**
     * @param int menuId
     * @param String variant
     * @param array options
     */
    function addToCart(menuId, variant = '', options = []) {
        $.post('/addtocart', {menu_id:menuId, variant:variant, options:options}).done(function(data) {
            var result = JSON.parse(data);
            switch (result.type) {
                case false:
                    alert(result.message);
                    break;
                case 'add':
                    $('#cart').find('tbody').append(result.data.tr);
                    $('#subtotal').html(result.data.subtotal);
                    break;
                case 'options':
                    $('#myModal').find('.modal-content').html(result.data);
                    $('#myModal').modal([]);
                    break;
                default:
                    break;
            }
        });
    }

    /**
     * 
     */
    function removeFromCart(id) {
        $.post('/removefromcart', {id:id}).done(function(data) {
            var result = JSON.parse(data);
            switch (result.type) {
                case false:
                    alert(result.message);
                    break;
                // case 'update':
                //     $('#cart-' + id).replaceWith(result.data.tr);
                //     $('#subtotal').html('€' + result.data.subtotal);
                //     break;
                case 'remove':
                    $('.cart-' + id).remove();
                    $('#subtotal').html('€' + result.data.subtotal);
                default:
                    break;
            }
        });
    }

    function addOptions(btn) {
        var menu_id = $(btn).siblings('[name=menu_id]').val();
        var variant = $(btn).siblings('[name=variant]').val();
        var options = [];
        $(btn).parents('.modal-content').find('select').each(function(index, elem) {
            options.push(elem.value);
        });
        $('#myModal').modal('hide');
        addToCart(menu_id, variant, options);
    }
</script>
@endsection