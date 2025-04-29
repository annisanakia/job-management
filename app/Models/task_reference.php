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
            'jobdesk' => 'required',
            'task_category_id' => 'required',
            'job_type_id' => 'required',
            'sla_duration' => 'required',
            'staff_ids' => 'required',
            'msco_ids' => 'required'
        );

        $messages = [
            'msco_ids.required' => ' The msco field is required.',
            'staff_ids.required' => 'The staff field is required',
        ];

        $v = Validator::make($data, $rules);
        return $v;
    }
    
    public function task_category()
    {
        return $this->belongsTo('Models\task_category');
    }

    public function job_type()
    {
        return $this->belongsTo('Models\job_type');
    }

    public function task_reference_staffs()
    {
        return $this->hasMany('Models\task_reference_staff');
    }

    public function task_reference_mscos()
    {
        return $this->hasMany('Models\task_reference_msco');
    }
}