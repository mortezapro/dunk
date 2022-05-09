<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookModel extends Model
{
    protected $table='tbl_books';
    protected $primaryKey = 'book_id';
    protected $guarded=['book_id'];
    public $timestamps =false;
    public function order()
    {
        return $this->hasMany(OrderModel::class,'book_id');
    }
}
