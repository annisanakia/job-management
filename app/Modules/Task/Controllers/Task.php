<?php
namespace App\Modules\Task\Controllers;

use \Models\task as taskModel;
use Lib\core\RESTful;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Datetime;

class Task extends RESTful {
    protected $position_code;
    protected $user_id;
    protected $employee_id;

    public function __construct() {
        $user = Auth::user() ?? null;
        $model = new taskModel;
        $controller_name = 'Task';
        $employee = $user->employee ?? null;

        $this->table_name = 'Task';
        $this->position_code = $employee->job_position->code ?? null;
        $this->employee_id = $employee->id ?? null;
        $this->user_id = $user->id ?? null;
        
        $this->module_name = 'Task Job';
        
        view::share('position_code', $this->position_code);
        view::share('employee_id', $employee->id ?? null);
        view::share('user_id', $this->user_id);
        parent::__construct($model, $controller_name);
    }

    public function setDatas()
    {
        $datas = $this->model->select('task.*');

        // join user group
        if($this->position_code == 'SPV'){
            $datas->where('pic', $this->employee_id);
        }else{
            $datas->where('owner', $this->employee_id);
        }
        
        return $datas;
    }

    public function store()
    {
        $input = request()->all();
        $validation = $this->model->validate($input);

        if ($validation->passes()) {
            $start_date = date('Y-m-d H:i:s');
            $total_sla_duration = (is_numeric(request()->quantity) ? request()->quantity : 0) * (is_numeric(request()->sla_duration) ? request()->sla_duration : 0);
            
            $duedate = new DateTime($start_date);
            $duedate->modify("+".$total_sla_duration." minutes"); 
            
            $input['start_date'] = $start_date;
            $input['duedate'] = $duedate;

            $this->model->create($input);
            return Redirect::route(strtolower($this->controller_name) . '.index');
        }
        return Redirect::route(strtolower($this->controller_name) . '.create')
            ->withInput()
            ->withErrors($validation)
            ->with('message', 'There were validation errors.');
    }

    public function update($id)
    {
        $input = request()->all();
        $input['id'] = $id;
        
        $validation = $this->model->validate($input);

        if ($validation->passes()) {
            $data = $this->model->find($id);
            $start_date = $data->start_date;
            $total_sla_duration = (is_numeric(request()->quantity) ? request()->quantity : 0) * (is_numeric(request()->sla_duration) ? request()->sla_duration : 0);
            
            $duedate = new DateTime($start_date);
            $duedate->modify("+".$total_sla_duration." minutes"); 
            
            $input['duedate'] = $duedate;

            $data->update($input);
            return Redirect::route(strtolower($this->controller_name) . '.index');
        }

        return Redirect::route(strtolower($this->controller_name) . '.edit', $id)
            ->withInput()
            ->withErrors($validation)
            ->with('message', 'There were validation errors.');
    }

    public function getSLA(){
        $task_category_id = request()->task_category_id;
        $job_type_id = request()->job_type_id;

        $task_reference = \Models\task_reference::where('task_category_id', $task_category_id)
            ->where('job_type_id', $job_type_id)
            ->get();
            
        $task_reference_own = $task_reference->where('msco_id',$this->employee_id)->first();
        $task_reference = $task_reference->first();

        $task_reference = $task_reference_own ?? $task_reference;
        
        return [
            'jobdesk'=>$task_reference->jobdesk ?? null,
            'sla_duration'=>$task_reference->sla_duration ?? null
        ];
    }

    public function updateCompleted($id){
        $task_status = \Models\task_status::where('code','COMP')->first();

        $data = \Models\task::find($id);
        $start_date = $data->start_date ?? null;
        $end_date = date('Y-m-d H:i:s');
        
        $start = new DateTime($start_date);
        $end = new DateTime($end_date);

        $diff = $start->diff($end);
        $totalMinutes = ($diff->days * 24 * 60) + ($diff->h * 60) + $diff->i;

        $data->end_date = $end_date;
        $data->task_status_id = $task_status->id ?? 1;
        $data->task_duration = $totalMinutes;
        $data->overdue = $data->sla_duration*$data->quantity < $totalMinutes? 1 : 0;
        $data->save();
        
        return Redirect::route(strtolower($this->controller_name) . '.index');
    }

    public function updateFlag($id){
        $data = \Models\task::find($id);
        $data->flag = 1;
        $data->save();

        return Redirect::route(strtolower($this->controller_name) . '.index');
    }
}