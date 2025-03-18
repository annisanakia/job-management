<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class task extends Model
{
    protected $connection = 'mysql';
    protected $table = 'task';
    protected $guarded = ['id'];
    
    public function validate($data)
    {
        $rules = array(
            // 'code' => 'required|unique:task,code,' . ($data['id'] ?? null) . ',id,deleted_at,NULL',
            'date' => 'required',
            'task_reference_id' => 'required',
            'sla_duration' => 'required',
            'quantity' => 'required',
            'pic' => 'required'
        );

        $v = Validator::make($data, $rules);
        return $v;
    }

    public function task_segment()
    {
        return $this->belongsTo('Models\task_segment');
    }

    public function task_category()
    {
        return $this->belongsTo('Models\task_category');
    }

    public function task_status()
    {
        return $this->belongsTo('Models\task_status');
    }

    public function job_type()
    {
        return $this->belongsTo('Models\job_type');
    }

    public function periodic_type()
    {
        return $this->belongsTo('Models\periodic_type');
    }

    public function employee_pic()
    {
        return $this->belongsTo('Models\employee', 'pic', 'id');
    }

    public function employee_owner()
    {
        return $this->belongsTo('Models\employee', 'owner', 'id');
    }
}