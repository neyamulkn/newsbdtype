<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Deshjure;
use App\Models\MediaGallery;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AjaxController extends Controller
{
    public function get_subcategoryBy_id($id)
    {
        $output = '';
        $get_subcategory= Category::find($id)->subcategory;
        if(count($get_subcategory)>0){
            $output .= '<div class="form-group">
                           <select onchange="get_district(this.value)" name="subcategory" id="subcategory" class="form-control custom-select">
                                <option selected value="0">Sub category</option>';
            foreach($get_subcategory as $show_subcategory){
                $output .='<option value="'.$show_subcategory->id.'">'.$show_subcategory->subcategory_bd.'</option>';
            }
            $output .=  ' </select>
                        </div>';
        }

        echo $output;
    }

    public function get_district($id=null)
    {
        $output = '';
        $get_districts = Deshjure::where('parent_id', $id)->where('cat_type', 1)->get();
        if(count($get_districts)>0){
            $output .= '<div class="form-group">
                            <select onchange="get_upzilla(this.value)" name="district" id="district" class="form-control custom-select">
                                <option selected value="0">'.__('lang.zilla').'</option>';
            foreach($get_districts as $get_district){
                $output .='<option value="'.$get_district->id.'">'.$get_district->name_bd.'</option>';
            }
            $output .=  ' </select>
                        </div>';
        }
        echo $output;
    }


    public function get_upzilla($id=null)
    {
        $output = '';
        $get_upzilla= Deshjure::where('parent_id', $id)->where('cat_type', 2)->get();
        if(count($get_upzilla)>0){
            $output .= '<div class="form-group">
                            <select name="upzilla" id="upzilla" class="form-control custom-select"><option selected value="0">'.__('lang.upzilla').'</option>';
            foreach($get_upzilla as $show_upzilla){
                $output .='<option value="'.$show_upzilla->id.'">'.$show_upzilla->name_bd.'</option>';
            }
            $output .=  '</select>
                    </div>';
        }
        echo $output;
    }



   //deshjure search route  // for home page and sitebar

   public function deshjure_district($slug)
    {
        $output = '';
        $get_districts = DB::table('deshjures')->join('sub_categories', 'deshjures.parent_id', 'sub_categories.id')->where('sub_categories.subcat_slug_en', $slug)->where('deshjures.cat_type', 1)->get();
        if(count($get_districts)>0){
            $output .= '<div class="form-group">
                            <select onchange="get_upzilla(this.value)" name="district" id="district" class="form-control custom-select">
                                <option selected value="0">'.__('lang.zilla').'</option>';
            foreach($get_districts as $get_district){
                $output .='<option value="'.$get_district->slug_en.'">'.$get_district->name_bd.'</option>';
            }
            $output .=  ' </select>
                        </div>';
        }
        echo $output;
    }


    public function deshjure_upzilla($slug)
    {
        $output = '';
        $zilla = Deshjure::where('slug_en', $slug)->first();

        $get_upzilla= DB::table('deshjures')->where('parent_id', $zilla->id)->where('deshjures.cat_type', 2)->get();
        if(count($get_upzilla)>0){
            $output .= '<div class="form-group">
                            <select name="upzilla" id="upzilla" class="form-control custom-select"><option selected value="0">'.__('lang.upzilla').'</option>';
            foreach($get_upzilla as $show_upzilla){
                $output .='<option value="'.$show_upzilla->name_en.'">'.$show_upzilla->name_bd.'</option>';
            }
            $output .=  '</select>
                    </div>';
        }
        echo $output;
    }







// get image for news upload page under model
    public function imageGallery(){
        $images = MediaGallery::orderBy('id', 'DESC')->take(24)->get();

        if($images){
            foreach ($images as $image){
                echo '<div class="col-md-2 col-4 col-sm-3">
                    <div class="gallery-card">
                        <div class="gallery-card-body" onclick="image_details(\''.$image->source_path.'\',\''.$image->title.'\')">
                            <label class="block-check">
                                <img src="'.asset('upload/images/thumb_img/'.$image->source_path).'" class="img-responsive" />
                                <input value="'.$image->id.'" type="radio" name="imageId">
                                <span class="checkmark"></span>
                            </label>
                            <div class="mycard-footer">
                                <a href="#" class="card-link">'.str_limit($image->title, 8).'</a>
                            </div>
                        </div>
                    </div>
                </div>';
            }
        }
    }

    public function videoGallery(){

    }
}
