<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RewardcatModel extends Model
{
    protected $table='tbl_reward_cat';
    protected $primaryKey = 'cat_id';
    protected $guarded=['cat_id'];
    public $timestamps =false;
}
