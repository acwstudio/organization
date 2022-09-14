<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OrganizationType extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = ['name','description','slug','active','serial_number'];

    const TYPE_RESOURCE = 'organizationType';

    /**
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(OrganizationType::class, 'parent_id', 'id');
    }

    /**
     * @return HasOne
     */
    public function parent(): hasOne
    {
        return $this->hasOne(OrganizationType::class,'id', 'parent_id');
    }

    /**
     * @return HasMany
     */
    public function organizations(): HasMany
    {
        return $this->hasMany(Organization::class);
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
