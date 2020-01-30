<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $get_category = Category::all();
        return view('backend.category-list')->with(compact('get_category'));
    }


    public function create()
    {
        return view('backend.category');
    }


    public function store(Request $request)
    {
        $request->validate([
            'category_bd' => 'required',
            'category_en' => 'required',
        ]);
        $creator_id = Auth::user()->id;
        $cat_slug_en = str_slug($request->category_en);
        $cat_slug_bd = preg_replace('/\s+/u', '-', trim($request->category_bd));
        $data = [
            'category_bd' => $request->category_bd,
            'cat_slug_bd' => $cat_slug_bd,
            'category_en' => $request->category_en,
            'cat_slug_en' => $cat_slug_en,
            'creator_id' => $creator_id,
            'status' => ($request->status) ? '1' : '0',
        ];
        $insert = Category::create($data);
        Toastr::success('Category created.');
        return back();
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $data = Category::find($id);
        echo view('backend.edit-form.category-edit')->with(compact('data'));
    }

    public function update(Request $request)
    {

        $request->validate([
            'category_bd' => 'required',
            'category_en' => 'required',
        ]);

        $creator_id = Auth::user()->id;
        $cat_slug_en = str_slug($request->category_en);
        $cat_slug_bd = preg_replace('/\s+/u', '-', trim($request->category_bd));
        $data = [
            'category_bd' => $request->category_bd,
            'cat_slug_bd' => $cat_slug_bd,
            'category_en' => $request->category_en,
            'cat_slug_en' => $cat_slug_en,
            'creator_id' => $creator_id,
            'status' => ($request->status) ? '1' : '0',
        ];
        $update = Category::where('id', $request->id)->update($data);
        if($update){
            Toastr::success('Category update successfull.');
        }else{
            Toastr::success('Sorry category can\'t updated.');
        }

        return back();
    }


    public function delete($id)
    {
        $delete =  Category::find($id)->delete();
        if($delete){
            echo 'Category delete successfull.';
        }else{
            echo 'Sorry category not deleted.';
        }
    }

    public function select(Request $request){
        //echo $request->q;
        $get_category = Category::select('id', 'name')->get();
        echo json_encode($get_category);
    }
}
