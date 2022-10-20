<?php

namespace App\Models;

use App\Models\Concerns\RestrictSoftDeletesTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class FederalDistrict extends Model
{
    use HasFactory, Sluggable, SoftDeletes, RestrictSoftDeletesTrait;

    public const TYPE_RESOURCE = 'federalDistricts';

    protected array $restrictDeletes = ['regions'];

    protected $fillable = [
        'name', 'description', 'slug', 'active'
    ];

    /**
     * @return HasMany
     */
    public function regions(): HasMany
    {
        return $this->hasMany(Region::class);
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
