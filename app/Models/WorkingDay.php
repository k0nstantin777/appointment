<?php

namespace App\Models;

use Database\Factories\WorkingDayFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\WorkingDay
 *
 * @property int $id
 * @property string $calendar_date
 * @property string $start_at
 * @property string $end_at
 * @property int $employee_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Employee $employee
 * @method static WorkingDayFactory factory(...$parameters)
 * @method static Builder|WorkingDay newModelQuery()
 * @method static Builder|WorkingDay newQuery()
 * @method static Builder|WorkingDay query()
 * @method static Builder|WorkingDay whereCreatedAt($value)
 * @method static Builder|WorkingDay whereEmployeeId($value)
 * @method static Builder|WorkingDay whereEndAt($value)
 * @method static Builder|WorkingDay whereId($value)
 * @method static Builder|WorkingDay whereStartAt($value)
 * @method static Builder|WorkingDay whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static Builder|WorkingDay whereCalendarDate($value)
 */
class WorkingDay extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $dates = ['calendar_date'];

   /*
   |--------------------------------------------------------------------------
   | RELATIONS
   |--------------------------------------------------------------------------
   */

   public function employee(): BelongsTo
   {
       return $this->belongsTo(Employee::class);
   }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    public function getStartAtAttribute(string $value) : string
    {
        return Carbon::parse($value)->format('H:i');
    }

    public function getEndAtAttribute(string $value) : string
    {
        return Carbon::parse($value)->format('H:i');
    }
}
