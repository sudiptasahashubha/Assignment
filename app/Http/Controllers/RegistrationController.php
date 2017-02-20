<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

class RegistrationController extends Controller
{
    //
    public function create(){
    	return view('RegistrationViews.register');
    }
    public function store(Request $request){
    	 $this->validate(request(),[
    	 	'name'=>'required',
    	 	'email'=>'required|email',
    	 	'password'=>'required|confirmed'

    	 ]);
    	 $user=new User();
    	 $user->name=$request['name'];
    	 $user->email=$request['email'];
    	 $user->password=bcrypt($request['password']);
    	 $user->save();
    	 //$user=User::create(request(['name','email','password']));
    	 auth()->login($user);
         $cur_user_name=Auth::user()->name;
    	 return redirect('/home')->withMessage('Welcome '.$cur_user_name.'!');
    }
}
