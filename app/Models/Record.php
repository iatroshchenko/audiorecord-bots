<?php

namespace App\Models;

use App\Traits\Model\{UsesPublicUuid, ExposesTableName};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    use HasFactory,
        ExposesTableName,
        UsesPublicUuid;

    protected $table = 'records';

    protected $fillable = [
        'name',
        'path'
    ];

    public function url()
    {
        // get remote url
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
