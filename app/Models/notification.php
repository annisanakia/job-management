<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\SoftDeletes;

class notification extends Model
{
    use SoftDeletes;

    protected $connection = 'mysql';
    protected $table = 'notification';
    protected $guarded = ['id'];
    
    public static $rules = array(
        'target_id' => 'required'
    );
    
    public function validate($data)
    {
        $v = Validator::make($data, notification::$rules);
        return $v;
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function pic_user()
    {
        return $this->belongsTo('App\Models\User', 'pic_user_id', 'id');
    }
}