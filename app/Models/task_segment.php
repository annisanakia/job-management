<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class task_segment extends Model
{
    protected $connection = 'mysql';
    protected $table = 'task_segment';
    protected $guarded = ['id'];
    
    public function validate($data)
    {
        $rules = array(
            'code' => 'required|unique:task_segment,code,' . ($data['id'] ?? null) . ',id,deleted_at,NULL',
            'name' => 'required'
        );

        $v = Validator::make($data, $rules);
        return $v;
    }
}