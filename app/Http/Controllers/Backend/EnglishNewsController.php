<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Deshjure;
use App\Models\News;
use App\Models\Notification;
use App\Models\SubCategory;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EnglishNewsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $user_id = Auth::user()->id;
//        $get_news = News::with(['category', 'reporter', 'image']);
        $get_news = DB::table('news')
            ->join('users', 'news.user_id', '=', 'users.id')
            ->leftJoin('categories', 'news.category', '=', 'categories.id')
            ->leftJoin('sub_categories', 'news.subcategory', '=', 'sub_categories.id')
            ->leftJoin('media_galleries', 'news.thumb_image', '=', 'media_galleries.id')
            ->where('lang', '=',2)
            ->where('news.status', '=',1);
            if(Auth::user()->role_id != 1){
                $get_news = $get_news->where('news.user_id', $user_id);
            }
        $get_news = $get_news->select('news.*','users.name','users.username', 'categories.category_bd', 'categories.category_en', 'sub_categories.subcategory_bd', 'media_galleries.source_path')
            ->orderBy('news.created_at', 'DESC')->paginate(25);
        return view('backend.english-news-list')->with(compact('get_news'));
    }

    public function pending()
    {
        $user_id = Auth::user()->id;
//        $get_news = News::with(['category', 'reporter', 'image']);
        $get_news = DB::table('news')
            ->join('users', 'news.user_id', '=', 'users.id')
            ->leftJoin('categories', 'news.category', '=', 'categories.id')
            ->leftJoin('sub_categories', 'news.subcategory', '=', 'sub_categories.id')
            ->leftJoin('media_galleries', 'news.thumb_image', '=', 'media_galleries.id')
            ->where('lang', '=',2)
            ->where('news.status', '=',0);
            if(Auth::user()->role_id != 1){
                $get_news = $get_news->where('news.user_id', $user_id);
            }
        $get_news = $get_news->select('news.*','users.name','users.username', 'categories.category_bd', 'categories.category_en', 'sub_categories.subcategory_bd', 'media_galleries.source_path')
            ->orderBy('news.created_at', 'DESC')->paginate(25);
        return view('backend.english-news-list')->with(compact('get_news'));
    }

    public function draft()
    {
        $user_id = Auth::user()->id;
//        $get_news = News::with(['category', 'reporter', 'image']);
        $get_news = DB::table('news')
            ->join('users', 'news.user_id', '=', 'users.id')
            ->leftJoin('categories', 'news.category', '=', 'categories.id')
            ->leftJoin('sub_categories', 'news.subcategory', '=', 'sub_categories.id')
            ->leftJoin('media_galleries', 'news.thumb_image', '=', 'media_galleries.id')
            ->where('lang', '=',2)
            ->where('news.status', '=',2);
            if(Auth::user()->role_id != 1){
                $get_news = $get_news->where('news.user_id', $user_id);
            }
        $get_news = $get_news->select('news.*','users.name','users.username', 'categories.category_bd', 'categories.category_en', 'sub_categories.subcategory_bd', 'media_galleries.source_path')
            ->orderBy('news.created_at', 'DESC')->paginate(25);
        return view('backend.english-news-list')->with(compact('get_news'));
    }

    public function create()
    {
        $data = [];
        $data['categories'] = Category::where('status', 1)->orderBy('serial', 'ASC')->get();
        $data['reporters'] = User::where('role_id', env('REPORTER'))->orWhere('role_id', env('GENERAL_REPORTER'))->orWhere('role_id', env('ADMIN'))->get();
       
        return view('backend.english-news')->with($data);
    }


    public function edit($news_slug)
    {
        $user_id = Auth::user()->id;
        $data = [];
        $data['categories'] = Category::where('status', 1)->get();
        $data['reporters'] = User::where('role_id', env('REPORTER'))->orWhere('role_id', env('GENERAL_REPORTER'))->orWhere('role_id', env('ADMIN'))->get();

        $find_news = News::with(['image'])->where('news_slug', $news_slug);
        if(Auth::user()->role_id != 1){
            $find_news =  $find_news->where('user_id', $user_id);
        }
        $data['get_news'] =  $find_news->first();

        if($find_news){
            $data['get_subcategories'] = SubCategory::where('category_id',  $data['get_news']->category)->get();
            $data['get_districts'] = Deshjure::where('parent_id',  $data['get_news']->subcategory)->where('cat_type', 1)->get();
            $data['get_upzillas'] = Deshjure::where('parent_id',  $data['get_news']->child_cat)->where('cat_type', 2)->get();

            return view('backend.english-news-edit')->with($data);
        }else{
            Toastr::error('Sorry news not found.');
            return back();
        }
    }

    // update news in NewsController( bangla  and english news same)

}
