<?php
namespace App\Modules\Report\Controllers;

use DB;
use \Models\task as taskModel;
use Lib\core\RESTful;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class Report extends RESTful {
    protected $position_code;
    protected $user_id;
    protected $employee_id;

    public function __construct() {
        $user = Auth::user() ?? null;
        $model = new taskModel;
        $controller_name = 'Report';
        $employee = $user->employee ?? null;

        $this->table_name = 'Task';
        $this->position_code = $employee->job_position->code ?? null;
        $this->employee_id = $employee->id ?? null;
        $this->user_id = $user->id ?? null;
        
        $this->module_name = 'Report Job';
        
        view::share('position_code', $this->position_code);
        view::share('employee_id', $employee->id ?? null);
        view::share('user_id', $this->user_id);
        parent::__construct($model, $controller_name);
    }

    public function getReport()
    {
        $report_by = request()->report_by ?? null;
        if($report_by == 1){
            return $this->getListByEmployee();
        }elseif($report_by == 2){
            return $this->getListBySegment();
        }else{
            return $this->getListByStatus();
        }
    }

    public function processFilter($datas)
    {
        $employee_ids = request()->employee_ids ?? [];
        $supervisor_ids = request()->supervisor_ids ?? [];
        $task_status_ids = request()->task_status_ids ?? [];
        $start_date = request()->start_date ?? null;
        $end_date = request()->end_date ?? null;

        if(count($employee_ids) > 0){
            $datas->whereIn('owner',$employee_ids);
        }
        if(count($supervisor_ids) > 0){
            $datas->whereIn('pic',$supervisor_ids);
        }
        if(count($task_status_ids) > 0){
            $datas->whereIn('task_status_id',$task_status_ids);
        }
        if($start_date){
            $datas->where('date','>=',$start_date);
        }
        if($end_date){
            $datas->where('date','<=',$end_date);
        }

        return $datas;
    }

    public function getListByEmployee()
    {
        $datas = $this->model->select(['*']);

        $datas = $this->processFilter($datas);

        $table = $this->table_name != '' ? $this->table_name : strtolower($this->controller_name);
        $this->filter($datas, request()->filters, $table);
        $this->order($datas, request()->sort_field, request()->sort_type);

        $this->max_row = request()->input('max_row') ?? $this->max_row;
        $this->filter_string = http_build_query(request()->all());
        
        $this->beforeIndex($datas);

        $datas = $datas->paginate($this->max_row);
        $datas->chunk(100);

        $datas_graph = $this->getGraphByEmployee();

        $url_pdf = strtolower($this->controller_name) . '/getListAsPdf?' . $this->filter_string;
        $url_xls = strtolower($this->controller_name) . '/getListAsXls?' . $this->filter_string;
        $action[] = array('name' => '', 'url' => $url_pdf, 'class' => 'btn btn-outline-danger float-end me-2', 'attr'=>'target=_blank', 'icon' => 'fas fa-file-pdf');
        $action[] = array('name' => '', 'url' => $url_xls, 'class' => 'btn btn-outline-success float-end me-2', 'attr'=>'target=_blank', 'icon' => 'fas fa-file-excel');

        $with['datas'] = $datas;
        $with['param'] = request()->all();
        $with['filters'] = request()->filters;
        $with['sort_field'] = request()->sort_field;
        $with['sort_type'] = request()->sort_type > 2? 0 : request()->sort_type;
        $with['datas_graph'] = $datas_graph;
        $with['max_row'] = $this->max_row;
        $with['actions'] = $this->actions;
        return View($this->controller_name . '::getListByEmployee' , $with);
    }

    public function getGraphByEmployee()
    {
        $graph_complete = $this->model->from('task');
        $graph_complete = $this->processFilter($graph_complete);

        $graph_notcomplete = $this->model->from('task');
        $graph_notcomplete = $this->processFilter($graph_notcomplete);

        $graph_complete->whereHas('task_status',function($builder){
            $builder->where('code','COMP');
        });
        $graph_notcomplete->whereHas('task_status',function($builder){
            $builder->where('code','!=','COMP');
        });
        
        $table = $this->table_name != '' ? $this->table_name : strtolower($this->controller_name);
        $this->filter($graph_complete, request()->filters, $table);
        $this->filter($graph_notcomplete, request()->filters, $table);

        $this->beforeIndex($graph_complete);
        $this->beforeIndex($graph_notcomplete);

        if($this->position_code == 'SPV'){
            $graph_complete = $graph_complete->select(['owner as key', DB::raw('COUNT(*) as total')])->groupBy('owner')->pluck('total','key');
            $graph_notcomplete = $graph_notcomplete->select(['owner as key', DB::raw('COUNT(*) as total')])->groupBy('owner')->pluck('total','key');
        }else{
            $graph_complete = $graph_complete->select(['pic as key', DB::raw('COUNT(*) as total')])->groupBy('pic')->pluck('total','key');
            $graph_notcomplete = $graph_notcomplete->select(['pic as key', DB::raw('COUNT(*) as total')])->groupBy('pic')->pluck('total','key');
        }
        
        $employees = \Models\employee::select('employee.id','employee.name');
        if($this->position_code == 'SPV'){
            $employees->whereHas('job_position', function($builder){
                $builder->where('code','EMP');
            });
        }else{
            $employees->whereHas('job_position', function($builder){
                $builder->where('code','SPV');
            });
        }
        $employees = $employees->get();

        $labels = [];
        $datasets_complete = [];
        $datasets_notcomplete = [];
        foreach($employees as $row){
            $labels[] = $row->name;
            $datasets_complete[] = $graph_complete[$row->id] ?? 0;
            $datasets_notcomplete[] = $graph_notcomplete[$row->id] ?? 0;
        }

        // $start_date = request()->start_date;
        // $end_date = request()->end_date;

        // $interval = DateInterval::createFromDateString('1 day');
        // // $end_week = new DateTime(date('Y-m-d', strtotime('+'.(8-$day).' days')));
        // $end_week = request()->end_date ?? date('Y-m-d', strtotime('+'.(7-$day).' days'));
        // $end_week = new DateTime(date('Y-m-d', strtotime($end_week . ' +1 day')));
        // $date_range = new DatePeriod($start_date, $interval, $end_week);

        // $dates = [];
        // $dataByDates = [];
        // foreach ($date_range as $dt) {
        //     $date = $dt->format('Y-m-d');
        //     $dates[] = dateToIndo($date);
        //     $dataByDates[] = $collection_datas[$date] ?? 0;
        // }
        // dd($employee);

        return ['labels'=>$labels,'datasets_complete'=>$datasets_complete,'datasets_notcomplete'=>$datasets_notcomplete];
    }

    public function getListBySegment()
    {
        
    }

    public function getListByStatus()
    {
    }

}