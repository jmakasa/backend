<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\UuidForKey;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Traits\Validatable;
use App\Traits\CreatedUpdatedBy;



class Employees extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable,CreatedUpdatedBy,Validatable;
    //UuidForKey;

    protected $table = 'employees';


    const STATUS_ACTIVE = "Active";
    const STATUS_INACTIVE = "Inactive";
    const STATUS_SUSPEND = "Suspend";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'join_date',
        'position',
        'profile_img',
        'email',
        'password',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function getValidationRules()
    {
        return [
            'name' => 'required',
            'username' => 'required',
            'email' => 'required',
            'password' => 'required',
        ];
    }
    /**
     * get the identifier that will be store in the subjecct claim of the JWT.
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function inDepartments(){
        return $this->hasMany('App\Models\EmployeeInDepartments', 'employees_id', 'id')->orderBy('created_at');
    }


}
