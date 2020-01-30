<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\News;
use App\Models\Notification;
use App\User;
use Auth;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
class CommentController extends Controller
{

    public function comment_insert(Request $request)
    {
        $user_id = Auth::user()->id;
        $data = [
            'news_id' => $request->news_id,
            'user_id' => $user_id,
            'comments' =>$request->comment,
            'type' => 1,
        ];

        $insert = Comment::create($data);

        if($insert){
            $author = News::find($request->news_id);
            $notify = [
                'fromUser' => $user_id,
                'toUser' => $author->user_id,
                'type' => env('REPORTER_NOTIFY'),
                'item_id' => $request->news_id,
                'notify' => 'comment on your news',
            ];
            Notification::create($notify);
            echo '<li><div class="comment-box"><img alt="" src="'.asset('upload/images/users/thumb_image/'.$insert->user->image).'">
            <div class="comment-content">
                <h4>'.$insert->user->name.'<a href="#"><i class="fa fa-comment-o"></i>Reply</a></h4>
                <span><i class="fa fa-clock-o"></i>'. \Carbon\Carbon::parse($insert->created_at)->diffForHumans().'</span>
                <p>'. $insert->comments.' </p>
            </div></div></li>';
        }
    }

    public function registrationAndComment(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'mobile_or_email' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $email = $phone = null;
        if (filter_var($request['mobile_or_email'], FILTER_VALIDATE_EMAIL)) {
            $email = $request['mobile_or_email'];
            $check = User::select('username')->where('email', $email)->first();
            $msg = 'Sorry email already exists.';
        }else{
            $phone = $request['mobile_or_email'];

            if(!is_numeric($phone) OR strlen($phone)<10){

                Toastr::error('Invalid mobile number or email.');
                return back();
            }

            $check = User::select('username')->where('phone', $phone)->first();
            $msg = 'Sorry mobile number already exists.';
        }

        if($check){
            Toastr::error($msg);
            return back();
            exit();
        }
        $success = User::create([
            'name' => $request['name'],
            'username' => $this->createSlug($request['name']),
            'email' => $email,
            'phone' => $phone,
            'role_id' => 3,
            'creator_id' => 0,
            'password' => Hash::make($request['password']),
            'status' => '1',
        ]);

        if($success){
            if(Auth::attempt(['email' => $request['mobile_or_email'], 'password' => $request->password]) || Auth::attempt(['phone' => $request['mobile_or_email'], 'password' => $request->password])) {

                $user_id = Auth::user()->id;
                $data = [
                    'news_id' =>$request->news_id,
                    'user_id' => $user_id,
                    'comments' =>$request->comment,
                    'type' => 1,
                ];
                $insert = Comment::create($data);
                if($insert){
                    $author = News::find($request->news_id);
                    $notify = [
                        'fromUser' => $user_id,
                        'toUser' => $author->user_id,
                        'type' => env('REPORTER_NOTIFY')
  ,                      'item_id' => $request->news_id,
                        'notify' => 'comment on your news',
                    ];
                }
            }

            Toastr::success('মন্তব্য সফলভাবে পোস্ট হয়েছে');
            return back();
        }else{
            Toastr::error('দুঃখিত রেজিস্ট্রেশন ব্যর্থ হয়েছে।');
            return back();
        }

    }

    public function comment_reply(Request $request, $comment_id)
    {

        $user_id = Auth::user()->id;
        $data = [
            'news_id' => $request->news_id,
            'user_id' => $user_id,
            'comments' => $request->reply_comment,
            'comment_id' => $comment_id,
            'type' => 2,
        ];

        $insert = Comment::create($data);

        if($insert){
            $toUser = Comment::find($comment_id);
            $notify = [
                'fromUser' => $user_id,
                'toUser' => $toUser->user_id,
                'type' => env('REPORTER_NOTIFY'),
                'item_id' => $request->news_id,
                'notify' => 'reply on your comment',
            ];
            Notification::create($notify);

             echo '<li><div class="comment-box"><img alt="" src="'.asset('upload/images/users/thumb_image/'.$insert->user->image).'">
            <div class="comment-content">
                <h4>'.$insert->user->name.'</h4>
                <span><i class="fa fa-clock-o"></i>'. \Carbon\Carbon::parse($insert->created_at)->diffForHumans().'</span>
                <p>'. $insert->comments.' </p>
            </div></div></li>';
        }
    }

    public function comments($slug){
        $data['get_news'] = News::where('news_slug', $slug)->first();
        if($data['get_news']){
            $data['comments'] = Comment::where('news_id', $data['get_news']->id)->where('type', 1)->get();

            $data['more_news'] =News::with(['categoryList', 'subcategoryList', 'image'])
                ->where('news.id', '!=', $data['get_news']->id)
                ->where('news.category', $data['get_news']->category)
                ->orderBy('id', 'DESC')
                ->take(8)->get();
            return view('frontend.news-comments')->with($data);
        }else{
            return view('frontend.404');
        }

    }

    public function createSlug($slug)
    {
        $slug = strTolower(preg_replace('/[\s-]+/', '-', trim($slug)));
        $slug = (preg_replace('/[?.]+/', '', $slug));
        $check_slug = User::select('username')->where('username', 'like', $slug.'%')->get();

        if (count($check_slug)>0){
            //find slug until find not used.
            for ($i = 1; $i <= count($check_slug); $i++) {
                $newSlug = $slug.'-'.$i;
                if (!$check_slug->contains('news_slug', $newSlug)) {
                    return $newSlug;
                }
            }
        }else{ return $slug; }
    }

}
