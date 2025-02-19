<?php
namespace App\Modules\Task\Controllers;

use \Models\task as taskModel;
use Lib\core\RESTful;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

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
}