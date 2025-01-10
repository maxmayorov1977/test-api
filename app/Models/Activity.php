<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int                     $id
 * @property int                     $organization_id
 * @property string                  $name
 * @property Collection<SubActivity> $subActivities
 */
class Activity extends Model
{
    protected $fillable = [
        'name',
    ];

    /**
     * @return BelongsToMany
     */
    public function organization(): BelongsToMany
    {
        return $this->belongsToMany(Organization::class);
    }

    /**
     * @return HasMany
     */
    public function subActivities(): HasMany
    {
        return $this->hasMany(SubActivity::class);
    }
}
