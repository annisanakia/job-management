<?php

namespace Lib\core;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use View;

class Core extends Controller
{
    protected $controller_name, $group_id, $priv,
            $module_access, $actions, $custom_params = [],
            $newFilters = [];

    public function __construct($controller_name)
    {
        $this->group_id = Auth::user()->group_id;
        $this->controller_name = $controller_name;
    }

    public function accessfeatures(){
        $priv = $this->module_access? $this->module_access->toArray() : [];
        unset($priv['module_id'],$priv['module']);
        
        $this->priv = $priv;
        return $this->priv;
    }

    public function getModule(){
        return $this->module_access->module ?? null;
    }

    public function renderList($data, $name, $selected, $blank = true, $customClass = null)
    {
        $mutiple = is_array($selected) ? 'multiple' : '';

        // if ($customClass) {
        //     $html = '<select class="' . $customClass . '" data-live-search="true" name="' . $name . '" ' . $mutiple . '>';
        // } else {
        //     $html = '<select class="form-control selectpicker" data-live-search="true" name="' . $name . '" ' . $mutiple . '>';
        // }
        $html = '';

        $blank = filter_var($blank, FILTER_VALIDATE_BOOLEAN);
        if ($blank) {
            $html .= '<option value="">-- Select --</option>';
        }
        foreach ($data as $key => $row) {
            if (is_array($selected)) {
                if (in_array($key, $selected)) {
                    $select = 'selected';
                } else {
                    $select = '';
                }
            } else {
                if ((string)$selected === (string)$key) {
                    $select = 'selected';
                } else {
                    $select = '';
                }
            }
            $html .= '<option value="' . $key . '" ' . $select . '>' . $row . '</option>';
        }
        // $html .= '</select>';
        return $html;
    }
}