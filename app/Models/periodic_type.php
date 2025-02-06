<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class periodic_type extends Model
{
    protected $connection = 'mysql';
    protected $table = 'periodic_type';
    protected $guarded = ['id'];
    
    public function validate($data)
    {
        $rules = array(
            'code' => 'required|unique:periodic_type,code,' . ($data['id'] ?? null) . ',id,deleted_at,NULL',
            'name' => 'required'
        );

        $v = Validator::make($data, $rules);
        return $v;
    }
}