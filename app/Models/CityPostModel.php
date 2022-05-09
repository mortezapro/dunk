<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CityPostModel extends Model
{
    protected $table='tbl_price_post';
    protected $primaryKey = 'id';
    protected $guarded=['id'];
    public $timestamps =false;//
}
