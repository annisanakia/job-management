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

    public function __construct() {
        $user = Auth::user() ?? null;
        $model = new taskModel;
        $controller_name = 'Task';

        $this->table_name = 'Task';
        $this->position_code = $user->employee->job_position->code ?? null;
        $this->user_id = $user->id ?? null;
        
        view::share('position_code', $this->position_code);
        view::share('user_id', $this->user_id);
        parent::__construct($model, $controller_name);
    }

    public function setDatas()
    {
        $datas = $this->model->select('task.*');

        // join user group
        if($this->position_code == 'SPV'){
            $datas->where('pic', $this->user_id);
        }else{
            $datas->where('owner', $this->user_id);
        }
        
        return $datas;
    }
}