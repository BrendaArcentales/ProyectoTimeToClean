<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;
    const ROLE_SUPERADMIN = 'ROLE_SUPERADMIN';
    const ROLE_DRIVER = 'ROLE_DRIVER';


    private const ROLES_HIERARCHY = [
        self::ROLE_SUPERADMIN => [self::ROLE_DRIVER],
        self::ROLE_DRIVER => []];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'lastname',
        'birthdate',
        'type',
        'email',
        'password',
        'role',
        'cellphone',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function getJWTIdentifier(){
        return $this->getKey();
    }
    public function getJWTCustomClaims(){
        return [];
    }

    public function truck(){
        return $this->belongsTo('App\Models\Truck');
    }
    public function isGranted($role){
        if ($role === $this->role) {
        return true;
        }
        return self::isRoleInHierarchy($role, self::ROLES_HIERARCHY[$this->role]);
    }
    private static function isRoleInHierarchy($role, $role_hierarchy){
        if (in_array($role, $role_hierarchy)) {
            return true;
        }
        foreach ($role_hierarchy as $role_included) {
            if(self::isRoleInHierarchy($role,self::ROLES_HIERARCHY[$role_included])){
                return true;
            }
        }
        return false;
    }
}
