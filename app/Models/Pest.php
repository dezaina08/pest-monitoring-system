<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use App\Traits\ModelTimelineTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pest extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, ModelTimelineTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'pest_type_id',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'created_at_for_humans',
        'created_at_iso_format',
        'updated_at_for_humans',
        'updated_at_iso_format',
    ];
}
