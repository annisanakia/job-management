<?php
namespace App\Modules\Task\Controllers;

use \Models\task as taskModel;
use Lib\core\RESTful;
use Illuminate\Support\Facades\Redirect;

class Task extends RESTful {

    public function __construct() {
        $model = new taskModel;
        $controller_name = 'Task';

        $this->table_name = 'Task';
        
        parent::__construct($model, $controller_name);
    }
}