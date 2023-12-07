<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class orders extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $primaryKey = 'order_id';

    protected $fillable = [
        'descriptions',
        'parcel_weight',
        'parcel_length',
        'parcel_width',
        'parcel_height',
        'next_hub_id',
    ];

    //public $timestamps = true;

    // Define relationships
    public function recipients()
    {
        return $this->hasOne(recipients::class, 'order_id');
    }

    public function customer_profiles()
    {
        return $this->hasOne(customer_profiles::class, 'customer_id');
    }

    public function courier_hubs()
    {
        return $this->hasOne(courier_hubs::class, 'hub_id');
    }

    public function couriers()
    {
        return $this->belongsTo(couriers::class, 'courier_id');
    }

    public function order_status()
    {
        return $this->hasMany(order_status::class, 'order_id');
    }
}
