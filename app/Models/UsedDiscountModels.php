<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsedDiscountModels extends Model
{
    protected $table='used_discount';
    protected $primaryKey = 'id';
    protected $guarded=['id'];
    public $timestamps =true;
    public function setUpdatedAtAttribute($value)
    {
        // to Disable updated_at
    }
}
