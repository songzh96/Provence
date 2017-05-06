<?php

namespace App\Http\Controllers\Service;

use App\Entity\Cart_item;
use App\Entity\Product;
use App\Http\Controllers\Controller;

use App\Models\M3Result;
use Illuminate\Http\Request;

class CartController extends Controller
{
    //购物车处理
    //添加至购物车
 public function addCart(Request $request,$product_id){

     $m3_result = new M3Result();
     $m3_result->status = 0;
     $m3_result->message = '添加成功';

     //如果当前已经登录
     $member = $request->session()->get('member','');
     if($member != ''){//如果用户不为空
        $cart_items = Cart_item::where('member_id',$member->id)->get();//更新数据库

         $exist = false; //设置标志位 循环遍历判断本地购物车是否存在购物车中
         foreach ($cart_items as $cart_item){
             if ($cart_item->product_id == $product_id){
                 $cart_item->count++;
                 $cart_item->save();
                 $exist=true;
                 break;
             }
         }

         if($exist == false){
             $cart_item = new Cart_item();
             $cart_item->product_id = $product_id;
             $cart_item->count = 1;
             $cart_item->member_id = $member->id;
             $cart_item->save();
         }

         return $m3_result->toJson();
     }

     //从cookie中获取值
     //cookie只能获取字符串
     //cookie每个键值对存储的长度有限制
     $bk_cart = $request->cookie('bk_cart');//建议cookie的键和值命名一样，这样方便了以后查看代码易懂

     //return $bk_cart;//查看cookie

     //字符串拆分拆分成数组 第一个参数：以什么符号去拆分 参数2:要拆分的字符串
     $bk_cart_arr = ($bk_cart != null ? explode(',',$bk_cart) : array());

     //形式‘产品id’1:（数量）2
     $count = 1;
     foreach ($bk_cart_arr as &$value){//如果$value是基本类型的话一定要传引用 $bk_cart_arr是基本类型数组并不是对象数组
         //获取冒号的索引
         //strops（获取的字符串，索引的字符串）；
         $index = strpos($value,':');//找出冒号在这段字符串中的位置
         //substr()截取字符串 得到的结果是冒号左边的值也就是产品的id
         if (substr($value,0,$index) == $product_id){
             $count = ((int) substr($value,$index+1))+1;//获取冒号右边的数
             $value = $product_id . ':' . $count;//改变value 就是1：2的形式
             break;
         }
     }

     //新产品处理
     if($count == 1){
         array_push($bk_cart_arr,$product_id . ':' .$count);
     }

     //这里需要将cookie的字符串重新写入进去   第一个参数是要链接数组的字符，第二个参数是数组
     return response($m3_result->toJson())->withCookie('bk_cart',implode(',',$bk_cart_arr));
     }

     public function deleteCart(Request $request){
          $m3_result = new M3Result();
          $m3_result->status = 0;
          $m3_result->message = '删除成功';
        //获取前端ajax传来的数据
         $product_ids = $request->input('product_ids','');
         //出错处理
         if ($product_ids == ''){
             $m3_result->status = 1;
             $m3_result->message = '书籍ID为空';
             return $m3_result->toJson();
         }
         //正确处理
         //字符串分割
         $product_ids_arr = explode(',',$product_ids);

         $member = $request->session()->get('member', '');
         if($member != '') {
             // 已登录
             Cart_item::whereIn('product_id', $product_ids_arr)->delete();
             return $m3_result->toJson();
         }

         $product_ids = $request->input('product_ids', '');
         if($product_ids == '') {
             $m3_result->status = 1;
             $m3_result->message = '书籍ID为空';
             return $m3_result->toJson();
         }

         // 未登录
         $bk_cart = $request->cookie('bk_cart');
         $bk_cart_arr = ($bk_cart!=null ? explode(',', $bk_cart) : array());
         foreach ($bk_cart_arr as $key => $value) {
             $index = strpos($value, ':');
             $product_id = substr($value, 0, $index);
             // 存在, 删除
             if(in_array($product_id, $product_ids_arr)) {
                 array_splice($bk_cart_arr, $key, 1);
                 continue;
             }
         }
        //将$bk_cart_arr存入cookie并返回视图
         return response($m3_result->toJson())->withCookie('bk_cart', implode(',', $bk_cart_arr));
     }

}
