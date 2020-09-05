<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use Auth;
class CommentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function allComments()
    {
        $get_comments = Comment::where(function($query){
    		if(Auth::user()->role_id != env('ADMIN')){
	    		$query->where('user_id', Auth::user()->id);
	    	}
    	})->orderBy('id', 'desc')->get();
        return view('backend.comments')->with(compact('get_comments'));
    }

    public function commentUpdate(Request $request){
    	$update = Comment::where(function($query){
    		if(Auth::user()->role_id != env('ADMIN')){
	    		$query->where('user_id', Auth::user()->id);
	    	}
    	})->where('id', $request->id)->update(['comments' => $request->comment]);
    	if($update){
    		echo $request->comment;
    	}else{
    		echo "Sorry comment cannot update.";
    	}
      
    }
}
