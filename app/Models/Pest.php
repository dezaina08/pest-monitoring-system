<?php

namespace App\Models;

use App\Models\PestType;
use App\Models\PestImage;
use Spatie\MediaLibrary\HasMedia;
use App\Traits\ModelTimelineTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
        'pest_image_id',
        'pest_type_id',
        'count',
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

    /**
     * Get the pest_image.
     */
    public function pest_image(): BelongsTo
    {
        return $this->belongsTo(PestImage::class);
    }

    /**
     * Get the pest_type.
     */
    public function pest_type(): BelongsTo
    {
        return $this->belongsTo(PestType::class);
    }

    public static function getPestsCount($request) {
        $pestsCount = Pest::sum('count');
        
        return $pestsCount;
    }
}
