<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int                      $id
 * @property string                   $address
 * @property string                   $latitude
 * @property string                   $longitude
 * @property Collection<Organization> $organisations
 */
class Building extends Model
{
    protected $fillable = [
        'address',
        'coordinates',
    ];

    /**
     * @return HasMany
     */
    public function organizations(): HasMany
    {
        return $this->hasMany(Organization::class);
    }
}
