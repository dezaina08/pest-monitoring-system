<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PestType extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
    ];

     /**
     * Set single file collection
     */
    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('pest_type_photos')
            ->singleFile();
    }

    /**
     * Get the user's profile photo.
     */
    protected function pestTypePhoto(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->getFirstMediaUrl('pest_type_photos'),
        );
    }
}
