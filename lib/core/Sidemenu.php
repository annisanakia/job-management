<?php

namespace Lib\core;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class Sidemenu extends Controller
{
    protected $menu_active;
    protected $group_id;
    protected $group_code;

    public function __construct()
    {
        $this->menu_active = request()->route()->getPrefix() != ''? request()->route()->getPrefix() : 'home';
        $this->group_id = Auth::user()->group_id;
        $this->group->id = Auth::user()->group->code;
    }

    public function listMenu(){
        $menus = menuSidebar()[] ?? [];
        $html_sidemenu = '<ul class="nav nav-secondary">';
        foreach(menuSidebar() as $code => $module){
            $icon = $module->icon != ''? $module->icon : 'fas fa-list';
            $name = $module->name;
            if(count($module->childs) <= 0){
                $active = $code == $this->menu_active? 'active' : '';
                $html_sidemenu .= '
                    <li class="nav-item '.$active.'">
                        <a href="'.url($code).'">
                            <i class="'.$icon.'"></i>
                            <p>'.$name.'</p>
                        </a>
                    </li>
                ';
            }else{
                $child_codes = $module->childs->pluck('code')->all();
                $active = in_array($this->menu_active,$child_codes)? 'active' : '';

                $html_sidemenu .= '<li class="nav-item '.$active.'">';
                $html_sidemenu .= '
                    <a data-bs-toggle="collapse" href="#'.$code.'" class="'.($active != ''? '' : 'collapsed').'" oncontextmenu="return false;">
                        <i class="'.$icon.'"></i>
                        <p>'.$name.'</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse '.($active != ''? 'show' : '').'" id="'.$code.'">
                            <ul class="nav nav-collapse">
                ';
                foreach($module->childs as $child){
                    $code_child = $child->code;
                    $name_child = $child->name;
                    $active = $code_child == $this->menu_active? 'active' : '';

                    $html_sidemenu .= '
                        <li class="'.$active.'">
                            <a href="'.url($code_child).'">
                                <span class="sub-item">'.$name_child.'</span>
                            </a>
                        </li>
                    ';
                }
                $html_sidemenu .= '
                            </ul>
                        </div>
                    </li>';
            }
        }
        $html_sidemenu .= '</ul>';
        return $html_sidemenu;
    }

    public function getParentModules(){
        $modules = \Models\module::select([
                'id','code','name','icon'
            ])
            ->whereHas('module_access', function($builder){
                $builder->where('group_id',$this->group_id);
            })
            ->where(function($query){
                $query->whereNull('parent_id')->orWhere('parent_id',0);
            })
            ->where('status', 1) // status publish
            ->with('childs')
            ->orderBy('sequence')->orderBy('id')->get();
        return $modules;
    }

    public function getAllModules(){
        $modules = \Models\module::select([
                'id','code','name','icon'
            ])
            ->whereHas('module_access', function($builder){
                $builder->where('group_id',$this->group_id);
            })
            ->with('parent')
            ->orderBy('sequence')->orderBy('id')->get();
        return $modules;
    }
}