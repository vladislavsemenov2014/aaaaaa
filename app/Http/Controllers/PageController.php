<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Page;
use App\MixerTap;

class PageController extends Controller
{
    //
    public function __construct(){

        $this->middleware('checkrole:admin');
        $this->middleware('auth');
    }
    public function showPage()
    {
        if(Page::where('title', '=', 'banner text')->first() == null)
        {
            $banner = new Page;
            $banner->title = "banner text";
            $banner->value = "banner text";
            $banner->save();
        }
        if(Page::where('title', '=', 'banner color')->first() == null)
        {
            $banner = new Page;
            $banner->title = "banner color";
            $banner->value = "#ff0000";
            $banner->save();
        }
        if(Page::where('title', '=', 'banner bkg')->first() == null)
        {
            $banner = new Page;
            $banner->title = "banner bkg";
            $banner->value = "";
            $banner->save();
        }
        if(Page::where('title', '=', 'banner logo')->first() == null)
        {
            $banner = new Page;
            $banner->title = "banner logo";
            $banner->value = "";
            $banner->save();
        }

        $page = Page::pluck('value1', 'title')->toArray();
        $covers = Page::where('title', '=', 'cover')->get()->toArray();
        $articles = Page::where('title', '=', 'article')->get()->toArray();
        $populars = Page::where('title', '=', 'popular')->get()->toArray();
        $socials = Page::where('title', '=', 'social')->get()->toArray();
        return view('admin.page', compact('page', 'covers', 'articles', 'populars', 'socials'));
    }

    public function editBannerTitlePost(Request $request)
    {
        $banner = Page::where('title', '=', 'banner text')->first();
        $banner->value1 = $request['banner_title'];
        $banner->save();
        return redirect('admin/show-page')->with('success',"Drainer updated successfully");
    }

    public function editBannerColorPost(Request $request)
    {
        $banner = Page::where('title', '=', 'banner color')->first();
        $banner->value1 = $request['bannercolor'];
        $banner->save();
        return redirect('admin/show-page')->with('success',"Drainer updated successfully");
    }
    public function editBannerBackgroundPost(Request $request)
    {
        $banner = Page::where('title', '=', 'banner bkg')->first();

        $a = $request->file('banner_bkg');
        if($a != null)
        {

            $imageName = 'banner-'.time().'-'.rand(000000,999999).'.'.$a->getClientOriginalExtension();
        
            $destinationPath = public_path('images/stones/');
            
            $a->move($destinationPath, $imageName); 
            $banner->value1 = $imageName;
            $banner->save();
        }

        return redirect('admin/show-page')->with('success',"Background updated successfully");
    }

    public function editLogoPost(Request $request)
    {
        $banner = Page::where('title', '=', 'banner logo')->first();

        $a = $request->file('logo');
        if($a != null)
        {

            $imageName = 'logo-'.time().'-'.rand(000000,999999).'.'.$a->getClientOriginalExtension();
        
            $destinationPath = public_path('images/stones/');
            
            $a->move($destinationPath, $imageName);
        }
        $banner->value1 = $imageName;
		
        $banner->save();
        return redirect('admin/show-page')->with('success',"Logo updated successfully");
    }
    ////////  coverage CRUD ///////////
    public function addCover()
    {
        return view('admin.addCover');
    }
    public function addCoverPost(Request $request)
    {
        $addCover = new Page;

        $addCover->title = 'cover';
        $addCover->value1 = $request['title'];
        $addCover->value2 = $request['color'];
   		$addCover->save();	
        return redirect('admin/show-page')->with('success',"New Coverage added successfully");
    }
    public function editCover($id)
    {
        $cover = Page::findorFail($id);
		return view('admin.editCover',compact('cover'));
    }
    public function editCoverPost(Request $request , $id)
    {
        $cover = Page::findorFail($id);
        $cover->value1 = $request['title'];
        $cover->value2 = $request['color'];
   		$cover->save();	
		return redirect('admin/show-page')->with('success',"Coverage updated successfully");
    }
    public function deleteCover($id)
    {
        $cover = Page::findorFail($id);
        $cover->delete();
		return redirect('admin/show-page')->with('success',"Coverage deleted successfully");
    }

    ////////// Article CRUD ///////////////
    public function addArticle()
    {
        return view('admin.addArticle');
    }
    public function addArticlePost(Request $request)
    {
        $addArticle = new Page;

        $a = $request->file('file');
        if($a != null)
        {

            $imageName = 'article-'.time().'-'.rand(000000,999999).'.'.$a->getClientOriginalExtension();
        
            $destinationPath = public_path('images/stones/');
            
            $a->move($destinationPath, $imageName);
        } 
        $addArticle->title = "article";
        $addArticle->value2 = $request['title'];
        $addArticle->value1 = $imageName;
		
        $addArticle->save();
        return redirect('admin/show-page')->with('success',"New Article added successfully");
    }
    public function editArticle($id)
    {
        $article = Page::findorFail($id);
		return view('admin.editArticle',compact('article'));
    }
    public function editArticlePost(Request $request , $id)
    {
        $article = Page::findorFail($id);
        $article->value1 = $request['title'];

        $a = $request->file('fileArticle');
        if($a != null)
        {
            $imageName = 'article-'.time().'-'.rand(000000,999999).'.'.$a->getClientOriginalExtension();
        
            $destinationPath = public_path('images/stones/');
            
            $a->move($destinationPath, $imageName);
        } 

        $article->value2 = $imageName;
   		$article->save();	
		return redirect('admin/show-page')->with('success',"Article updated successfully");
    }
    public function deleteArticle($id)
    {
        $cover = Page::findorFail($id);
        $cover->delete();
		return redirect('admin/show-page')->with('success',"Article deleted successfully");
    }
    ////////  Popular Tag CRUD ///////////
    public function addPopular()
    {
        return view('admin.addPopular');
    }
    public function addPopularPost(Request $request)
    {
        $addPopular = new Page;

        $addPopular->title = 'popular';
        $addPopular->value1 = $request['tag'];
        $addPopular->value2 = $request['url'];
   		$addPopular->save();	
        return redirect('admin/show-page')->with('success',"New Popular added successfully");
    }
    public function editPopular($id)
    {
        $popular = Page::findorFail($id);
		return view('admin.editPopular',compact('popular'));
    }
    public function editPopularPost(Request $request , $id)
    {
        $popular = Page::findorFail($id);
        $popular->value1 = $request['tag'];
        $popular->value2 = $request['url'];
   		$popular->save();	
		return redirect('admin/show-page')->with('success',"Popular updated successfully");
    }
    public function deletePopular($id)
    {
        $cover = Page::findorFail($id);
        $cover->delete();
		return redirect('admin/show-page')->with('success',"Popular deleted successfully");
    }
    ////////// Social CRUD ///////////////
    public function addSocial()
    {
        return view('admin.addSocial');
    }
    public function addSocialPost(Request $request)
    {
        $addSocial = new Page;

        $a = $request->file('file');
        if($a != null)
        {
            $imageName = 'social-'.time().'-'.rand(000000,999999).'.'.$a->getClientOriginalExtension();
        
            $destinationPath = public_path('images/stones/');
            
            $a->move($destinationPath, $imageName); 
            $addSocial->title = "social";
            $addSocial->value1 = $imageName;
        }
        $addSocial->value2 = $request['url'];
        
		
        $addSocial->save();
        return redirect('admin/show-page')->with('success',"New Social added successfully");
    }
    public function editSocial($id)
    {
        $social = Page::findorFail($id);
		return view('admin.editSocial',compact('social'));
    }
    public function editSocialPost(Request $request , $id)
    {
        $social = Page::findorFail($id);

        $a = $request->file('file');
        if($a != null)
        {
            $imageName = 'social-'.time().'-'.rand(000000,999999).'.'.$a->getClientOriginalExtension();
    
            $destinationPath = public_path('images/stones/');
            
            $a->move($destinationPath, $imageName); 

            $social->value1 = $imageName;
        }
        
        $social->value2 = $request['url'];
   		$social->save();	
		return redirect('admin/show-page')->with('success',"Social updated successfully");
    }
    public function deleteSocial($id)
    {
        $cover = Page::findorFail($id);
        $cover->delete();
		return redirect('admin/show-page')->with('success',"Social deleted successfully");
    }
}
