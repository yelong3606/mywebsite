<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Category;
use App\Menu;
use App\Shop;

class MyController extends Controller
{
    /**
     * test
     *
     */
    public function index()
    {
        $this->import_category_menus(2);
    }

    private function import_category_menus($shop_id)
    {
        $shop = Shop::find($shop_id);
        if (!$shop) {
            exit('error shop id: ' . $shop_id);
        }

        echo "you are inserting categories and menus into <br>";
        echo "shop id: " . $shop->id . '<br>';
        echo "shop name: " . $shop->shop_name . '<br><br>';
        $c_count = Category::where('shop_id', $shop->id)->count();
        $m_count = Menu::where('shop_id', $shop->id)->count();
        if ($c_count > 0 || $m_count > 0) {
            exit('categories count: ' . $c_count . '<br>menus count: ' . $m_count . '<br>please delete the recoreds first!');
        }
        

        $filename = storage_path('tmp/shop.txt');
        $content = \file_get_contents($filename);
        $categories = json_decode(str_replace(array('price":"€', 'price":"+€'), 'price":"', $content));
        foreach ($categories as $index => $category) {
            $c = new Category();
            $c->shop_id = $shop->id;

            $c->category_name = $category->name;
            $c->category_desc = isset($category->description) ? $category->description : '';
            $c->category_order = $index;
            $c->save();
            echo "category inserted: " . $c->category_name . "<br>";

            foreach ($category->menus as $j => $menu) {
                $m = new Menu();
                $m->shop_id = $shop->id;
                $m->category_id = $c->id;
                $m->title = $menu->title;
                $m->description = isset($menu->description) ? $menu->description : '';
                $m->menu_order = $j;
                $m->price = $menu->price;
                $m->main_option = \json_encode($menu->variants);
                $m->side_options = \json_encode($menu->options);
                $m->save();
                echo "----menu inserted: " . $m->title . "<br>";
            }
            
        }
        
    }
}
/**
 * javascript
 */
// after run, copy the result to storage/tmp/shop.txt, then run {website}/manage/my to insert records, don't forget to change shop_id in MyController

// after run, copy the result to storage/tmp/shop.txt, then run {website}/manage/my to insert records, don't forget to change shop_id in MyController

// var categories = [];

// each category
// $("section.menuCard-category").each(function(index) {
//     var category = {};
//     category.name = $(this).find("h3.menuCard-category-title").html().trim();
//     category.description = $(this).find("div.menuCard-category-description").html();
//     category.menus = [];

//     // each menu
//     $(this).find("div.menu-product").each(function(index) {
//         var menu = {};
//         menu.title = $(this).find("h4.product-title").html().trim();
//         menu.description = $(this).find("div.product-description").html();
//         menu.price = 0;
//         menu.variants = [];

//         var hasVariants = $(this).hasClass("has-synonyms");
//         if (hasVariants) {
//             // each variant
//             $(this).find("div.product-synonym").each(function(index) {
//                 var variant = {};
//                 variant.name = $(this).find("div.product-synonym-name").html().trim();
//                 variant.price = $(this).find("div.product-price").html();
//                 menu.variants.push(variant);

//             });

//         } else {
//             menu.price = $(this).find("div.product-price").html();
//         }

//         // options
//         menu.options = [];

//         // open modal
//         var addButton = $(this).find("button.btn-addproduct")[0];
//         addButton.click();

//         $(".accessories-option").each(function(i){
//             // each option
//             var option = [];
//             $(this).find("div.accessory-name").each(function(j) {
//                 // each item
//                 var item = {};
//                 var el = $(this).find("div.box-grow-1");
//                 item.name = el.html();
//                 item.price = el.siblings().length > 0 ? el.siblings()[0].innerHTML : '0';
                
//                 option.push(item);
//             });
//             menu.options.push(option);
//         });

//         // close modal
//         $("div.accessories").find("div.modal-info-close").click();

//         category.menus.push(menu);
//     });

//     categories.push(category);

// });
// console.log(JSON.stringify(categories));