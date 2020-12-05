<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Contact;
use App\Color;
use App\Footer;
use App\HomeTitle;
use App\Link;

class ContactController extends Controller
{
    public function index(){
        $footer = Footer::all()->first();
        $link = Link::all();
        $message = Contact::all();
        $color=Color::find(1);
        $title=HomeTitle::find(1);
        return view('materialuser.contact')
        ->with('footer', $footer)
        ->with('title',$title)
        ->with('color', $color)
        ->with('link',$link)
        ->with('message', $message);
    }
    public function save(Request $request){
        $validator = Validator::make($request->all(), [
            'name'         => 'required',
            'email'        => 'required',
            'site'         => 'required',
            'content'      => 'required'
        ]);
        if ($validator->fails()) {
             return back();
        }
        $message = new Contact();
        $message->name = $request->name;
        $message->email = $request->email;
        $message->site = $request->site;
        $message->content = $request->content;
        $message->save();
        return back();
    }
}
