<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostModel extends Model
{
    protected $table = 'tbl_posts';
    protected $primaryKey = 'id';
    protected $fillable=['category_id','title','description','slug','media','status','view_count','created_at','updated_at'];
    public $timestamps = true;
}
