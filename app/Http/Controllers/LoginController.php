<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{
    //
    public function __construct(){

 		$this->middleware('guest')->except(['destroy']);
	}
    public function create(){
    	return view('LoginViews.login');
    }
    public function store(){
    	if(!auth()->attempt(request(['email','password']))){
    		return back()->withMessage(
    			'Sorry, can not recognize you!'
    		);
    	}
        $cur_user_name=Auth::user()->name;
    	return redirect('/home')->withMessage('Welcome back '.$cur_user_name.'!');
    }
    public function destroy(){
    	auth()->logout();
    	return redirect('\home')->withMessage('See you again!');
    }
}
