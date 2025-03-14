<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class task_reference extends Model
{
    protected $connection = 'mysql';
    protected $table = 'task_reference';
    protected $guarded = ['id'];
    
    public function validate($data)
    {
        $rules = array(
            'sla_duration' => 'required'
        );

        $v = Validator::make($data, $rules);
        return $v;
    }
}