<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizModel extends Model
{
    protected $table='tbl_quiz';
    protected $primaryKey = 'quiz_id';
    protected $guarded=['quiz_id'];
    public $timestamps =false;
}
