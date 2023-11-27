<?php

namespace App\Models;

use App\Models\Pest;
use App\Models\Pesticide;
use Spatie\MediaLibrary\HasMedia;
use App\Traits\ModelTimelineTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PestType extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, ModelTimelineTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'pesticide_id',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'pest_type_photo',
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

    /**
     * Get pests.
     */
    public function pests(): HasMany
    {
        return $this->hasMany(Pest::class);
    }

    /**
     * The pest types that belong to the user.
     */
    public function pesticides(): BelongsToMany
    {
        return $this->belongsToMany(Pesticide::class, 'pesticide_pest_type');
    }
}
