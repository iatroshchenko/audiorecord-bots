<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    const SUPERADMIN_ROLE_NAME = 'superadmin';
    const ADMIN_ROLE_NAME = 'admin';

    protected $fillable = [
        'name'
    ];

    use HasFactory;

    public $timestamps = false;
}
