<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiscountModel extends Model
{
    protected $table = 'tbl_discount';
    protected $primaryKey = 'id';
    protected $fillable=['discount_code','status','percent','from_date','to_date','user_id','created_at'];
    public $timestamps = true;
    const UPDATED_AT = null;

    public function setUpdatedAt($value)
    {
        // Do nothing.
    }
}
