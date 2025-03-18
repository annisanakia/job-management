<?php
namespace App\Modules\Notification\Controllers;

use \Models\notification as notificationModel;
use Illuminate\Support\Facades\Auth;
use Lib\core\RESTful;

class Notification extends RESTful {

    protected $user;
    protected $job_role_ids;

    public function __construct() {
        $model = new notificationModel;
        $controller_name = 'Notification';

        $this->user = Auth::user() ?? null;
        $this->job_role_ids = session()->get('job_role_ids');
        $this->max_row = 20;
        
        parent::__construct($model, $controller_name);
    }

    public function setDatas() {
        $datas = $this->model->select('*');

        // join user group
        $datas->where('user_id',$this->user->id);
        
        return $datas;
    }

    public function notificationNewList() {
        $notifications = \Models\notification::where('user_id', $this->user->id)
            ->orderBy('datetime','desc')
            ->limit(10)
            ->get();
        
        $with['notifications'] = $notifications;
        return view($this->controller_name . '::notificationNewList', $with);
    }

    public function notificationDetail($id) {
        $notification = \Models\notification::find($id);
        $notification->is_read = 1;
        $notification->save();
        return redirect(url($notification->link));
    }

    public function markAllRead() {
        $notifications = \Models\notification::where('user_id', $this->user->id)
            ->where('is_read',0)
            ->orderBy('datetime','desc')
            ->update(['is_read' => 1]);
        return redirect()->back();
    }
}