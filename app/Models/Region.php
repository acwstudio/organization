<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Region extends Model
{
    use HasFactory, Sluggable;

    public const TYPE_RESOURCE = 'regions';

    protected $fillable = ['federal_district_id','name','description','slug','active'];

    /**
     * @return HasMany
     */
    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }

    /**
     * @return BelongsTo
     */
    public function federalDistrict(): BelongsTo
    {
        return $this->belongsTo(FederalDistrict::class);
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
}
