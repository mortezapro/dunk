<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestRewardModel extends Model
{
    protected $table='tbl_reward_request';
    protected $primaryKey = 'request_id';
    protected $guarded=['request_id'];
    public $timestamps =false;
    public function users()
    {
        return $this->belongsTo(UserModel::class,'user_id');
    }
        public function reward()
    {
        return $this->belongsTo(RewardModel::class,'reward_id');
    }
    
}
