<?php

namespace App\Http\Controllers\View;

use App\Entity\Cart_item;
use App\Entity\Category;
use App\Entity\Pro_content;
use App\Entity\Pro_imgs;
use App\Entity\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Log;

class BookController extends Controller
{
     public function toCategory($value = ''){
         //打印日志
         Log::info('进入书籍类别');
         $categorys = Category::whereNull('parent_id')->get();//查找出来的是一级类别

         return view('category')->with('categorys',$categorys);
     }

    public function toProduct($category_id)
    {
        $products = Product::where('category_id', $category_id)->get();
        return view('product')->with('products', $products);
    }

    public function toProcontent(Request $request,$product_id){
        $product = Product::find($product_id);
        $pro_content = Pro_content::where('product_id',$product_id)->first();
        $pro_imgs= Pro_imgs::where('product_id',$product_id)->get();

        //从cookie中获取值
        //cookie只能获取字符串
        //cookie每个键值对存储的长度有限制
        $bk_cart = $request->cookie('bk_cart');//建议cookie的键和值命名一样，这样方便了以后查看代码易懂

        //return $bk_cart;//查看cookie

        //字符串拆分拆分成数组 第一个参数：以什么符号去拆分 参数2:要拆分的字符串
        $bk_cart_arr = ($bk_cart != null ? explode(',',$bk_cart) : array());

        //形式‘产品id’1:（数量）2
        $count = 0;

        $member = $request->session()->get('member', '');//获取用户数据
        //如果用户不为空
        if($member != '') {
            $cart_items = Cart_item::where('member_id', $member->id)->get();
            foreach ($cart_items as $cart_item) {
                if($cart_item->product_id == $product_id) {
                    $count = $cart_item->count;
                    break;
                }
            }
        }
        else {
            $bk_cart = $request->cookie('bk_cart');//获取购物车里的数据
            $bk_cart_arr = ($bk_cart != null ? explode(',', $bk_cart) : array());

            foreach ($bk_cart_arr as $value) {//这里不需要引用，因为直接传值就行了
                //获取冒号的索引
                //strops（获取的字符串，索引的字符串）；
                $index = strpos($value, ':');//找出冒号在这段字符串中的位置
                //substr()截取字符串 得到的结果是冒号左边的值也就是产品的id
                if (substr($value, 0, $index) == $product_id) {
                    $count = (int)substr($value, $index + 1);//获取冒号右边的数
                    break;
                }
            }
        }
        return view('pro_content')->with('product', $product)
                                       ->with('pro_content',$pro_content)
                                       ->with('pro_imgs',$pro_imgs)
                                        ->with('count',$count);
    }

}
