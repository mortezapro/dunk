<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JoinCatBook extends Model
{

    protected $table = 'tbl_book_cat_join';
    protected $primaryKey = 'id';
    protected $fillable=['category_id','book_id'];
    public $timestamps = false;
}
