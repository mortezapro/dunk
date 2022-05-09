<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopcatModel extends Model
{
    protected $table='tbl_shop_cat';
    protected $primaryKey = 'cat_id';
    protected $guarded=['cat_id'];
    public $timestamps =false;

}
