<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use PDF;
use App\Mail\DemoEmail;
use Illuminate\Http\Request;
use App\Matériau;
use App\Coloris;
use App\Finition;
use App\Rate;
use App\Service;
use App\Sink;
use App\MixerTap;
use App\SoapDispenser;
use App\DrainerBasket;
use App\Bordure;
use App\Pagesetting;
use App\Page;
use App\OptionsAndCuts;
use App\Footer;

class PublicController extends Controller
{

public function index()
{

	return view('homepage');

}

public function get_BORDURE_list(){
	$get_BORDURE_list = Bordure::all();
	return $get_BORDURE_list;
}

public function devisGratuit(){
	$coloris = Coloris::all();
	$matériau = Matériau::all();
	$footer = Footer::all()->first();

	$finition = Finition::all();
	$services = Service::all();
	$sinks     = Sink::all();
	$mixers	= MixerTap::all();
	$soaps 	= SoapDispenser::all();
	$drainer 	= DrainerBasket::all();
	$pagesetting = Pagesetting::all();
	$optionsAndCuts = OptionsAndCuts::all();

	$page = Page::pluck('value1', 'title')->toArray();
    $covers = Page::where('title', '=', 'cover')->get();
    $articles = Page::where('title', '=', 'article')->get()->toArray();
    $populars = Page::where('title', '=', 'popular')->get()->toArray();
    $socials = Page::where('title', '=', 'social')->get()->toArray();

	return view('services',compact('matériau','footer', 'optionsAndCuts','coloris','finition','services','sinks','mixers','soaps','drainer','pagesetting','page', 'covers', 'articles', 'populars', 'socials'));
}

public function selectMaterial($material_id) {
	$material = Matériau::find($material_id);
	$colors = Coloris::where('matériaus_id', $material_id)->get();
	$borders = Bordure::where('material_id', $material_id)->get();

	$coloris = Coloris::all();
	$matériau = Matériau::all();
	
	$finition = Finition::all();
	$services = Service::all();
	$sinks     = Sink::all();
	$mixers	= MixerTap::all();
	$soaps 	= SoapDispenser::all();
	$drainer 	= DrainerBasket::all();
	$pagesetting = Pagesetting::all();
	$optionsAndCuts = OptionsAndCuts::all();

	$page = Page::pluck('value1', 'title')->toArray();
    $covers = Page::where('title', '=', 'cover')->get();
    $articles = Page::where('title', '=', 'article')->get()->toArray();
    $populars = Page::where('title', '=', 'popular')->get()->toArray();
	$socials = Page::where('title', '=', 'social')->get()->toArray();

	return view('services',compact('matériau', 'material','borders', 'colors','optionsAndCuts','coloris','finition','services','sinks','mixers','soaps','drainer','pagesetting','page', 'covers', 'articles', 'populars', 'socials'));
	
}
	public function getColoris(Request $request){

		$id = $request->cat_id;
		

	    $coloris = Coloris::where("matériaus_id",$id)->get();

	    if(count($coloris) == 0) {
			$coloris = new Coloris();
		}

		$finishing = Finition::where("matériaus_id",$id)->where('coloris_id',$coloris[0]['id'])->get();
	    	
	    return response()->json(['coloris' => $coloris,'finishing' => $finishing]);

	}

	public function getFinishing(Request $request)
	{
		$finishing=Finition::where('coloris_id',$request->color_id)->get();
		$color_image=Coloris::where('id',$request->color_id)->where('matériaus_id',$request->mat_id)->first();
		
		return response()->json(['finishing' => $finishing, 'color_img' => $color_image['picture']]);

	}

	public function getPrice(Request $request)
	{
		$rates=Rate::where('material_id', $request->material_id)->where('color_id',$request->color_id)->where('finishing_id',$request->finishing_id)->get();
		$borders = Bordure::where('material_id', $request->material_id)->get();
		
		return response()->json(['rates' => $rates, 'borders' => $borders]);
	} 

	public function getCalculatedPrice(Request $request)
	{
		$rates=Rate::where('material_id',$request->material_id)->where('color_id',$request->color_id)->where('finishing_id',$request->finishing_id)->where('category',$request->category)->first();
		return response()->json(['rates' => $rates]);
	}
	public function invoice(Request $request)
	{
		dd("dfsdf");
		// $rates=Rate::where('material_id',$request->material_id)->where('color_id',$request->color_id)->where('finishing_id',$request->finishing_id)->where('category',$request->category)->first();
		// return response()->json(['rates' => $rates]);
	}
	public function downloadPdf($data){
		// echo $data;
		$obj = json_decode($data);
		// echo $obj->vat;
		// var_dump(json_decode($data, true));
		// print_r($obj)
		$pdf = PDF::loadView('pdf', compact('obj'));
		// // Mail::to('themostfriend@gmail.com')->send(new DemoEmail($data));
		// // \Mail::send('test', $data, function($message) use ($pdf){
        // //     $message->from('info@test.com*');
        // //     $message->to('themostfriend@gmail.com');
        // //     $message->subject('Date wise user report');
        // //     $message->attachData($pdf->output(),'disney.pdf');
        // // });
		return $pdf->download('disney.pdf');
		// PDF::loadView('pdf', $datas, [], $config)->save($pdfFilePath);
		
		// return view('materialuser.product', compact('tmp'));
	}
}
