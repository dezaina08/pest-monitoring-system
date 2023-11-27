<?php

namespace App\Models;

use App\Models\PestType;
use App\Traits\ModelTimelineTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Pesticide extends Model
{
    use HasFactory, ModelTimelineTrait;

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
     * The pest types that belong to the user.
     */
    public function pest_types(): BelongsToMany
    {
        return $this->belongsToMany(PestType::class, 'pesticide_pest_type');
    }
}
