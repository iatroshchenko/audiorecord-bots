<?php

namespace App\Models;

use App\Services\ColorService;
use App\Traits\Model\{UsesPublicUuid, ExposesTableName};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tag extends Model
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

            if (!$model->color) {
                $model->color = ColorService::generateColor();
            }
        });
    }

    protected $table = 'tags';

    protected $fillable = [
        'name'
    ];

    public $timestamps = false;

    public function records()
    {
        return $this->belongsToMany(Record::class);
    }
}
