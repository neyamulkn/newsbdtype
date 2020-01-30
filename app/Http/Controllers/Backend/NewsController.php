<?php

namespace App\Http\Controllers\Backend;

use App\Models\Deshjure;
use App\Models\SubCategory;
use App\Models\Notification;
use App\User;
use App\Models\Category;
use App\Models\MediaGallery;
use App\Models\News;
use App\Http\Controllers\Controller;
use App\Models\Reporter;
use App\Models\Speciality;
use Brian2694\Toastr\Facades\Toastr;
use Faker\Provider\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class NewsController extends Controller
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
            ->where('lang','=', 1)
            ->where('news.status', '=',1);
            if(Auth::user()->role_id != env('ADMIN')){
                $get_news = $get_news->where('news.user_id', $user_id);
            }
        $get_news = $get_news->select('news.*','users.name','users.username', 'categories.category_bd', 'categories.category_en', 'sub_categories.subcategory_bd', 'media_galleries.source_path')
            ->orderBy('news.created_at', 'DESC')->paginate(25);
     
        return view('backend.news-list')->with(compact('get_news'));
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
            ->where('lang', '=',1)
            ->where('news.status', '=',0);
            if(Auth::user()->role_id != env('ADMIN')){
                $get_news = $get_news->where('news.user_id', $user_id);
            }
        $get_news = $get_news->select('news.*','users.name','users.username', 'categories.category_bd', 'categories.category_en', 'sub_categories.subcategory_bd', 'media_galleries.source_path')
            ->orderBy('news.created_at', 'DESC')->paginate(25);
        return view('backend.news-list')->with(compact('get_news'));
    }

    public function draft()
    {
        $user_id = Auth::user()->id;
        $get_news = DB::table('news')
            ->join('users', 'news.user_id', '=', 'users.id')
            ->leftJoin('categories', 'news.category', '=', 'categories.id')
            ->leftJoin('sub_categories', 'news.subcategory', '=', 'sub_categories.id')
            ->leftJoin('media_galleries', 'news.thumb_image', '=', 'media_galleries.id')
            ->where('lang', '=',1)
            ->where('news.status', '=',2);
            if(Auth::user()->role_id != 1){
                $get_news = $get_news->where('news.user_id', $user_id);
            }
        $get_news = $get_news->select('news.*','users.name','users.username', 'categories.category_bd', 'categories.category_en', 'sub_categories.subcategory_bd', 'media_galleries.source_path')
            ->orderBy('news.created_at', 'DESC')->paginate(25);
        return view('backend.news-list')->with(compact('get_news'));
    }

    public function create()
    {
        $data = [];
        $data['categories'] = Category::where('status', 1)->orderBy('serial', 'ASC')->get();
        $data['reporters'] = User::where('role_id',  env('REPORTER'))->orWhere('role_id', env('GENERAL_REPORTER'))->orWhere('role_id', env('ADMIN'))->get();
        
        return view('backend.news')->with($data);
    }

    public function selectImage(Request $request){
        $getImage = MediaGallery::find($request->imageId);
        $user_id = Auth::user()->id;
        $data = [
            'title' => $request->image_title,
            'user_id' => $user_id,
        ];
        MediaGallery::where('id', $getImage->id)->update($data);
        $output = array(
            'success' => $getImage->id,
            'image'  => '<input class="dropify" id="input-file-disable-remove" data-show-remove="false" data-default-file="'.asset('upload/images/'.$getImage->source_path).'">'
        );
        return response()->json($output);
    }

    public function store(Request $request)
    {
        //news is draft
        if($request->submit == 'draft'){
            $request->validate([
            'news_title' => 'required',
            ]);
        }else{
            $request->validate([
                'news_title' => 'required',
                'news_dsc' => 'required',
                'category' => 'required',
                'image' => 'required',
            ]);
        }

        $user_id = Auth::user()->id;
        if($request->has('user_id')){ $user_id = $request->user_id; }
            if($request->news_slug){
                $news_slug =  $this->createSlug($request->news_slug);
            }else{
                $news_slug =  $this->createSlug($request->news_title);
            }

            $news_data = new News();
            $news_data->news_title = $request->news_title;
            $news_data->news_slug = $news_slug;
            $news_data->news_dsc = $request->news_dsc;
            $news_data->category = $request->category;
            $news_data->subcategory = ($request->subcategory) ? $request->subcategory : null;
            $news_data->child_cat = ($request->district) ? $request->district : null;
            $news_data->subchild_cat = ($request->upzilla) ? $request->upzilla : null;
            $news_data->user_id = $user_id;
            $news_data->lang =  $request->lang;
            $news_data->type = $request->type;
            $news_data->breaking_news = ($request->breaking_news) ? '1' : '0';

            if($request->has('publish_date')){
                $news_data->publish_date = $request->publish_date;
            }
            if($request->has('image')){
                $news_data->thumb_image = $request->image;
            }

            $news_data->keywords = ($request->keywords) ? implode(',', $request->keywords) : '';

            if($request->submit != 'draft'){
                $news_data->status = (isset($request->status)) ? 1 : '0';
            }else{
                $news_data->status = 2;
            }

            $success = $news_data->save();

            if($success){
                if($request->hasFile('attach_files')){
                    $attach_files = $request->file('attach_files');
                    foreach ($attach_files as $attach_file) {

                        $new_name = $this->uniquePath($attach_file->getClientOriginalName());
                        $attach_file->move(public_path('upload/file'), $new_name);
                        $data = [
                            'source_path' => $new_name,
                            'type' => $news_data->id,
                            'user_id' => $user_id,
                        ];
                        $insert = MediaGallery::create($data);
                    }
                }
                // check news post by admin or news is not draft then push notification
                if(Auth::user()->role_id  != env('ADMIN') && $request->submit != 'draft' ){
                    $toUser = User::where('role_id', env('ADMIN'))->first();
                    $notify = [
                        'fromUser' => $user_id,
                        'toUser' => $toUser->id,
                        'type' => env('NEWS'),
                        'item_id' => $news_data->id,
                        'notify' => 'posting news',
                    ];
                    Notification::create($notify);
                }
                Toastr::success('News is '.$request->submit.' successfully.');
            }else{
                Toastr::error('Sorry news inserted faield. ');
            }
            if($news_data->status == 1){$status = 'list';}elseif($news_data->status == 2){ $status = 'draft';}else{ $status = 'pending'; }

            if($request->lang == 1){
                return redirect::route('news.'.$status);
            }else{
                return redirect::route('englishNews.'.$status);
            }

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

            return view('backend.news-edit')->with($data);
        }else{
            Toastr::error('Sorry news not found.');
            return back();
        }

    }

    public function update(Request $request, $id)
    {

        $news_update = News::where('id', $id)->first();

        //news is draft
        if($request->submit == 'draft'){
            $request->validate([
            'news_title' => 'required',
            ]);
        }else{
            $request->validate([
                'news_title' => 'required',
                'news_dsc' => 'required',
                'category' => 'required',
            ]);
        }

        $user_id = Auth::user()->id;
        if($request->has('user_id')){ $user_id = $request->user_id; }
        $news_slug =  $this->createSlug($request->news_slug);
        $news_update->news_title = $request->news_title;
        if($request->news_slug){
            $news_update->news_slug = $news_slug;
        }
        $news_update->news_dsc = $request->news_dsc;
        $news_update->category = $request->category;
        $news_update->subcategory = ($request->subcategory) ? $request->subcategory : null;
        $news_update->child_cat = ($request->district) ? $request->district : null;
        $news_update->subchild_cat = ($request->upzilla) ? $request->upzilla : null;
        $news_update->user_id = $user_id;
        $news_update->lang =  $request->lang;
        $news_update->type = $request->type;
        $news_update->breaking_news = ($request->breaking_news) ? '1' : '0';

        if($request->has('publish_date')){
            $news_update->publish_date = $request->publish_date;
        }
        if(!empty($request->image)){
            $news_update->thumb_image = $request->image;
        }

        $news_update->keywords = ($request->keywords) ? implode(',', $request->keywords) : '';
       
        if($request->submit != 'draft'){
            $news_update->status = (isset($request->status) ? 1 : '0');
        }else{
            $news_update->status = 2;
        }

        $success = $news_update->save();

        if($success){
            if($request->hasFile('attach_files')){
                $attach_files = $request->file('attach_files');
                foreach ($attach_files as $attach_file) {

                    $new_name = $this->uniquePath($attach_file->getClientOriginalName());
                    $attach_file->move(public_path('upload/file'), $new_name);
                    $data = [
                        'source_path' => $new_name,
                        'type' => $news_update->id,
                        'user_id' => $user_id,
                    ];
                    $insert = MediaGallery::create($data);
                }
            }
            Toastr::success('News is ' .$request->submit. ' successfully.');
        }else{
            Toastr::error('Sorry news updated faield.');
        }
        if($news_update->status == 1){$status = 'list';}elseif($news_update->status == 2){ $status = 'draft';}else{ $status = 'pending'; }

        if($request->lang == 1){
            return redirect::route('news.'.$status);
        }else{
            return redirect::route('englishNews.'.$status);
        }


    }

    public function delete($id)
    {
        $delete =  News::find($id)->delete();
        if($delete){
            echo 'News delete successfull.';
        }else{
            echo 'Sorry news can\'t deleted.';
        }
    }


    public function deleteAttachFile($id){
        $newsFile = MediaGallery::find($id);
        //delete newsFile from store folder
        $file_path = public_path('upload/file/'. $newsFile->source_path);
        if(file_exists($file_path)){
            unlink($file_path);
        }
        // delete image from database
        $delete = $newsFile->delete();
        if($delete){
            echo "Image deleted successfull.";
        }else{
            echo "Sorry image delete failed.!";
        }
    }


    public function status($status){
        $status = News::find($status);
        if($status){
            if($status->status == 1){
                $status->update(['status' => 0]);
                $output = array( 'status' => 'unpublish',  'message'  => 'News Unpublished');
            }else{
                $status->update(['status' => 1]);
                $output = array( 'status' => 'publish',  'message'  => 'News Published');
            }

            $fromUser = User::where('role_id', env('ADMIN'))->first();
            $notify = [
                'fromUser' => $fromUser->id,
                'toUser' => $status->user_id,
                'type' => env('NEWS'),
                'item_id' => $status->id,
                'notify' => $output['message'],
            ];
            Notification::create($notify);
        }
        return response()->json($output);
    }
    public function breaking_news($status){
        $status = News::find($status);
        if($status->breaking_news == 1){
            $status->update(['breaking_news' => 0]);
            $output = array( 'status' => 'remove',  'message'  => 'Remove From Breaking News');
        }else{
            $status->update(['breaking_news' => 1]);
            $output = array( 'status' => 'added',  'message'  => 'Added To Breaking News');
        }

        return response()->json($output);
    }

    public function createSlug($slug=null)
    {
        //$slug = Str::slug($slug);
        $slug = strTolower(preg_replace('/[\s-]+/', '-', trim($slug)));
        $slug = (preg_replace('/[?.]+/', '', $slug));
        $check_slug = News::select('news_slug')->where('news_slug', 'like', $slug.'%')->get();

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

    public function uniquePath($path)
    {

        $check_path = MediaGallery::select('source_path')->where('source_path', 'like', $path.'%')->get();

        if (count($check_path)>0){
            //find slug until find not used.
            for ($i = 1; $i <= count($check_path); $i++) {
                $newPath = $i.'-'.$path;
                if (!$check_path->contains('news_slug', $newPath)) {
                    return $newPath;
                }
            }
        }else{ return $path; }
    }

    public function videoUpload(Request $request)
        {
         $rules = array(
          'uploadFile'  => 'required'
         );

         $error = Validator::make($request->all(), $rules);

         if($error->fails())
         {
            return response()->json(['errors' => $error->errors()->all()]);
         }
         $uploadFile = $request->file('uploadFile');

         $new_name = rand() . '.' . $uploadFile->getClientOriginalExtension();
         $uploadFile->move(public_path('theme/zipfile'), $new_name);

        $theme_url = $request->theme_url;
        $data = ['main_file' => $new_name ];
        $insert_id = theme::where('theme_url',  $theme_url)->update($data);
         $output = array(
             'success' => '<span  onclick="remove_item('.$new_name.')" class="button dark-light square">
                    <img src="'.asset('/allscript/images/dashboard/close-icon-small.png').'" alt="close-icon">
                  </span>',
             'image'  => '<input type="hidden" form="main_form" name="main_file" value="'.$new_name.'"><a href="'.$new_name.'"/><i class="fa fa-paperclip" aria-hidden="true"></i> '.$new_name.' </a>'
            );

          return response()->json($output);
    }

     function image_upload(Request $request)
        {
            $rules = array(
                'phato'  => 'required|max:2048'
            );

            $error = Validator::make($request->all(), $rules);

            if($error->fails())
            {
                return response()->json(['errors' => $error->errors()->all()]);
            }
            $user_id = Auth::user()->id;
            $image_name = null;
            if($request->hasFile('phato')){
                $image = $request->file('phato');
                $image_name = time().rand('123456', '999999').".".$image->getClientOriginalExtension();
                $image_path = public_path('upload/images/thumb_img/'.$image_name );
                $image_resize = Image::make($image);
                $image_resize->resize(200, 115);
                $image_resize->save($image_path);
                $image_path = public_path('upload/images/'.$image_name );
                Image::make($image)->save($image_path);
            }
            $data = [
                'source_path' => $image_name,
                'type' => 1,
                'user_id' => $user_id,
            ];
            $insert = MediaGallery::create($data);
            $output = array(
                'success' => '<a href="#" onclick="remove_file('.$image_name.')" class="button dark-light square"></a>',
                'image'  => '<input type="file" class="dropify" onchange="uploadselectImage()" name="phato" id="input-file-events" data-default-file="'.asset('upload/images/'.$image_name).'">'
            );
            return response()->json($output);
        }



}
