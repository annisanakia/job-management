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
            
            $task_reference = \Models\task_reference::find(request()->task_reference_id);
            $input['jobdesk'] = $task_reference->jobdesk ?? null;

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

            $task_reference = \Models\task_reference::find(request()->task_reference_id);
            $input['jobdesk'] = $task_reference->jobdesk ?? null;
            
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
    
    public function getSLA()
    {
        $task_category_id = request()->task_category_id;
        $job_type_id = request()->job_type_id;
        $id = request()->id;

        $target = request()->target ?? 'task_reference_id';
        $blank = request()->blank ?? false;

        $user = \Auth::user();
        $datas = \Models\task_reference::where('task_category_id', $task_category_id)
                ->where('job_type_id', $job_type_id)
                ->where('msco_id',$this->user_id)
                ->orderBy('jobdesk', 'asc')
                ->get()->pluck('jobdesk','id')->all();

        if(count($datas) <= 0){
            $datas = \Models\task_reference::where('task_category_id', $task_category_id)
                    ->where('job_type_id', $job_type_id)
                    ->orderBy('jobdesk', 'asc')
                    ->get()->pluck('jobdesk','id')->all();
        }

        return $this->coreLib->renderList($datas, $target, $id, $blank);
    }

    public function setDuration(){
        $task_reference_id = request()->task_reference_id;

        $task_reference = \Models\task_reference::find($task_reference_id);
        
        return [
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
        $overdue = $data->sla_duration*$data->quantity < $totalMinutes? 1 : 0;

        if($overdue == 1){
            return Redirect::route(strtolower($this->controller_name) . '.index')
                ->with([
                    'error'=> 1,
                    'message_error'=> 'Update Last Status Failed',
                    'submessage_error'=> $data->jobdesk.'<br> sudah overdue! silahkan kontak PIC anda'
                ]);
        }

        $data->end_date = $end_date;
        $data->task_status_id = $task_status->id ?? 1;
        $data->task_duration = $totalMinutes;
        $data->overdue = $overdue;
        $data->save();

        return Redirect::route(strtolower($this->controller_name) . '.index')
            ->with([
                'success'=> 1,
                'message_success'=> 'Completed '.($data->jobdesk)
            ]);
    }

    public function updateFlag($id){
        $data = \Models\task::find($id);
        $data->flag = 1;
        $data->save();

        $notification = new \Models\notification();
                
        $input['pic_user_id'] = $data->employee_owner->user_id ?? null;
        $input['user_id'] = $data->employee_pic->user_id ?? null;
        $input['task_id'] = $data->id ?? null;
        $input['title'] = $data->jobdesk.' '.($data->employee_owner->name ?? null);
        $input['message'] = $data->jobdesk.' '.($data->employee_owner->name ?? null).' memiliki kendala</b>';
        $input['link'] = '/task/detail/'.($data->id);
        $input['datetime'] = date('Y-m-d H:i:s');

        $notification->create($input);

        return Redirect::route(strtolower($this->controller_name) . '.index');
    }

    public function updatePeriod($id){
        $task_status = \Models\task_status::where('code','COMP')->first();

        $data = \Models\task::find($id);
        $start_date = request()->start_date;
        $end_date = request()->end_date;
        $task_status_id = request()->task_status_id ?? 1;
        
        $data->task_duration = null;
        $data->overdue = null;
        if($start_date != '' && $end_date != '' && $task_status_id == 1){
            $start = new DateTime($start_date);
            $end = new DateTime($end_date);
    
            $diff = $start->diff($end);
            $totalMinutes = ($diff->days * 24 * 60) + ($diff->h * 60) + $diff->i;
            $overdue = $data->sla_duration*$data->quantity < $totalMinutes? 1 : 0;
    
            $data->task_duration = $totalMinutes;
            $data->overdue = $overdue;
        }
        $data->start_date = $start_date;
        $data->end_date = $end_date;
        $data->task_status_id = $task_status_id;
        $data->save();

        return Redirect::route(strtolower($this->controller_name) . '.detail', $id)
            ->with([
                'success'=> 1
            ]);
    }
}