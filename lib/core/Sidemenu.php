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
        $this->group_code = Auth::user()->group->code ?? null;
    }

    public function listMenu(){
        $menus = menuSidebar() ?? [];
        $html_sidemenu = '<ul class="nav nav-secondary">';
        foreach(menuSidebar() as $code => $module){
            $icon = $module['icon'] ?? 'fas fa-list';
            $name = $module['name'] ?? null;
            if(count(($module['childs'] ?? [])) <= 0){
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
                $child_codes = array_keys($module['childs'] ?? []);
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
                foreach($module['childs'] as $code_child => $child){
                    $name_child = $child['name'] ?? null;
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
}