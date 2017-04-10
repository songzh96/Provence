<?php

namespace App\Http\Controllers\View;

use App\Entity\Category;
use App\Entity\Product;
use App\Http\Controllers\Controller;
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
}
