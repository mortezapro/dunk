<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookCatModel extends Model
{
    protected $table='tbl_book_cat';
    protected $primaryKey = 'category_id';
    protected $guarded=['category_id'];
    public $timestamps =false;
}
