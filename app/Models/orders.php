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
        'order_date',
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

    public function courierhubs()
    {
        return $this->hasOne(courierhubs::class, 'hub_id');
    }

    public function couriers()
    {
        return $this->belongsTo(Couriers::class, 'courier_id');
    }

    public function orderstatus()
    {
        return $this->hasMany(orderstatus::class, 'order_id');
    }
}
