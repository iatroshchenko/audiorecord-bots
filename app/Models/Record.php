<?php

namespace App\Models;

use App\Concerns\ExposesTableName;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    use HasFactory, ExposesTableName;

    protected $table = 'records';

    protected $fillable = [
        'title',
        'path'
    ];

    public function url()
    {
        // get remote url
    }
}
