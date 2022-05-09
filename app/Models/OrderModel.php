<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderModel extends Model
{
    protected $table='tbl_orders';
    protected $primaryKey = 'order_id';
    protected $guarded=['order_id'];
    public function book()
    {
        return $this->belongsTo(BookModel::class,'book_id');
    }
     public function users()
    {
        return $this->belongsTo(UserModel::class,'user_id');
    }

}
