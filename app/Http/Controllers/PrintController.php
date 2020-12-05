<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use PDF;
use App\Mail\DemoEmail;

// require_once '/dompdf/lib/html5lib/Parser.php';
// require_once '/php-font-lib/src/FontLib/Autoloader.php';
// require_once '/php-svg-lib/src/autoload.php';
// require_once '/dompdf/src/Autoloader.php';
// Dompdf\Autoloader::register();
// use Dompdf\Dompdf;

class PrintController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function sendInvoice(Request $request)
    {
        $data = $request->data;
        // $price_list = $data['price_list'];
        // $total = $data['total'];
        // $vat = $data['vat'];
        // $vat = $data['vat'];
        // return view('invoice::print');price_list
        // dd($data);
        // $pdf = PDF::loadView('invoice::print', $data);  
        // dd($pdf);+
        Mail::to('themostfriend@gmail.com')->send(new DemoEmail($data));
        dd(count(Mail::failures()));
        if(count(Mail::failures()) > 0){
            // Your error message or whatever you want.
        }
        $data = ['title'=>'welcome to my site'];
        \Mail::send('test', $data, function($message) use ($pdf){
            $message->from('info@test.com*');
            $message->to('themostfriend@gmail.com');
            $message->subject('Date wise user report');
            $message->attachData($pdf->output(),'document.pdf');
        });
        $pdf = PDF::loadView('pdf', $data); 
        //  dd($pdf);
        $pdf->WriteHTML("asdfasdfasdf");
        $pdf->save('pdf');
        return $pdf->download('invoice.pdf');
    }
    

}
