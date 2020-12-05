<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Material_intro;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Material_pic;
use App\Material_product;
use App\Color;
use App\Footer;
use App\Link;
use App\HomeTitle;
class MaterialController extends Controller
{
    public function intro(){
        $data = Material_intro::all();
        $images = Material_pic::all();
        $product = Material_product::all();
        return view('material.material.intro')
        ->with('product', $product)
        ->with('data',$data)
        ->with('image', $images);
    }
    public function title_create(Request $request){
        $validator = Validator::make($request->all(), [
            'title'         => 'required'
        ]);
        if ($validator->fails()) {
             return back();
        }
        $title = new Material_intro();
        $title->title=$request->title;
        $title->save();
        return back();
    }
    public function destroy(Request $request){
        $title_id = $request->title_id;
        $data = Material_intro::find($title_id);
        $data->delete();
        return back();
    }
    public function pic_create(Request $request){  

        $validator = Validator::make($request->all(), [
            'pic_title'         => 'required',
            'pic_content'             => 'required', 
        ]);
        if ($validator->fails()) {
             return back();
        }
        $imageName = time().'.'.$request->image->extension();  
        $request->image->move(public_path('material/uploads/material'), $imageName);
        $book = new Material_pic();
        $book->pic_title = $request->pic_title;
        $book->pic_content = $request->pic_content;
        $book->file_name = $imageName;
        $book->save();
        return back();
    }
    public function pic_delete(Request $request){
        $pic_id = $request->pic_id;
        $data = Material_pic::find($pic_id);
        $data->delete();
        return back();
    }
    public function product_create(Request $request){
       
        $validator = Validator::make($request->all(), [
            'product_content'             => 'required', 
        ]);
        if ($validator->fails()) {
             return back();
        }
        $imageName = time().'.'.$request->product_image->extension();  
        $request->product_image->move(public_path('uploads/material'), $imageName);
        $book = new Material_product();
        $book->product_content = $request->product_content;
        $book->file_name = $imageName;
        $book->save();
        return back();
    }
    public function product_delete(Request $request){
        $pro_id = $request->pro_id;
        $data = Material_product::find($pro_id);
        $data->delete();
        return back();
    }
    public function usershow(){
        $link = Link::all();
        $footer = Footer::all()->first();
        $title = Material_intro::all();
        $pic = Material_pic::all();
        $product = Material_product::all();
        $color=Color::find(1);
        $mater=HomeTitle::find(1);
        return view('materialuser.material')
        ->with('title',$title)
        ->with('pic', $pic)
        ->with('color',$color)
        ->with('footer', $footer)
        ->with('link', $link)
        ->with('mater', $mater)
        ->with('product', $product);
    }
}
