<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactUsModel extends Model
{
    protected $table='tbl_request';
    protected $primaryKey = 'request_id';
    protected $guarded=['request_id'];
    public $timestamps =false;
}