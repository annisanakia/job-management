<?php
namespace App\Modules\Account_setting\Controllers;

use \App\Models\User as userModel;
use Lib\core\RESTful;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class Account_setting extends RESTful {

    public function __construct() {
        $model = new userModel;
        $controller_name = 'Account_setting';

        $this->enable_pdf = true;
        $this->enable_xls = true;
        $this->table_name = 'users';
        
        parent::__construct($model, $controller_name);
    }

    public function index(){
        $action[] = array('name' => 'Save Changes', 'type' => 'submit', 'url' => '#', 'class' => 'btn btn-outline-success px-3');
        
        $with['actions'] = $action;
        $with['data'] = \Auth::user();
        return View($this->controller_name . '::index', $with);
    }

    public function update($id)
    {
        $input = Request()->all();
        $input['id'] = $id;

        $rules = array(
            'phone' => 'numeric|nullable|min_digits:10|max_digits:15'
        );

        $validation = Validator::make($input, $rules);
        
        if ($validation->passes()) {
            $data = $this->model->find($id);
            $data->employee->nickname = request()->nickname;
            $data->employee->phone = request()->phone;
            $data->employee->save();

            $data->update($input);
            
            return Redirect::route(strtolower($this->controller_name) . '.index')
                    ->with('type', '1')
                    ->with('success', '1');
        }
        return Redirect::route(strtolower($this->controller_name) . '.index')
            ->withInput()
            ->withErrors($validation)
            ->with('type', '1');
    }

    public function update_password($id)
    {

        $input = request()->all();
        $data = $this->model->find($id);

        $current_password = request()->current_password;

        $rules = array(
            'password' => 'required|min:6',
            'password_confirmation' => 'required|same:password',
            'current_password' => ['required', function ($atribute, $value, $fail) use ($data) {
                if (!\Hash::check($value, $data->password)) {
                    return $fail(__('Current password is incorrect.'));
                }
            }]
        );

        $validation = Validator::make($input, $rules);
        
        if ($validation->passes()) {
            $data->password = \Hash::make(request()->password);
            $data->save();
            
            return Redirect::route(strtolower($this->controller_name) . '.index')
                    ->with('type', '2')
                    ->with('success', '1');
        }

        return Redirect::route(strtolower($this->controller_name) . '.index')
            ->withInput()
            ->withErrors($validation)
            ->with('type', '2');
    }
}