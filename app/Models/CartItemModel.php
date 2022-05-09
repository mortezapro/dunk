<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItemModel extends Model
{
    protected $table='tbl_cart_items';
    protected $primaryKey = 'id';
    protected $guarded=['id'];
    public $timestamps = true;
    public function setUpdatedAtAttribute($value)
    {
        // to Disable updated_at
    }
}
