<?php

namespace App\Http\Controllers;

use DataTables,DB;
use Carbon\Carbon;
use App\Mail\VarificationEmail;
use Illuminate\Support\Facades\Hash;
use App\CustomerContact;
use App\User;
use Illuminate\Http\Request;
use Validator,Redirect,Response;
use App\{Country,State};
use Illuminate\Support\Str;
use Illuminate\Auth\Passwords\PasswordBroker;
// use App\PasswordReset;

class ContactData extends Controller
{
	public function index()
	{
		
		$data['countries'] = Country::get();
		return view('contact',$data);
	}
	public function getState(Request $request)
    {
        $data['states'] = State::where("country_id",$request->country_id)
                    ->get();
        return response()->json($data);
    }
    public function contactList(Request $request)
    {
         if ($request->ajax()) 
         {
            $data = CustomerContact::with('users','countries','states')->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function($data){
                    return $data->users->name;
                })
                ->addColumn('email', function($data){
                    return $data->users->email;
                })
                ->addColumn('Country', function($data){
                    return $data->countries->countryname;
                })
                ->addColumn('State', function($data){
                  	return $data->states->statename;
                })
                ->addColumn('action', function($data){
                    $btn = '<a href="javascript:void(0)" id="'.$data->users->id.'"class="view view-product btn btn-primary btn-sm">View</a> <a href="javascript:void(0)" id="'.$data->users->id.'" class="edit edit-product btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" id="'.$data->users->id.'"class="delete btn btn-danger btn-sm">Delete</a>';
                  
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
       		 }
       	$data['states'] = State::get();
       	$data['countries'] = Country::get();
		return view('index',$data);
      	// return view('index');
    }

    public function reloadCaptcha()
    {
        return response()->json(['captcha'=> captcha_img()]);
    }

	public function contactSave(Request $request)
	{
		// $token = app(PasswordBroker::class)->createToken($request->mail);
		// $token = $request->_token;
		// $password = Hash::make($request->name);
		// $token = uniqid(base64_encode(Str::random(5)));
		// $token=Hash::make($token1);
		$password1=Str::random(10);
		$password = Hash::make($password1);
		$validate = $request->validate([
                        'name' => 'required|regex:/^[\pL\s\-]+$/u',
						'email' => 'unique:users|email',
						'phone' => 'digits:10',
						'address' => 'required',
						'country' => 'required',
						'state' => 'required',
						// 'comment' => 'required',
						'organization' => 'required',
						'captcha' => 'required|captcha'
					],
					[
                'captcha.captcha' => 'Incorrect Captcha'
            ]
				);

		$user= new User;
		$user->name = $request->name;
        $user->email = $request->email;		
        $user->password = $password;
        $user->remember_token = Str::random(32);
        $user->save();


        if($user->id)
        {
			$CustomerContact= new CustomerContact;

	        $CustomerContact->name = $request->name;
	        // $CustomerContact->email = $request->email;
			$CustomerContact->phone = $request->phone;
			$CustomerContact->address = $request->address;
			$CustomerContact->user_id = $user->id;
			$CustomerContact->country_id = $request->country;
			$CustomerContact->state_id = $request->state;
			$CustomerContact->comment = $request->comment;
			$CustomerContact->organization = $request->organization;
			$CustomerContact->captcha = $request->captcha;

			$CustomerContact->save();
             
             $token = app(\Illuminate\Auth\Passwords\PasswordBroker::class)->createToken($user);
			//New Mail
			DB::table('password_resets')->insert([
		    'email' => $request->email,
		    'token' => $token,
		    'created_at' => Carbon::now()
		]);
			

		$tokenData = DB::table('password_resets')->where('email', $request->email)->first();

		$this->sendResetEmail($tokenData->email, $tokenData->token,$password1);
		  
	}
		return redirect('contacts')->with('success', 'User created successfully.');

		
	}  

	private function sendResetEmail($email, $token,$password1)
	{
			//Retrieve the user from the database
			$user = DB::table('users')->where('email', $email)->select('name', 'email')->first();
			//Generate, the password reset link. The token generated is embedded in the link
			$loginurl=url("/login");
			$link1 = url("/password/reset/{$token}");

			$link = $link1.'?email='.urlencode($user->email);

		    $details = [
		        'title' => 'Hi '.$user->name.'',
		        'body' => 'Your account has been created successfully. Please find Below Login Credentials',
		        'username' => $user->email,
		        'password' => $password1,
		        'loginurl' =>$loginurl,
		        // 'link' => URL::route('password/reset/'.$token)
		        'url' => $link
		    ];
		   
		    \Mail::to($email)->send(new \App\Mail\ContactMail($details));
		    //Here send the link with CURL with an external email API 
		   
}


	public function destroy($id)
    {
    	 DB::table("users")->where("id", $id)->delete();
		DB::table("customer_contacts")->where("user_id", $id)->delete();

    }
    public function edit($id)
	{   
	
	    $cid = array('id' => $id);

	    $data  = User::where($cid)->first();

	    $user_id = $data->id;
	    $data['user']  = CustomerContact::where('user_id',$user_id)->first();

	   	$country_id = $data->user->country_id;
	   	$data['states']  = State::where('country_id',$country_id)->get();
	   	
	    $data['countries'] = Country::get();
	    return Response::json($data);
	}
	public function store(Request $request)
	{
		$validate = $request->validate([
                        'name' => 'required',
						'email' => 'email',
						'phone' => 'digits:10',
						'address' => 'required',
						'country' => 'required',
						'state' => 'required',
						// 'comment' => 'required',
						'organization' => 'required',
						'captcha' => 'required|captcha'
					],
					[
		                'captcha.captcha' => 'Incorrect Captcha'
		            ]
				);

		// if ($validate->fails())
		// {
		//     return response()->json(['errors'=>$validate->errors()->all()]);
		// }


		$id=$request->contact_id;
		$user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->update();

        $customer = CustomerContact::where('user_id', $user->id)->first();
         $customer->name = $request->name;
        // $customer->email = $request->email;
		$customer->phone = $request->phone;
		$customer->address = $request->address;
		$customer->user_id = $id;
		$customer->country_id = $request->country;
		$customer->state_id = $request->state;
		$customer->comment = $request->comment;
		$customer->organization = $request->organization;
		$customer->captcha = $request->captcha;

 
        $a=$customer->update();
        return Response::json($a);

	}
	public function view($id)
	{ 
	    $cid = array('id' => $id);

	    $data  = User::where($cid)->first();
	    
	    $user_id = $data->id;
	    // dd($user_id);
	     $data['user']  = CustomerContact::where('user_id',$user_id)->first();

	    $country_id = $data->user->country_id;
	   	$state_id = $data->user->state_id;
	   	$data['states']  = State::where('id',$state_id)->first();
	   	$data['countries'] = Country::where('id',$country_id)->first();
	    return Response::json($data);
	}
	public function searchFilter(Request $request)
	{
		
		if ($request->ajax()) 
         {
         	//dd($request->input('stateid'));
			$countryid = $request->input('countryid');
        	$stateid = $request->input('stateid');
        	$searchname = $request->input('searchname');
			// dd($countryid);
			if(!empty($countryid) && empty($stateid) && empty($searchname)){
					$data = CustomerContact::with('users','countries','states')->where('country_id',$countryid)->latest()->get();
					// dd($data);
			}
			if(!empty($countryid) && !empty($stateid) && empty($searchname)){
					$data = CustomerContact::with('users','countries','states')->where('country_id',$countryid)->where('state_id',$stateid)->latest()->get();
			}
			if(!empty($countryid) && empty($stateid) && !empty($searchname)){
					$data = CustomerContact::with('users','countries','states')->where('country_id',$countryid)->where('name',$searchname)->latest()->get();
			}
			if(empty($countryid) && !empty($stateid) && empty($searchname)){
					$data = CustomerContact::with('users','countries','states')->where('state_id',$stateid)->get();
			}

			if(!empty($countryid) && !empty($stateid) && !empty($searchname)){
					$data = CustomerContact::with('users','countries','states')->where('country_id',$countryid)->where('state_id',$stateid)->where('name',$searchname)->latest()->get();
			}
			if(empty($countryid) && empty($stateid) && !empty($searchname)){
					$data = CustomerContact::with('users','countries','states')->where('name',$searchname)->latest()->get();
			}

			if(empty($countryid) && empty($stateid) && empty($searchname)){
					$data = CustomerContact::with('users','countries','states')->latest()->get();
					// dd($data);
			}
			

			return Datatables::of($data)

                ->addIndexColumn()
                ->addColumn('name', function($data){
                    return $data->users->name;
                })
                ->addColumn('email', function($data){
                    return $data->users->email;
                })
                ->addColumn('Country', function($data){
                    return $data->countries->countryname;
                })

                ->addColumn('State', function($data){
                  	return $data->states->statename;
                })

                ->addColumn('action', function($data){
                    $btn = '<a href="javascript:void(0)" id="'.$data->id.'"class="view view-product btn btn-primary btn-sm">View</a> <a href="javascript:void(0)" id="'.$data->id.'" class="edit edit-product btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" id="'.$data->id.'"class="delete btn btn-danger btn-sm">Delete</a>';
                  
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
		}
		return view('index');
		
	}
}
