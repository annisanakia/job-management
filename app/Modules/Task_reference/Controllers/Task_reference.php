<?php
namespace App\Modules\Task_reference\Controllers;

use \Models\task_reference as task_referenceModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Lib\core\RESTful;

class Task_reference extends RESTful {

    public function __construct() {
        $model = new task_referenceModel;
        $controller_name = 'Task_reference';
        
        parent::__construct($model, $controller_name);
    }

    public function store()
    {
        $input = request()->all();
        $validation = $this->model->validate($input);

        if ($validation->passes()) {
            $data = $this->model->create($input);
            
            $staff_ids = request()->staff_ids ?? [];
            $msco_ids = request()->msco_ids ?? [];
            $input_reference_emp['task_reference_id'] = $data->id ?? null;

            $input_reference_staffs = [];
            foreach($staff_ids as $staff_id){
                $input_reference_emp['employee_id'] = $staff_id;
                $input_reference_staffs[] = $input_reference_emp;
            }
            \Models\task_reference_staff::upsert($input_reference_staffs, ['task_reference_id', 'employee_id'], ['employee_id']);

            $input_reference_mscos = [];
            foreach($msco_ids as $msco_id){
                $input_reference_emp['employee_id'] = $msco_id;
                $input_reference_mscos[] = $input_reference_emp;
            }
            \Models\task_reference_msco::upsert($input_reference_mscos, ['task_reference_id', 'employee_id'], ['employee_id']);

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
            $staff_ids = request()->staff_ids ?? [];
            $msco_ids = request()->msco_ids ?? [];
            $input_reference_emp['task_reference_id'] = $id;

            $input_reference_staffs = [];
            foreach($staff_ids as $staff_id){
                $input_reference_emp['employee_id'] = $staff_id;
                $input_reference_staffs[] = $input_reference_emp;
            }
            \Models\task_reference_staff::upsert($input_reference_staffs, ['task_reference_id', 'employee_id'], ['employee_id']);

            $input_reference_mscos = [];
            foreach($msco_ids as $msco_id){
                $input_reference_emp['employee_id'] = $msco_id;
                $input_reference_mscos[] = $input_reference_emp;
            }
            \Models\task_reference_msco::upsert($input_reference_mscos, ['task_reference_id', 'employee_id'], ['employee_id']);

            $data = $this->model->find($id);
            $data->update($input);
            return Redirect::route(strtolower($this->controller_name) . '.index');
        }

        return Redirect::route(strtolower($this->controller_name) . '.edit', $id)
            ->withInput()
            ->withErrors($validation)
            ->with('message', 'There were validation errors.');
    }

    public function delete($id)
    {
        $data = $this->model->find($id);
        if($data){
            $data->delete();
            \Models\task_reference_staff::where('task_reference_id',$id)->delete();
            \Models\task_reference_msco::where('task_reference_id',$id)->delete();
        }
        if (!request()->ajax()) {
            return Redirect::route(strtolower($this->controller_name) . '.index');
        }
    }
}