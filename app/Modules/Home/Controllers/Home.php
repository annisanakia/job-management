<?php

namespace App\Modules\Home\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;
use GuzzleHttp\Client;
use DB;

class Home extends Controller {

    protected $controller_name;
    protected $libWorkflow;
    protected $employee;

    public function __construct()
    {
        $employee = Auth::user()->employee ?? null;

        $this->controller_name = 'Home';
        $this->employee = $employee;

        view::share('controller_name', strtolower($this->controller_name));
    }

    public function index()
    {
        $date = date('Y-m-d');
        $template = 'index';
        
        $with['date'] = $date;
        return view($this->controller_name . '::' . $template,$with);
    }
}