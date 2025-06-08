<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use SoftDeletes;

    const STATUS_FINDING_DRIVER = 'finding_driver';
    const STATUS_DRIVER_PICKUP = 'driver_pickup';
    const STATUS_DRIVER_DELIVER = 'driver_deliver';
    const STATUS_ARRIVED = 'arrived';
    const STATUS_PAID = 'paid';
    const STATUS_CANCELLED = 'cancelled';


protected $fillable = [
    'costumer_id',
    'driver_id',
    'latitude_origin',
    'longitude_origin',
    'address_origin',
    'latitude_destination',
    'longitude_destination',
    'address_destination',
    'distance',
    'price',
    'status',
    'time_estimate',
];

protected $cast = [
    'latitude_origin'=>'float',
    'langitude_origin'=>'float',
    'latitude_destination'=> 'float',
    'langitude_destination'=> 'float',
    'distance' => 'float',
    'price'=>'float',
    'time_estimate'=>'integer',
];


public function customer(): BelongsTo
{
    return $this->belongsTo(User::class, 'customer_id');
}

public function driver(): BelongsTo
{
    return $this->belongsTo(User::class,'driver_id');
}

public function getStatusColorAttribute(): string
{
    return match($this->status){
        self::STATUS_FINDING_DRIVER => 'warning',
        self::STATUS_DRIVER_PICKUP,
        self::STATUS_DRIVER_DELIVER=>'primary',
        self::STATUS_ARRIVED,
        self::STATUS_PAID=>'success',
        self::STATUS_CANCELLED=>'danger',
        default => 'secondary',
    };
}

}