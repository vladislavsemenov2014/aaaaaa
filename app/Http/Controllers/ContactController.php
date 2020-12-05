<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Contact;

class ContactController extends Controller
{
    public function index(){
        $message = Contact::all();
        return view('material.contact.index')
        ->with('message',$message);
    }

    public function destroy(Request $request){

        $message = Contact::find($request->message_id);
        $message->delete();
    }
}
