<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    protected $table='tbl_users';
    protected $primaryKey = 'user_id';
    protected $guarded=['user_id'];
    public $timestamps =false;
    public function request()
    {
        return $this->hasMany(RequestmoneyModel::class,'user_id');
    }
        public function requestReward()
    {
        return $this->hasMany(RequestRewardModel::class,'user_id');
    }
}
