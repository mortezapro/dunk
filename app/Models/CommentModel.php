<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommentModel extends Model
{
    protected $table = 'tbl_comments';
    protected $primaryKey = 'id';
    protected $fillable=['foreign_id','type','status','user_id','created_at','read_state','text'];
    public $timestamps = false;
    public function setUpdatedAt($value)
    {
        // Do nothing.
    }
}

