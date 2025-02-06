<?php
namespace App\Modules\Users\Controllers;

use \App\Models\User as userModel;
use Lib\core\RESTful;
use Illuminate\Support\Facades\Redirect;

class Users extends RESTful {

    public function __construct() {
        $model = new userModel;
        $controller_name = 'Users';

        $this->enable_pdf = true;
        $this->enable_xls = true;
        $this->table_name = 'users';
        
        parent::__construct($model, $controller_name);
    }

    public function setDatas()
    {
        $datas = $this->model->select(
            'users.*','group.name as group_name'
        )->with('group','employee');

        // join user group
        $datas->leftJoin('group', function ($join) {
            $join->on('group.id', '=', 'users.group_id')->whereNull('group.deleted_at');
        });
        
        return $datas;
    }

    public function store()
    {
        $input = request()->all();

        if(request()->username == ''){
            $input['username'] = request()->email;
        }
        
        if(request()->password == ''){
            $default_password = 'tcw'.date('ymd');
            $input['password'] = \Hash::make($default_password);
        }else{
            $input['password'] = \Hash::make(request()->password);
        }

        $validation = $this->model->validate($input);

        if ($validation->passes()) {
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

        if(request()->password == ''){
            unset($input['password']);
        }else{
            $input['password'] = \Hash::make(request()->password);
        }
        
        $validation = $this->model->validate($input);

        if ($validation->passes()) {
            $data = $this->model->with('employee')->find($id);
            $data->update($input);

            if($data->employee){
                $data->employee->email = request()->email;
                $data->employee->name = request()->name;
                $data->employee->save();
            }

            return Redirect::route(strtolower($this->controller_name) . '.index');
        }
        return Redirect::route(strtolower($this->controller_name) . '.edit', $id)
            ->withInput()
            ->withErrors($validation)
            ->with('message', 'There were validation errors.');
    }
    
    public function getListAsPdf()
    {
        $title_head_export = $this->module_name.' Recap';
        $template = $this->controller_name . '::getListAsPdf';
        $data = $this->getList();
        
        $data['title_head_export'] = $title_head_export;

        $pdf = \PDF::loadView($template, $data)
            ->setPaper('A4', 'portrait');

        if (request()->has('print_view')) {
            return view($template, $data);
        }

        return $pdf->stream($title_head_export . ' ('.date('d-m-Y').').pdf');
    }

    public function getListAsXls()
    {
        $title_head_export = $this->module_name.' Recap';
        $template = $this->controller_name . '::getListAsXls';
        $data = $this->getList();
        $data['title_head_export'] = $title_head_export;
        $data['title_col_sum'] = 6;

        if (request()->has('print_view')) {
            return view($template, $data);
        }

        return response(view($template, $data))
            ->header('Content-Type', 'application/vnd-ms-excel')
            ->header('Content-Disposition', 'attachment; filename="' . $title_head_export . ' ('.date('d-m-Y').').xls"');
    }

    public function delete($id)
    {
        $title_head_export = $this->module_name.' Recap';
        $data = $this->model->find($id);

        if($data && !($data->employee)){
            $data->delete();
        }else{
            return ['status_failed'=>'1','message'=>'Delete failed. This user has employee data'];
        }
        if (!request()->ajax()) {
            return Redirect::route(strtolower($this->controller_name) . '.index');
        }
    }
}