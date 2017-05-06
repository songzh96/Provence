<?php
/**
 * Created by PhpStorm.
 * User: Miracle
 * Date: 2017/4/17
 * Time: 20:43
 */
namespace App\Http\Controllers\Admin;

use App\Entity\Category;
use App\Http\Controllers\Controller;
use App\Models\M3Result;
use Illuminate\Http\Request;


//后台查询产品控制器
//和数据库交互进行增删改
class CategoryController extends Controller
{

    public function toCategory(){
        //查询数据
        $categories = Category::all();
        foreach ($categories as $category){
            if($category->parent_id !=null && $category->parent_id != ''){
                $category->parent = Category::find($category->parent_id);//将查找出来赋值给$categroy->parent 然后在前端调用显示
            }
        }
        return view('admin.category')->with('categories',$categories);
    }

    public function toCategoryAdd(){
        $categories = Category::whereNull('parent_id')->get();
        return view('admin.category_add')->with('categories',$categories);
    }

    public function toCategoryEdit(Request $request){
        $id = $request->input('id','');
        $category = Category::find($id);
        $categories = Category::whereNull('parent_id')->get();

        return view('admin.category_edit')->with('category',$category)
                                                ->with('categories',$categories);
    }

//          *******************Service***************************
    public function CategoryAdd(Request $request){
        $name = $request->input('name','');
        $category_no  = $request->input('category_no','');
        $parent_id = $request->input('parent_id','');
        $preview = $request->input('preview','');

        $category = new Category();
        $category->name = $name;
        $category->category_no = $category_no;
        $category->preview = $preview;
        if($parent_id != ''){
            $category->parent_id = $parent_id;
        }
        $category->save();

        $m3result = new M3Result();
        $m3result->status = 0;
        $m3result->message = "添加成功";
        return $m3result->toJson();
    }

    public function CategoryDelete(Request $request){
        $id = $request->input('id','');
        Category::find($id)->delete();

        $m3result = new M3Result();
        $m3result->status = 0 ;
        $m3result->message ="删除成功";
        return $m3result->toJson();
    }

    public function categoryEdit(Request $request) {
        $id = $request->input('id', '');
        $category = Category::find($id);

        $name = $request->input('name', '');
        $category_no = $request->input('category_no', '');
        $parent_id = $request->input('parent_id', '');
        $preview = $request->input('preview', '');


        $category->name = $name;
        $category->category_no = $category_no;
        if($parent_id != '') {
            $category->parent_id = $parent_id;
        }
        $category->preview = $preview;
        $category->save();

        $m3_result = new M3Result;
        $m3_result->status = 0;
        $m3_result->message = '修改成功';

        return $m3_result->toJson();
    }

}