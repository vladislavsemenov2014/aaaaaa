<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Color;
class ColorController extends Controller{
    public function index(){
        $color=Color::find(1);
        return view('material.color')->with('color',$color);
    }
    public function colorset(Request $request){
        $color= Color::find(1);
        $color->col1=$request->n1;
        $color->col2=$request->n2;
        $color->col3=$request->n3;
        $color->col4=$request->n4;
        $color->col5=$request->n5;
        $color->col6=$request->n6;
        $color->col7=$request->n7;
        $color->col8=$request->n8;
        $color->col9=$request->n9;
        $color->col10=$request->n10;
        $color->col11=$request->n11;
        $color->save();
        return back();
        
    }
    
}