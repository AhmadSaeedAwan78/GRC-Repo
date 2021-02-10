<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

use Hash;

use Session;

use App\User;

use App\Cart;

use App\Ticket;

use App\Package;

use App\Faq;

use App\Blog;

use DB;
use Illuminate\Support\Facades\File;

use Sentinel;
use Rminder;
use Mail;
use App\PasswordSecurity;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        //    $fa=PasswordSecurity::where('user_id',Auth::user()->id)->first();
        // if($fa && $fa->google2fa_enable==0){
        //     redirect('/2fa');
        // }
        $this->middleware(['auth','2fa']);

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		if (Auth::user()->role == 1)
		{
			//return 'admin redirect';
			return redirect('/admin');

		}
		if ((Auth::user()->role == 2 || Auth::user()->role == 3) && Auth::user()->tfa == 1)
		{
			
			return redirect('2fa');
			//return 'client redirect';
		}
        return redirect('dashboard');	
    }
		
		/*if (Auth::user()->role == 2)
		{
			
			return redirect('/Forms/ClientSite');
			//return 'client redirect';
		}
        return view('home');
    }*/
	
	public function test ()
	{
		return view('admin.client.test');
	}

    public function custom_login ($company_id)
    {
        //echo "company Id : ".$company_id."<br>";
    }
    
    public function login_img_settings (){
        $responce = DB::table('login_img_settings')->first();
        return view('login_img_settings', compact('responce'));
    }
    public function update_login_img (Request $request){
        if ($request->hasFile('image')) {
            $validator = \Validator::make($request->all(), [
                'image' => 'dimensions:max_width=300,max_height=41'
            ]);
            if ($validator->fails()) {
                return redirect()->back()->with('status', 'The image has invalid image dimensions.');
            }     
            
            $image_size = $request->file('image')->getsize();
            if ( $image_size > 1000000 ) {
                return redirect()->back()->with('status', 'Maximum size of Image 1MB!')->withInput();            
            }            

            $img_name = '';
            $file = $request->file('image');
            $filename = $file->getClientOriginalName();
            $ext = $file->getClientOriginalExtension();
            $img_name = uniqid().$filename;
            $destination_path = public_path('/image');
            $file->move($destination_path, $img_name);
    
            $responce = DB::table('login_img_settings')->update(['image' => $img_name]);
      
            return redirect()->back()->with('status', 'Image Updated Successfully');
        }
        else{
            return redirect()->back()->with('status', 'No Image Found');            
        }
    }
}
