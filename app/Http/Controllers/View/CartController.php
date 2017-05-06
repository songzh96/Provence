<?php

namespace App\Http\Controllers\View;


use App\Entity\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Entity\Cart_item;

class CartController extends Controller
{

        public function toCart(Request $request){

            $cart_items = array();

            $bk_cart = $request->cookie('bk_cart');
                $bk_cart_arr = ($bk_cart != null ? explode(',',$bk_cart) : array());

            //判断用户是否登录
            $member = $request->session()->get('member','');
            if ($member != ''){
                //不为空 同步购物车
                $cart_items = $this->syncCart($member->id,$bk_cart_arr);

                //返回一个携带参数的视图 并清空cookie
                return response()->view('cart',['cart_items'=>$cart_items])->withCookie('bk_cart',null);
            }
            //为防止购物车删除后再刷新报错，这里需要将每一次foreach遍历的结果放在一个数组里面
            foreach ($bk_cart_arr as $key => $value){
                $index = strpos($value,':');
                $cart_item = new Cart_item();
                $cart_item->id = $key;
                $cart_item->product_id = substr($value,0,$index);
                $cart_item->count = (int)substr($value,$index+1);
                $cart_item->product = Product::find($cart_item->product_id);

                //判断产品是否查出来
                if ($cart_item->product != null){
                    //将查询的产品放到数组中
                    array_push($cart_items,$cart_item);
                }
            }
                return view('cart')->with('cart_items',$cart_items);

            }

            //同步购物车
            public function syncCart($member_id,$bk_cart_arr){
                $cart_items = Cart_item::where('member_id',$member_id)->get();//查询数据表中的购物车
                //购物车中的product_id和本地的product_id进行比较
                //当本地有，服务器没有 需要将本地product写入到服务器的product购物车中

                $cart_items_arr = array();

                //遍历循环本地的购物车
                foreach ($bk_cart_arr as $value){
                    $index = strpos($value,':');
                    $product_id = substr($value,0,$index);
                    $count = (int)substr($value,$index+1);

                    //判断离线购物车中product_id是否存在数据库中
                    $exist = false; //设置标志位 循环遍历判断本地购物车是否存在购物车中
                    foreach ($cart_items as $temp){
                        if ($temp->product_id == $product_id){
                            if($temp->count < $count){
                                $temp->count = $count;
                                $temp->save();
                            }
                            $exist=true;
                            break;
                        }
                    }

                    //如果不存在则存储进来
                    if($exist == false){
                         $cart_item = new Cart_item();
                         $cart_item->member_id = $member_id;
                         $cart_item->product_id = $product_id;
                         $cart_item->count = $count;
                         $cart_item->save();
                         $cart_item->product = Product::find($cart_item->product_id);
                         array_push($cart_items_arr,$cart_item);
                    }
                }

                //为每个对象附加产品对象便于显示
                foreach ($cart_items as $cart_item){
                    $cart_item->product = Product::find($cart_item->product_id);
                    array_push($cart_items_arr,$cart_item);
                }
                return $cart_items_arr;
            }



}


