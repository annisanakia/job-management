<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class group extends Model
{

    protected $connection = 'mysql';
    protected $table = 'group';
    protected $guarded = ['id'];
    
    public function validate($data)
    {
        $rules = array(
            'code' => 'required|unique:group,code,' . ($data['id'] ?? null) . ',id,deleted_at,NULL',
            'name' => 'required'
        );

        $v = Validator::make($data, $rules);
        return $v;
    }
}