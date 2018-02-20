<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Elegant implements AuthenticatableContract, AuthorizableContract, JWTSubject
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'email',
        'firstname',
        'lastname',
        'birthday',
        'cover',
        'avatar',
        'gender',
        'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'admin',
    ];

    //Y-m-d
    protected $dates = [
        'birthday',
    ];

    protected $rules = [
        'email' => 'required|email|max:100|unique:users',
        'password' => 'required|max:100|min:5',
        'firstname' => 'required|max:50|min:2',
        'lastname'  => 'required||max:50|min:2',
        'birthday'  => 'required|date',
        'gender'    => 'required|integer',
        'username' => 'required|min:3|max:18|unique:users', 
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = app('hash')->make($value);
    }


    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [
            'admin' => $this->admin,
        ];
    }
}
