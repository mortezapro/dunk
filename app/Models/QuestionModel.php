<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionModel extends Model
{
    protected $table='tbl_question';
    protected $primaryKey = 'question_id';
    protected $guarded=['question_id'];
    public $timestamps =false;
}
