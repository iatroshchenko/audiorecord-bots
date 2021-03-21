<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;
use App\Traits\Model\{UsesPublicUuid, ExposesTableName};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Record extends Model
{
    use HasFactory,
        ExposesTableName,
        UsesPublicUuid;

    /**
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($model) {
            if (!$model->uuid) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }

    protected $table = 'records';

    protected $fillable = [
        'name',
        'path',
        'default_search_available'
    ];

    const RECORD_FOLDER = 'records';

    public function url()
    {
        if ($this->is_remote) {
            return '';
        }

        return url('storage/' . $this->path, [], true);
    }

    public function getPathToDelete()
    {
        if ($this->is_remote) {
            return $this->path;
        }

        return Storage::path('app/' . $this->path);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
