<?php

namespace App\Models;

use App\Concerns\ExposesTableName;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory, ExposesTableName;

    protected $table = 'tags';

    public $timestamps = false;
}
