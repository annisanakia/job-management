<?php
namespace App\Modules\Employee\Controllers;

use \Models\employee as employeeModel;
use Lib\core\RESTful;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Excels\generalExport;
use App\Excels\generalImport;
use Excel;

class Employee extends RESTful {

    protected $model_user;

    public function __construct() {
        $this->model_user = new \App\Models\User();
        $model = new employeeModel;
        $controller_name = 'Employee';
        
        parent::__construct($model, $controller_name);
    }

    public function customFilter($datas, $newFilters)
    {
        foreach($newFilters as $key => $value){
            if($key == 'detail_employee'){
                $datas->where(function($query) use($key, $value){
                    $query->where('employee.name', 'LIKE', '%' . $value . '%')
                        ->orWhere('employee.nip', 'LIKE', '%' . $value . '%');
                });
            }
        }
    }

    public function store()
    {
        $input = request()->all();
        
        $group_default = \Models\group::select('id')->where('code','EMP')->first(); // employee
        $job_position = \Models\job_position::select('group_id')->find(request()->job_position_id);
        $group_id = $job_position->group_id ?? ($group_default->group_id ?? null);

        $input['id'] = $data->id ?? null;
        $validation = $this->model->validate($input);

        if ($validation->passes()) {
            if(request()->file('url_photo')){
                $input['url_photo'] = $this->uploadImage(request()->file('url_photo'), 'file/users');
            }
            $default_password = 'password';

            $input_user['group_id'] = $group_id;
            $input_user['email'] = request()->email;
            $input_user['name'] = request()->name;

            // save user
            $user = $data->user ?? null;
            $input_user['username'] = request()->nip;
            $input_user['password'] = \Hash::make(request()->password ?? $default_password);
            $input_user['status'] = request()->status; // active
            $user = $this->model_user->create($input_user);

            // save employee
            $input['user_id'] = $user->id;
            $data = $this->model->create($input);
            $id = $data->id;

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
        
        $group_default = \Models\group::select('id')->where('code','EMP')->first(); // employee
        $job_position = \Models\job_position::select('group_id')->find(request()->job_position_id);
        $group_id = $job_position->group_id ?? ($group_default->group_id ?? null);

        $data = $this->model->with('user')->find($id);
        $input['id'] = $data->id ?? null;
        $validation = $this->model->validate($input);

        if ($validation->passes()) {
            if(request()->file('url_photo') && $data){
                $this->deleteImage($data->url_photo, 'file/users');
            }
            if(request()->file('url_photo')){
                $input['url_photo'] = $this->uploadImage(request()->file('url_photo'), 'file/users');
            }
            $default_password = 'tcw'.date('ymd');

            $input_user['group_id'] = $group_id;
            $input_user['email'] = request()->email;
            $input_user['name'] = request()->name;

            // save user
            $user = $data->user ?? null;
            $input_user['password'] = \Hash::make(request()->password);
            $user->update($input_user);

            // save employee
            $input['user_id'] = $user->id;
            $data->update($input);

            return Redirect::route(strtolower($this->controller_name) . '.index');
        }

        return Redirect::route(strtolower($this->controller_name) . '.edit', $id)
            ->withInput()
            ->withErrors($validation)
            ->with('message', 'There were validation errors.');
    }
    
    public function delete_img($id)
    {
        $data = $this->model->find($id);
        if(isset($data->url_photo)){
            $this->deleteImage($data->url_photo, 'file/users');
            $data->url_photo = null;
            $data->save();
        }

        return Redirect::route(strtolower($this->controller_name) . '.edit', $id)
            ->withInput()
            ->with('message', 'There were validation errors.');
    }

    public function delete($id)
    {
        $data = $this->model->find($id);
        $user_id = $data->user_id ?? null;

        if($data){
            $data->delete();
            \App\Models\User::where('id',$user_id)->delete();
        }
        if (!request()->ajax()) {
            return Redirect::route(strtolower($this->controller_name) . '.index');
        }
    }
}