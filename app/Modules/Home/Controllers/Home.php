<?php

namespace App\Modules\Home\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;
use GuzzleHttp\Client;
use DB;

class Home extends Controller {

    protected $controller_name;
    protected $libWorkflow;
    protected $employee;
    protected $employee_id;

    public function __construct()
    {
        $employee = Auth::user()->employee ?? null;

        $this->controller_name = 'Home';
        $this->employee = $employee;
        $this->position_code = $employee->job_position->code ?? null;
        $this->employee_id = $employee->id ?? null;

        view::share('controller_name', strtolower($this->controller_name));
        view::share('position_code', $this->position_code);
        view::share('employee_id', $employee->id ?? null);
    }

    public function index()
    {
        $date = date('Y-m-d');
        $template = 'index';

        $datas = \Models\task::select('task.id','task_status.code')
            ->leftJoin('task_status', function ($join) use($date){
                $join->on('task_status.id', '=', 'task.task_status_id');
            });

        // join user group
        if($this->position_code == 'SPV'){
            $datas->where('pic', $this->employee_id);
        }else{
            $datas->where('owner', $this->employee_id);
        }

        $datas = $datas->get();
        $all_job = $datas->count();
        $complete_job = $datas->where('code','COMP')->count();
        $notcomplete_job = $datas->where('code','!=','COMP')->count();
        
        $with['date'] = $date;
        $with['all_job'] = $all_job;
        $with['complete_job'] = $complete_job;
        $with['notcomplete_job'] = $notcomplete_job;
        return view($this->controller_name . '::' . $template,$with);
    }
}