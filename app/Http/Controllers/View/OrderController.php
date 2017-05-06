<?php

namespace App\Http\Controllers\View;

use App\Entity\Cart_item;
use App\Entity\Category;
use App\Entity\Order;
use App\Entity\Order_item;
use App\Entity\Pro_content;
use App\Entity\Pro_imgs;
use App\Entity\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Log;

class OrderController extends Controller //订单信息处理控制器
{
    public function toOrderCommit(Request $request){

        $product_ids = $request->input('product_ids','');
        $product_ids_arr = ($product_ids != '' ? explode(',',$product_ids):array());//将字符串转换成数组
        //获取登录信息
        $member = $request->session()->get('member','');
        //先查询会员id 然后再查询产品id 如果存在列出列表
        $cart_items = Cart_item::where('member_id',$member->id)->whereIn('product_id',$product_ids_arr)->get();

        $cart_items_arr = array();
        $total_price = 0;
        $name = '';//产品名
        $order = new Order();
        $order->member_id = $member->id;
        $order->save();
        //遍历查询到的产品信息 并为其赋值产品属性，这只是为了视图使用
        foreach ($cart_items as $cart_item){
            $cart_item->product = Product::find($cart_item->product_id);
            //判断产品id是否存在
            if ($cart_item->product != null){
                //计算价格
                $total_price += $cart_item->product->price * $cart_item->count;
                $name .= ('《' . $cart_item->product->name.'》');//获取数据表中得书名，注意字符串链接使用得符号
                //如果存在将产品push到数组当中
                array_push($cart_items_arr,$cart_item);
                $order_item = new Order_item();
                $order_item->order_id = $order->id;
                $order_item->product_id = $cart_item->product_id;
                $order_item->count = $cart_item->count;
                $order_item->pro_snapshot = json_encode($cart_item->product);
                $order_item->save();//将order——item保存到数据库中
            }
        }
        //删除购物车中得数据  因为此时购物车中得数据已经生成了订单数据
        Cart_item::where('member_id',$member->id)->delete();

        $order->name =  $name;
        $order->total_price = $total_price;
        $order->order_no = 'E'.time().$order->id;//生成订单号
        $order->save();

        return view('order_commit')->with('cart_items',$cart_items_arr)
                                        ->with('total_price',$total_price)
                                        ->with('name',$name)
                                        ->with('order_no',$order->order_no);
    }

    public function toOrderList(Request $request){
        $member = $request->session()->get('member','');//获取session中的用户信息
        $orders = Order::where('member_id',$member->id)->get();//根据用户信息查找订单表
        foreach ($orders  as $order){
            //遍历结果
            //order信息
            //order——item-x
            //product-x
            //order——item-y
            //product-y
            $order_items = Order_item::where('order_id',$order->id)->get();//根据订单表查找订单信息
            $order->order_items = $order_items;
            foreach ($order_items as $order_item){
                $order_item->product = Product::find($order_item->product_id);
            }
        }
        return view('order_list')->with('orders',$orders);
    }

}
