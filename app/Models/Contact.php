<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'full_name',
        'email',
        'phone_country',
        'phone',
        'company',
        'project_type',
        'budget',
        'message',
        'source',
        'status',
        'ip_address',
        'user_agent',
    ];
}