<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\HomeTitle;
use App\Image;
use App\Color;

class MaterialHomeController extends Controller
{
    public function index(){
        $images = Image::all();
        $title = HomeTitle::find(1);
        $color= Color::find(1);
        return view('material.home')
        ->with('images',  $images)
        ->with('title', $title)
        ->with('color', $color);
    }
    public function delete(Request $request)
    {
        $image=Image::find($request['id']);
        $image->delete();
        $images = Image::all();
        $title = HomeTitle::find(1);
        return view('material.home')->with('images',  $images)->with('title', $title);
    }
    public function store(Request $request){
        $title = HomeTitle::find(1);
        $title->hometitle=$request['intro'];
        $title->kichen=$request['kichen'];
        $title->title=$request['title'];
        $title->small=$request['small'];
        $title->contact=$request['contact'];
        $title->materialt=$request['materialt'];
        $title->materiall=$request['materiall'];
        $title->changetitle=$request['changetitle'];
        $title->write = $request['write'];
        $title->visit = $request['visit'];
        $title->save();
        return back();
    }
    public function upload(){
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
        }
        }

        

        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 5000000) {
        $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
        // if everything is ok, try to upload file
        } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                $image= new Image;
                $image->imageName=$target_file;
                $image->save();
                $images = Image::all();
                $title = HomeTitle::find(1);
                return back();
        } else {
            return back();
        }
        }

        
    }
}
