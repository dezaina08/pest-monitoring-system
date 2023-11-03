<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pest extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'pest_type_id',
    ];

    /**
     * Set single file collection
     */
    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('pest_photos')
            ->singleFile();
    }

    /**
     * Get the user's profile photo.
     */
    protected function pestPhoto(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->getFirstMediaUrl('pest_photos'),
        );
    }
}