<?php

namespace App\Http\Controllers\Shop;

use Illuminate\Http\Request;
use App\Menu;
use App\Category;
use App\Cart;
use App\Delivery;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::where('shop_id', $this->shop()->id)
            ->orderBy('category_order', 'asc')
            ->get();
        $indexedCategories = array();
        foreach ($categories as $category) {
            $indexedCategories[$category->id] = $category;
        }
        $menus = Menu::where('shop_id', $this->shop()->id)
            ->orderBy('menu_order', 'asc')
            ->get();
        $indexedMenus = array();
        foreach ($menus as $menu) {
            if (isset($indexedCategories[$menu->category_id])) {
                $indexedMenus[$menu->category_id][] = $menu;
            } else {
                // not belong to any category
                $indexedMenus[0][] = $menu;
            }
        }

        if (isset($indexedMenus[0])) {
            $indexedCategories[0] = 'Others';
        }

        $carts = Cart::where('session_id', session()->getId())
            ->orderBy('title', 'asc')
            ->get();

        $deliveries = Delivery::where('shop_id', $this->shop()->id)->get();

        return view('shop.home.index')
            ->with('categories', $indexedCategories)
            ->with('menus', $indexedMenus)
            ->with('carts', $carts)
            ->with('subtotal', $this->subtotal())
            ->with('deliveries', $deliveries);
    }

    /**
     * @return  false
     *          type=options, data={id,title,description,side_options}
     *          type=add, data={tr:'', subtotal:''}
     *          type=update, data={id:'', quantity:''}
     */
    public function addtocart(Request $request) {
        // init data
        $data = [];

        // input
        $menu_id = $request->input('menu_id');
        $variant = $request->input('variant');
        $options = $request->input('options');

        // check id: menu exists
        $menu = Menu::find($menu_id);
        if (!$menu || $menu['shop_id'] != $this->shop()->id) {
            return $this->ajax_result(false, 'menu(#' . $menu_id . ') not found');
        }
        $data['menu_id'] = $menu->id;
        $data['title'] = $menu->title;

        // check variant
        $menu_variants = json_decode($menu->main_option);
        if (count($menu_variants) > 0) {
            // has variants
            if ($variant == '') {
                return $this->ajax_result(false, 'variant required');
            }
            $found = false;
            foreach ($menu_variants as $v) {
                if ($v->name == $variant) {
                    $found = true;

                    $data['title'] .= ", " . $variant;
                    $data['price'] = $v->price;
                    break;
                }
            }
            if (!$found) {
                return $this->ajax_result(false, 'variant(' . $variant . ') not found');
            }
            
        } else {
            // no variants
            $data['price'] = $menu->price;
        }
        $data['base_price'] = $data['price'];
    
        // check options
        $data['options'] = [];
        $menu_options = json_decode($menu->side_options);
        if (count($menu_options) > 0) {
            // has options
            if (!is_array($options) || count($options) != count($menu_options)) {
                return $this->ajax_result('options', '', 
                    view('shop.home.options')->with('menu', $menu)->with('variant', $variant)->render());
            }

            $match_all = true;
            foreach ($menu_options as $k=>$mo) {
                $match_one = false;
                foreach ($mo as $o) {
                    if ($o->name == $options[$k]) {
                        $match_one = true;

                        $data['price'] += $o->price;
                        $data['options'][] = [
                            'name' => $o->name,
                            'price' => $o->price
                        ];
                        break;
                    }
                }
                if (!$match_one) {
                    $match_all = false;
                    break;
                }
            }

            if (!$match_all) {
                return $this->ajax_result(1, 'options(' . implode('|', $options) . ') not all match');
            }
        }

        // add to cart
        $cart = new Cart();
        $cart->session_id = session()->getId();
        $cart->menu_id = $data['menu_id'];
        $cart->title = $data['title'];
        $cart->base_price = $data['base_price'];
        $cart->price = $data['price'];
        $cart->quantity = 1;
        $cart->options = json_encode($data['options']);
        $cart->save();

        return $this->ajax_result('add', '', [
            'tr' => view('shop.home.cartrow')->with('cart', $cart)->render(),
            'subtotal' => $this->subtotal()
        ]);
    }

    /**
     * @return  type=false
     *          type=update,data={tr:'', subtotal:''}
     *          type=remove,data={subtotal:''}
     */
    public function removefromcart(Request $request)
    {
        $id = $request->input('id');
        $cart = Cart::find($id);
        if (!$cart) {
            return $this->ajax_result(false, 'cart(#' . $id . ') not found');
        }

        if ($cart->quantity > 1) {
            $cart->quantity = $cart->quantity - 1;
            $cart->save();
            return $this->ajax_result('update', '', [
                'tr' => view('shop.home.cartrow')->with('cart', $cart)->render(),
                'subtotal' => $this->subtotal()
            ]);
        } else {
            $cart->delete();
            return $this->ajax_result('remove', '', [
                'subtotal' => $this->subtotal()
            ]);
        }
    }

    private function subtotal()
    {
        return Cart::where('session_id', session()->getId())->sum(DB::raw('price*quantity'));
    }

    /**
     * @param bool $result
     * @param string $msessage
     * @param mix $data
     * @return json
     */
    private function ajax_result($result, $message = '', $data = null) 
    {
        return json_encode([
            'type' => $result,
            'message' => $message,
            'data' => $data
        ]);
    }
}
