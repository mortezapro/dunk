<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RewardModel extends Model
{
    protected $table='tbl_rewards';
    protected $primaryKey = 'reward_id';
    protected $guarded=['reward_id'];
    public $timestamps =false;
    public function requestReward()
    {
        return $this->hasMany(RequestRewardModel::class,'reward_id');
    }
}
