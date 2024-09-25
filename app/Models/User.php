<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; #hasfactory para criar instâncias de modelos existentes
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable; 

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'lastname',
        'email',
        'password',
    ];

    #ocutar dados quando retornados por um json
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected$casts =[
             
                'email_verified_at' => 'datetime',
                'password' => 'hashed',
        ];
}
