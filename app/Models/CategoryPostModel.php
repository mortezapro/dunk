<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryPostModel extends Model
{
    protected $table = 'tbl_post_category';
    protected $primaryKey = 'category_id';
    protected $fillable=['category_name','category_slug','category_media'];
    public $timestamps = false;


}
