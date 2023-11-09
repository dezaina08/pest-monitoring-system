<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use App\Traits\ModelTimelineTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PestImage extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, ModelTimelineTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'date_captured',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'pest_image_photo',
        'created_at_for_humans',
        'created_at_iso_format',
        'updated_at_for_humans',
        'updated_at_iso_format',
    ];

    /**
     * Set single file collection
     */
    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('pest_image_photos')
            ->singleFile();
    }

    /**
     * Get the user's profile photo.
     */
    protected function pestImagePhoto(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->getFirstMediaUrl('pest_image_photos'),
        );
    }
}
