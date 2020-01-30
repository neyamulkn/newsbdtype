<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $guarded = [];

    public function reporter(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function categoryList(){
        return $this->belongsTo(Category::class, 'category');
    }
    public function subcategoryList(){
        return $this->hasOne(SubCategory::class, 'id', 'subcategory'); //for hasOne first join tbl collum name then primary key collum name
    }
    public function image(){
        return $this->hasOne(MediaGallery::class, 'id', 'thumb_image');
    }
    public function comment(){
        return $this->hasMany(Comment::class, 'news_id');
    }
    public function attachFiles(){
        return $this->hasMany(MediaGallery::class, 'type');
    }
    public function video(){
        return $this->hasOne(MediaGallery::class, 'id', 'video');
    }
}
