<?php

namespace Lib\workflow;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;

class libWorkflow extends Controller
{
    protected $model_workflow_activity;
    protected $model_workflow_activity_task;
    protected $workflow_activity;
    protected $workflow_activitys;
    protected $date;
    protected $month_now;
    protected $year_now;
    protected $start_week;
    protected $end_week;

    public function __construct()
    {
        $this->date = date('Y-m-d');
        $this->model_workflow_activity = new \Models\workflow_activity();
        $this->model_workflow_activity_task = new \Models\workflow_activity_task();
    }

    public function setDate($date)
    {
        $this->date = $date;
        $this->month_now = date('n', strtotime($this->date));
        $this->year_now = date('Y', strtotime($this->date));

        $this->start_week = Carbon::parse($this->date)->startOfWeek()->toDateString();
        $this->end_week = Carbon::parse($this->date)->endOfWeek()->toDateString();
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getWorkflowRecords()
    {
        return $this->workflow_activitys ?? [];
    }

    public function getWorkflowRecord()
    {
        return $this->workflow_activity;
    }

    public function getWorkflowRecordId()
    {
        return $this->workflow_activity->id ?? null;
    }

    public function workflowRecord($workflow_id = null)
    {
        $workflow_activitys = \Models\workflow_activity::select('workflow_activity.*')->leftJoin('workflow', function ($join) {
                    $join->on('workflow.id', '=', 'workflow_activity.workflow_id')->whereNull('workflow.deleted_at');
                })
                ->where(function($query){
                    $query->where('date_type',1)
                        ->where('date',$this->date);

                    $query->orWhere('date_type',2)
                        ->where('date','>=',$this->start_week)
                        ->where('date','<=',$this->end_week);

                    $query->orWhere('date_type',3)
                        ->whereMonth('date',$this->month_now);

                    $query->orWhere('date_type',4)
                        ->whereYear('date',$this->year_now);
                });
        if($workflow_id != ''){
            $workflow_activity = $workflow_activitys->where('workflow_id',$workflow_id)->first();
            $this->workflow_activity = $workflow_activity;
        }else{
            $workflow_activitys = $workflow_activitys->get();
            $this->workflow_activitys = $workflow_activitys;
        }

        return $this;
    }

    public function updateRecord($workflow){
        try{
            $workflow_activity = $this->workflowRecord($workflow->id)->getWorkflowRecord();
            
            if(!$workflow_activity){
                $input['workflow_id'] = $workflow->id;
                $input['date'] = $this->date;
                $input['start_date'] = date('Y-m-d');
                $input['status'] = 0; // in progress
                $workflow_activity = $this->model_workflow_activity->create($input);
                $this->workflow_activity = $workflow_activity;
            }else{
                $this->workflow_activity = $workflow_activity;
            }

            if($workflow_activity){
                $this->updateRecordTask($workflow, $workflow_activity);
            }
        }catch (\Exception $e) {
            \Log::error('Something wrong: ' . $e->getMessage());
        }

        return $this;
    }

    public function updateRecordTask($workflow, $workflow_activity){
        $workflow_tasks = $this->getTasks($workflow->id, $workflow_activity->id);

        $workflow_activity_task_ids = [];
        foreach($workflow_tasks as $workflow_task){
            $workflow_activity_task_ids[] = $workflow_task->workflow_activity_task_id;
            if($workflow_task->workflow_activity_task_id == ''){
                $input['workflow_activity_id'] = $workflow_activity->id;
                $input['workflow_task_id'] = $workflow_task->id;
                $input['status'] = 0;
                $workflow_activity_task = $this->model_workflow_activity_task->create($input);
                $workflow_activity_task_ids[] = $workflow_activity_task->id;
            }
        }

        $this->model_workflow_activity_task->where('workflow_activity_id',$workflow_activity->id)
                ->whereNotIn('id',$workflow_activity_task_ids)->delete();

        return $this;
    }

    public function getTasks($workflow_id, $workflow_activity_id)
    {
        $workflow_tasks = \Models\workflow_task::select(
                    'name','workflow_task.id',
                    'workflow_activity_task.id as workflow_activity_task_id',
                    'workflow_activity_task.status', 'workflow_task.sequence'
                )
                ->with('workflow_activity_task')
                ->where('workflow_task.workflow_id',$workflow_id)
                ->leftJoin('workflow_activity_task', function ($join) use($workflow_activity_id){
                    $join->on('workflow_activity_task.workflow_task_id', '=', 'workflow_task.id')
                        ->where('workflow_activity_id',$workflow_activity_id)->whereNull('workflow_activity_task.deleted_at');
                })
                ->where('workflow_task.status',1)
                ->orderBy('sequence')
                ->orderBy('workflow_task.id')
                ->get();
        return $workflow_tasks;
    }

    public function checkAccess($datas, $employee)
    {
        // from table workflow
        $employee_id = $employee->id ?? null;
        $job_role_ids = session()->get('job_role_ids');

        $position_code = $employee->position_active->job_position->code ?? 'EMP';
        $department_id = $employee->department_active->department_id ?? null;
        $division_id = $employee->department_active->department->division_id ?? null;

        if($position_code == 'MDP'){
            $datas->whereHas('workflow_tasks', function($builder) use($department_id){
                $builder->where(function($query) use($department_id){
                    $query->whereHas('workflow_task_roles', function($builder) use($department_id){
                        $builder->whereHas('job_role', function($builder) use($department_id){
                            $builder->where('department_id',$department_id);
                        });
                    })->orWhereHas('workflow_task_employees', function($builder) use($department_id){
                        $builder->whereHas('employee', function($builder) use($department_id){
                            $builder->whereHas('department_active', function($builder) use($department_id){
                                $builder->where('department_id',$department_id);
                            });
                        });
                    });
                })->where('workflow_task.status',1);
            });
        }elseif($position_code == 'MDV'){
            $datas->whereHas('workflow_tasks', function($builder) use($division_id){
                $builder->where(function($query) use($division_id){
                    $query->whereHas('workflow_task_roles', function($builder) use($division_id){
                        $builder->whereHas('job_role', function($builder) use($division_id){
                            $builder->whereHas('department', function($builder) use($division_id){
                                $builder->where('division_id',$division_id);
                            });
                        });
                    })->orWhereHas('workflow_task_employees', function($builder) use($division_id){
                        $builder->whereHas('employee', function($builder) use($division_id){
                            $builder->whereHas('department_active', function($builder) use($division_id){
                                $builder->whereHas('department', function($builder) use($division_id){
                                    $builder->where('division_id',$division_id);
                                });
                            });
                        });
                    });
                })->where('workflow_task.status',1);
            });
        }else{
            $datas->where(function($query) use($job_role_ids,$employee_id){
                $query->whereHas('workflow_tasks', function($builder) use($job_role_ids,$employee_id){
                    $builder->whereHas('workflow_task_employees', function($builder) use($job_role_ids,$employee_id){
                        $builder->where('employee_id',$employee_id);
                    })->orWhereHas('workflow_task_roles', function($builder) use($job_role_ids,$employee_id){
                        $builder->whereIn('job_role_id',$job_role_ids);
                    })->where('workflow_task.status',1);
                });
            });
        }
    }

    public function checkTaskAccess($datas, $employee){
        // from table workflow_task
        $employee_id = $employee->id ?? null;
        $job_role_ids = session()->get('job_role_ids');

        $position_code = $employee->position_active->job_position->code ?? 'EMP';
        $department_id = $employee->department_active->department_id ?? null;
        $division_id = $employee->department_active->department->division_id ?? null;

        if($position_code == 'MDP'){
            $datas->where(function($query) use($department_id){
                $query->whereHas('workflow_task_roles', function($builder) use($department_id){
                    $builder->whereHas('job_role', function($builder) use($department_id){
                        $builder->where('department_id',$department_id);
                    });
                })->orWhereHas('workflow_task_employees', function($builder) use($department_id){
                    $builder->whereHas('employee', function($builder) use($department_id){
                        $builder->whereHas('department_active', function($builder) use($department_id){
                            $builder->where('department_id',$department_id);
                        });
                    });
                });
            });
        }elseif($position_code == 'MDV'){
            $datas->where(function($query) use($division_id){
                $query->whereHas('workflow_task_roles', function($builder) use($division_id){
                    $builder->whereHas('job_role', function($builder) use($division_id){
                        $builder->whereHas('department', function($builder) use($division_id){
                            $builder->where('division_id',$division_id);
                        });
                    });
                })->orWhereHas('workflow_task_employees', function($builder) use($division_id){
                    $builder->whereHas('employee', function($builder) use($division_id){
                        $builder->whereHas('department_active', function($builder) use($division_id){
                            $builder->whereHas('department', function($builder) use($division_id){
                                $builder->where('division_id',$division_id);
                            });
                        });
                    });
                });
            });
        }else{
            $datas->where(function($query) use($job_role_ids,$employee_id){
                $query->whereHas('workflow_task_employees', function($builder) use($employee_id){
                    $builder->where('employee_id',$employee_id);
                })->orWhereHas('workflow_task_roles', function($builder) use($job_role_ids){
                    $builder->whereIn('job_role_id',$job_role_ids);
                });
            });
        }
    }
}
