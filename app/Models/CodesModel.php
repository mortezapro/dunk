<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CodesModel extends Model
{
    protected $table='tbl_codes';
    protected $primaryKey = 'code_id';
    protected $guarded=['code_id'];
    public $timestamps =false;
}
