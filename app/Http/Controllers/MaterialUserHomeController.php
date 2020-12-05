<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\HomeTitle;
use App\Image;
use App\Color;
use App\Footer;
use App\Link;

class MaterialUserHomeController extends Controller
{
    public function index(){
        $link = Link::all();
        $images = Image::all();
        $title = HomeTitle::find(1);
        $color = Color::find(1);
        $slide = 0;
        $footer = Footer::all()->first();
        return view('materialuser.home')
        ->with('images',  $images)
        ->with('title', $title)
        ->with('footer',$footer)
        ->with('link', $link)
        ->with('slide', $slide)->with('color', $color);
    }
}
