<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class courierhubs extends Model
{
    use HasFactory;
    protected $table = 'courierhubs';

    protected $primaryKey = 'hub_id';

    public $timestamps = true;

    // Define relationships
    public function couriers()
    {
        return $this->hasMany(Couriers::class, 'hub_id');
    }

    public function postalcodes()
    {
        return $this->hasMany(postalcodes::class, 'hub_id');
    }

    public function orders()
    {
        return $this->hasMany(orders::class, 'hub_id');
    }
}
