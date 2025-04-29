<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\SoftDeletes;

class task_reference_msco extends Model
{
    use SoftDeletes;

    protected $connection = 'mysql';
    protected $table = 'task_reference_msco';
    protected $guarded = ['id'];
    
    public static $rules = array(
        'employee_id' => 'required',
        'task_reference_id' => 'required',
    );

    public function employee()
    {
        return $this->belongsTo('Models\employee');
    }

    public function task_reference()
    {
        return $this->belongsTo('Models\task_reference');
    }

}