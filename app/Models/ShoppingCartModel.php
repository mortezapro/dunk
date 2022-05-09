<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShoppingCartModel extends Model
{
    protected $table='tbl_shopping_cart';
    protected $primaryKey = 'id';
    protected $guarded=['id'];
    protected $fillable=['user_id','total_price','discount_code','city_id'];
    public $timestamps =true;
    public function setUpdatedAtAttribute($value)
    {
        // to Disable updated_at
    }
}
