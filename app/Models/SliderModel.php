<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SliderModel extends Model
{
    protected $table='tbl_slider';
    protected $primaryKey = 'slider_id';
    protected $guarded=['slider_id'];
    public $timestamps =false;
}
