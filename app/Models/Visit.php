<?php

namespace App\Models;

use Database\Factories\VisitFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Visit
 *
 * @property int $id
 * @property string $visit_date
 * @property int|null $employee_id
 * @property int|null $service_id
 * @property int|null $client_id
 * @property string $price
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Client|null $client
 * @property-read Employee|null $employee
 * @property-read Service|null $service
 * @method static VisitFactory factory(...$parameters)
 * @method static Builder|Visit newModelQuery()
 * @method static Builder|Visit newQuery()
 * @method static Builder|Visit query()
 * @method static Builder|Visit whereClientId($value)
 * @method static Builder|Visit whereCreatedAt($value)
 * @method static Builder|Visit whereEmployeeId($value)
 * @method static Builder|Visit whereId($value)
 * @method static Builder|Visit wherePrice($value)
 * @method static Builder|Visit whereServiceId($value)
 * @method static Builder|Visit whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property Carbon $start_at
 * @property Carbon $end_at
 * @method static Builder|Visit whereEndAt($value)
 * @method static Builder|Visit whereStartAt($value)
 * @method static Builder|Visit whereVisitDate($value)
 */
class Visit extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $dates = ['visit_date', 'start_at', 'end_at'];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
