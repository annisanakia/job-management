<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\File;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $connection = 'mysql';
    protected $fillable = [
        'username',
        'name',
        'email',
        'password',
        'group_id',
        'status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function validate($data)
    {
        $rules = array(
            'username' => 'required|unique:users,username,' . ($data['id'] ?? null) . ',id,deleted_at,NULL',
            'group_id' => 'required',
            'name' => 'required',
            'password' => 'nullable|min:6',
            'email' => 'nullable|email|unique:users,email,' . ($data['id'] ?? null) . ',id,deleted_at,NULL',
            'url_photo' => [
                File::image()
                    ->max(10240)
            ],
            'status' => 'required'
        );
        if(!array_key_exists('id',$data)){
            $rules['password'] = 'required|min:6';
        }
        $v = Validator::make($data, $rules);
        return $v;
    }

    public function group()
    {
        return $this->belongsTo('Models\group');
    }

    public function employee()
    {
        return $this->hasOne('Models\employee');
    }
}
