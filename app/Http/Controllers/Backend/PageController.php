<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Reporter;
use Brian2694\Toastr\Facades\Toastr;
use Faker\Provider\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PageController extends Controller
{

    public function list()
    {
        $pages = Page::all();
        return view('backend.page-lists')->with(compact('pages'));
    }

    public function create()
    {
        return view('backend.pages');
    }


    public function store(Request $request)
    {
        $request->validate([
            'page_name_bd' => ['required'],
            'page_name_en' => ['required'],
            'template' => ['required'],
            'menu' => ['required'],
        ]);

      //dd($request->all());
        $user_id = Auth::user()->id;
        $image_name = [];
        if($request->hasFile('images')){

            $images = $request->file('images');
            foreach ($images as $image) {
                $new_name = time().rand('123456', '999999').".".$image->getClientOriginalExtension();
                $image->move(public_path('upload/images/pages/'), $new_name);
                array_push($image_name, $new_name);

            }
        }

        $data = [
            'page_name_bd' => $request->page_name_bd,
            'page_name_en' => $request->page_name_en,
            'page_slug' => str::slug($request->page_name_en),
            'page_dsc' =>$request->page_dsc,
            'template' =>$request->template,
            'menu' => $request->menu,
            'images' => implode(',', $image_name),
            'creator_id' => $user_id,
            'status' => ($request->status) ? '1' : '0',
        ];

        $insert = Page::create($data);
        if($insert){
            Toastr::success('Page Created Successfully.');

        }else{
            Toastr::success('Page Cann\'t Created.');
        }
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function show(Page $page)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Page $page)
    {
        //
    }

    public function delete($id)
    {
        $get_pages = Page::find($id);
        //delete Page from store folder
        if ($get_pages->images){
            $images = explode(',', $get_pages->images);
            // delete image from database
            foreach ($images as $image) {
                $file_path = public_path('upload/images/pages/' . $image);
                if (file_exists($file_path)) {
                    unlink($file_path);
                }
            }
        }

        $delete = $get_pages->delete();
        if($delete){
            echo "Page deleted successfull.";
        }else{
            echo "Sorry page delete failed.!";
        }
    }

}
