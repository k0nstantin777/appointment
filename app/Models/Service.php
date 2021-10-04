<?php

namespace App\Models;

use Database\Factories\ServiceFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Service
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string $duration
 * @property string $price
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Category[] $categories
 * @property-read int|null $categories_count
 * @property-read Collection|Visit[] $employees
 * @property-read int|null $employees_count
 * @property-read Collection|Visit[] $visits
 * @property-read int|null $visits_count
 * @method static ServiceFactory factory(...$parameters)
 * @method static Builder|Service newModelQuery()
 * @method static Builder|Service newQuery()
 * @method static Builder|Service query()
 * @method static Builder|Service whereCreatedAt($value)
 * @method static Builder|Service whereDescription($value)
 * @method static Builder|Service whereDuration($value)
 * @method static Builder|Service whereId($value)
 * @method static Builder|Service whereName($value)
 * @method static Builder|Service wherePrice($value)
 * @method static Builder|Service whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Service extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function visits(): HasMany
    {
        return $this->hasMany(Visit::class);
    }

    public function employees(): BelongsToMany
    {
        return $this->belongsToMany(Employee::class)
            ->withTimestamps();
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class)
            ->withTimestamps();
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    public function getDurationAttribute(string $value) : string
    {
        return Carbon::parse($value)->format('H:i');
    }

    public function getDurationInMinutesAttribute() : string
    {
        $duration = Carbon::parse($this->duration);

        return $duration->hour * 60 + $duration->minute;
    }
}
