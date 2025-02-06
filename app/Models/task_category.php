<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class task_category extends Model
{
    protected $connection = 'mysql';
    protected $table = 'task_category';
    protected $guarded = ['id'];
    
    public function validate($data)
    {
        $rules = array(
            'code' => 'required|unique:task_category,code,' . ($data['id'] ?? null) . ',id,deleted_at,NULL',
            'name' => 'required'
        );

        $v = Validator::make($data, $rules);
        return $v;
    }
}