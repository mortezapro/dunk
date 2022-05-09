<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageModel extends Model
{
    protected $table='tbl_message';
    protected $primaryKey = 'message_id';
    protected $guarded=['message_id'];
    public $timestamps =false;
}
