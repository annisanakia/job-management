<?php

namespace Lib\core;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use View;
use File;

class RESTful extends Controller
{
    protected $model;
    protected $controller_name;
    protected $max_row = 50;
    protected $enable_pdf;
    protected $enable_xls;
    protected $enable_import;
    protected $module_name = '';
    protected $actions = array();
    protected $table_name = '';
    protected $filter_string = '';
    protected $coreLib;

    public function __construct($model, $controller_name)
    {
        $this->model = $model;
        $this->controller_name = $controller_name;
     
        $this->coreLib = new \Lib\core\Core($controller_name);
        $module = $this->coreLib->getModule();

        $this->module_name = $module->name ?? null;

        view::share('module_name', $module->name ?? null);
        view::share('module_detail', $module->name_detail ?? null);
        view::share('controller_name', strtolower($controller_name));
    }

    public function index()
    {
        $with = $this->getList();

        if (request()->ajax()) {
            return view($this->controller_name . '::list', $with);
        }

        return view($this->controller_name . '::index', $with);
    }

    public function getList($start = '', $end = '')
    {
        $datas = $this->setDatas();

        $table = $this->table_name != '' ? $this->table_name : strtolower($this->controller_name);
        $this->filter($datas, request()->filters, $table);
        $this->order($datas, request()->sort_field, request()->sort_type);

        $this->max_row = request()->input('max_row') ?? $this->max_row;

        $this->filter_string = http_build_query(request()->all());
        
        if ($this->enable_pdf) {
            $url_pdf = strtolower($this->controller_name) . '/getListAsPdf?' . $this->filter_string;
            $this->actions[] = array('name' => '', 'url' => $url_pdf, 'class' => 'btn btn-outline-danger float-end me-2', 'attr'=>'target=_blank', 'icon' => 'fas fa-file-pdf');
        }
        
        if ($this->enable_xls) {
            $url_xls = strtolower($this->controller_name) . '/getListAsXls?' . $this->filter_string;
            $this->actions[] = array('name' => '', 'url' => $url_xls, 'class' => 'btn btn-outline-success float-end me-2', 'attr'=>'target=_blank', 'icon' => 'fas fa-file-excel');
        }

        if ($this->enable_import){
            $this->actions[] = array('name' => '', 'url' => strtolower($this->controller_name) . '/import', 'class' => 'btn btn-outline-primary float-end me-2', 'icon' => 'fas fa-upload');
        }

        $this->actions[] = array('name' => 'Add New', 'url' => strtolower($this->controller_name) . '/create', 'class' => 'btn btn-primary btn-round float-end me-2', 'icon' => 'fas fa-plus');
        
        $this->beforeIndex($datas);

        $datas = $datas->paginate($this->max_row);
        $datas->chunk(100);

        if (method_exists($this, 'customParam')) {
            $with = $this->customParam();
        }

        $with['datas'] = $datas;
        $with['param'] = request()->all();
        $with['filters'] = request()->filters;
        $with['sort_field'] = request()->sort_field;
        $with['sort_type'] = request()->sort_type > 2? 0 : request()->sort_type;
        $with['max_row'] = $this->max_row;
        $with['actions'] = $this->actions;

        return $with;
    }

    public function setDatas()
    {
        $datas = $this->model->select(['*']);
        return $datas;
    }

    public function beforeIndex($data)
    { }

    // filter data
    public function filter($datas, $filters, $table_name)
    {
        $schema = collect(Schema::getColumns($table_name));
        $tables = $schema->pluck('type_name','name')->all();

        $filters = is_array($filters)? $filters : [];
        $filters = array_filter($filters, function($v){
            return $v !== false && !is_null($v) && ($v != '' || $v == '0');
        });
        if (count($filters) > 0) {
            $newFilters = [];
            foreach ($filters as $key => $value) {
                if (array_key_exists($key, $tables) && $value != '') {
                    if (in_array($tables[$key],['text','varchar','string'])) {
                        $datas->where($table_name.'.'.$key, 'LIKE', '%' . $value . '%');
                    } elseif (in_array($tables[$key],['date','datetime','timestamp','time'])) {
                        if ($key == 'start' || $key == 'start_date') {
                            $datas->where($key, '>=', $value);
                        }
                        if ($key == 'end' || $key == 'end_date') {
                            $datas->where($key, '<=', $value);
                        }
                        if ($key == 'date') {
                            $datas->whereDate($key, $value);
                        }
                    } else {
                        $datas->where($table_name.'.'.$key, '=', $value);
                    }
                }else{
                    $newFilters[$key] = $value;
                }
            }

            if (method_exists($this, 'customFilter')) {
                $this->customFilter($datas, $newFilters);
            }
        }

        return $datas;
    }

    // order data
    public function order($datas, $sort_field, $sort_type)
    {
        $sort_type = $sort_type > 2? 0 : $sort_type;
        $sort_type = orders()[$sort_type] ?? null;
        if ($sort_field != '' && $sort_type != '') {
            $datas->orderBy($sort_field, $sort_type);
        } else {
            $datas->orderBy('id', 'desc');
        }
    }

    public function create()
    {
        $action[] = array('name' => 'Cancel', 'url' => strtolower($this->controller_name), 'class' => 'btn btn-secondary px-3 ms-md-1');
        $action[] = array('name' => 'Save', 'type' => 'submit', 'url' => '#', 'class' => 'btn btn-success px-3 ms-md-1 btn-loading');

        $content['actions'] = $action;
        $content['data'] = null;

        return view($this->controller_name . '::create', $content);
    }

    public function store()
    {
        $input = request()->all();
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

    public function edit($id)
    {
        $data = $this->model->find($id);

        if (is_null($data)) {
            return Redirect::route(strtolower($this->controller_name) . '.index');
        }

        $action[] = array('name' => 'Cancel', 'url' => strtolower($this->controller_name), 'class' => 'btn btn-secondary px-3 ms-md-1');
        $action[] = array('name' => 'Delete', 'url' => strtolower($this->controller_name) . '/delete/' . $id, 'class' => 'btn btn-danger px-3 ms-md-1 delete', 'attr' => 'ng-click=confirm($event) data-name='.($data->name ?? $data->code));
        $action[] = array('name' => 'Save', 'type' => 'submit', 'url' => '#', 'class' => 'btn btn-success px-3 ms-md-1 btn-loading');

        $content['data'] = $data;
        $content['actions'] = $action;
        return View($this->controller_name . '::edit' , $content);
    }

    public function update($id)
    {
        $input = request()->all();
        $input['id'] = $id;
        
        $validation = $this->model->validate($input);

        if ($validation->passes()) {
            $data = $this->model->find($id);
            $data->update($input);
            return Redirect::route(strtolower($this->controller_name) . '.index');
        }

        return Redirect::route(strtolower($this->controller_name) . '.edit', $id)
            ->withInput()
            ->withErrors($validation)
            ->with('message', 'There were validation errors.');
    }

    public function detail($id)
    {
        $data = $this->model->find($id);

        if (is_null($data)) {
            return Redirect::route(strtolower($this->controller_name) . '.index');
        }

        $action[] = array('name' => 'Cancel', 'url' => strtolower($this->controller_name), 'class' => 'btn btn-secondary px-3 ms-md-1');
        $action[] = array('name' => 'Delete', 'url' => strtolower($this->controller_name) . '/delete/' . $id, 'class' => 'btn btn-danger px-3 ms-md-1 delete', 'attr' => 'ng-click=confirm($event) data-name='.$data->name);
        
        $content['data'] = $data;
        $content['actions'] = $action;

        return View($this->controller_name . '::detail' , $content);
    }

    public function import()
    {
        return View($this->controller_name . '::import');
    }

    function setTableName($table)
    {
        $this->table_name = $table;
    }

    public function delete($id)
    {
        $data = $this->model->find($id);
        if($data){
            $data->delete();
        }
        if (!request()->ajax()) {
            return Redirect::route(strtolower($this->controller_name) . '.index');
        }
    }

    function uploadImage($image, $location = '/'){
        $url_photo = null;
        if ($image) {
            $imagename = date('ymd') . time() . '.' . $image->getClientOriginalExtension();

            if (!Storage::disk('public')->exists($location)) {
                Storage::disk('public')->makeDirectory($location);
            }
            Storage::disk('public')->putFileAs($location, $image, $imagename);

            $url_photo = Storage::disk('public')->url($location.'/'.$imagename);
        }
        return $url_photo;
    }

    function deleteImage($url, $location = 'assets/file'){
        $imagename = substr($url, strrpos("/$url", '/'));
        if (Storage::disk('public')->exists($location.'/'.$imagename)) {
            Storage::disk('public')->delete($location.'/'.$imagename);
            return true;
        }
        return false;
    }
}