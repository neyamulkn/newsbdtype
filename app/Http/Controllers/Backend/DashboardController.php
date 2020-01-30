<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Redirect;
class DashboardController extends Controller
{

    public function dashboard(){
    	if(Auth::user()->role_id != 3){
    		return view('backend.index');
    	}else{
    		return Redirect::route('404');
    	}
       
    }
}
