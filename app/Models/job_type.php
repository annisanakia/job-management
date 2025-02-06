<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class job_type extends Model
{
    protected $connection = 'mysql';
    protected $table = 'job_type';
    protected $guarded = ['id'];
    
    public function validate($data)
    {
        $rules = array(
            'code' => 'required|unique:job_type,code,' . ($data['id'] ?? null) . ',id,deleted_at,NULL',
            'name' => 'required'
        );

        $v = Validator::make($data, $rules);
        return $v;
    }
}