<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait ModelTimelineTrait
{
    /**
     * Get created_at for humans.
     */
    protected function createdAtForHumans(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->created_at ? $this->created_at->diffForHumans():  '',
        );
    }

    /**
     * Get created_at ISO date format.
     */
    protected function createdAtIsoFormat(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->created_at ? $this->created_at->isoFormat('MMM D, YYYY') :  '',
        );
    }

    /**
     * Get created_at ISO time format.
     */
    protected function createdAtDateTime(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->created_at ? $this->created_at->isoFormat('HH:mm:ss') :  '',
        );
    }

    /**
     * Get updated_at for humans.
     */
    protected function updatedAtForHumans(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->updated_at ? $this->updated_at->diffForHumans() : '',
        );
    }

    /**
     * Get updated_at ISO date format.
     */
    protected function updatedAtIsoFormat(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->updated_at ? $this->updated_at->isoFormat('MMM D, YYYY') : '',
        );
    }
    
    /**
     * Get updated_at ISO time format.
     */
    protected function updatedAtDateTime(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->updated_at ? $this->updated_at->isoFormat('HH:mm:ss') :  '',
        );
    }
}
