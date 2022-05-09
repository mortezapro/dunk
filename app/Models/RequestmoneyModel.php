<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestmoneyModel extends Model
{
    protected $table='tbl_request_money';
    protected $primaryKey = 'request_id';
    protected $guarded=['request_id'];
    public $timestamps =false;
    public function users()
    {
        return $this->belongsTo(UserModel::class,'request_user_id');
    }
}