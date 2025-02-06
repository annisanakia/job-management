<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rules\File;

class employee extends Model
{
    use SoftDeletes;

    protected $connection = 'mysql';
    protected $table = 'employee';
    protected $guarded = ['id'];
    
    public static $customMessages = array(
        'required' => 'This field required.',
        'numeric' => 'This field must be a number.',
        'min_digits' => 'This field must have at least 10 digits.',
        'max_digits' => 'This field must not have more than 15 digits.',
        'url_photo.max' => 'Size photo must not be greater than 2mb.',
        'url_photo.image' => 'File photo must be an image.',
        'nip.*.unique' => 'NIP already exists.',
        'email.*.unique' => 'Email already exists.'
    );

    public function validate($data)
    {
        $rules = array(
            'nip' => 'nullable|unique:employee,nip,' . ($data['id'] ?? null) . ',id,deleted_at,NULL',
            'name' => 'required',
            'email' => 'nullable|email|unique:employee,email,' . ($data['id'] ?? null) . ',id,deleted_at,NULL',
            'phone' => 'numeric|nullable|min_digits:10|max_digits:15',
            'status' => 'required',
            'job_position_id' => 'required',
            'url_photo' => [
                File::image()
                    ->max(2048)
            ],
        );
        $v = Validator::make($data, $rules, employee::$customMessages);
        return $v;
    }

    public function validateMultiple($data)
    {
        $rules = array(
            'nip.*' => 'nullable|unique:employee,nip,' . ($data['id'] ?? null) . ',id,deleted_at,NULL',
            'name.*' => 'required',
            'email.*' => 'nullable|email|unique:employee,email,' . ($data['id'] ?? null) . ',id,deleted_at,NULL',
            'phone.*' => 'numeric|nullable|min_digits:10|max_digits:15',
            'status.*' => 'required',
            'job_position_id.*' => 'required'
        );
        $v = Validator::make($data, $rules, employee::$customMessages);
        return $v;
    }

    public function job_position()
    {
        return $this->belongsTo('Models\job_position');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}