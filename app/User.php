<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'money', 'drink', 'isIn',
    ];
    function getUser($name)
    {
        $user = $this->where('name', $name)->first();
        return $user;
    }

    function getMoney($name)
    {
       if(gettype($name)==('string')){
            $money = $this->where('name', $name)->first()->money;
            return $money;
        }
    }

}
