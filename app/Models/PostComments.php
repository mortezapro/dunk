<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostComments extends Model
{
    protected $table = 'tbl_post_comment';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    public $timestamps = true;
    protected $fillable = [
        'text','username ','status','post_id'
    ];
    public function setUpdatedAtAttribute($value)
    {
        // to Disable updated_at
    }
}
