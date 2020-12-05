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
use App\Footer;
use App\Link;
class UrllinkController extends Controller
{
    public function index(){
        $link = Link::all();
        return view('material.url_link')
        ->with('link',$link);
    }
    public function upload(Request $request){
        $validator = Validator::make($request->all(), [
            'link_id'         => 'required',
            'link_url'             => 'required', 
        ]);
        if ($validator->fails()) {
             return back();
        }
        $imageName = time().'.'.$request->link_id->extension();  
        $request->link_id->move(public_path('material/uploads/material'), $imageName);
        $url_link = new Link();
        $url_link->link_url = $request->link_url;
        $url_link->link_id = $imageName;
        $url_link->save();
        return back();
    }
    public function destroy(Request $request){
        $link_del = Link::find($request->title_id);
        $link_del->delete();
        return back();
    }

}
