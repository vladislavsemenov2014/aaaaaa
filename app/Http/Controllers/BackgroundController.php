<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Footer;
use App\Material_product;

class BackgroundController extends Controller
{
    public function index(){
        $footer = Footer::all()->first();
        return view('material.background')
        ->with('footer', $footer);
    }
    public function footer(Request $request){
        
        $footer = Footer::first();
        if($request->hasFile('footer')){
            $imageName1 = time().'fir.'.$request->file('footer')->extension();  
            $request->file('footer')->move(public_path('material/uploads/material'), $imageName1);
            $footer->file_name = $imageName1;
        }
        if($request->hasFile('homebutton')){
            $imageName2 = time().'sec.'.$request->homebutton->extension();  
            $request->homebutton->move(public_path('material/uploads/material'), $imageName2);
            $footer->homebutton = $imageName2;
        }
        if($request->hasFile('home')){
            $imageName3 = time().'thi.'.$request->file('home')->extension();  
            $request->file('home')->move(public_path('material/uploads/material'), $imageName3);
            $footer->home_image = $imageName3;
        }
        if($request->hasFile('title')){
            $imageName3 = time().'thi.'.$request->file('title')->extension();  
            $request->file('title')->move(public_path('material/uploads/material'), $imageName3);
            $footer->title_image = $imageName3;
        }
        $footer->save();
        return back();
    }
    public function productChange($id){
        // $data = $request->data;
        // $title = $data['title'];
        // $returnHTML = view('materialuser.product');
        // return response()->json( array('success' => true, 'html'=>$returnHTML) );
        // return $title; exit();
        // $data = [];
        // $data = $img;
        // $data = $title;
        $product = Material_product::findorFail($id);
        return view('materialuser.products', compact('product'));
        // return view('materialuser.products',compact('img'));
        // return view('materialuser.products')->with('img', $img);;
        // return view('admin/coloris');
        // $img = $data['img'];
        // // return $img;
        // exit();
        // return redirect('admin/coloris')->with('success','Coloris added successfully');
       
        }
}
