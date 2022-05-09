<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingModel extends Model
{
    protected $table='tbl_setting';
    protected $primaryKey = 'setting_id';
    protected $guarded=['setting_id'];
    public $timestamps =false;
}
