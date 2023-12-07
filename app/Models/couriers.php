<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class couriers extends Model
{
    use HasFactory;

    protected $table = 'couriers';
    
    protected $primaryKey = 'courier_id';

    protected $fillable = ['first_name', 'last_name', 'phone_number','vehicle_number','hub_id'];

    /**
     * Define the relationship with the User model.
     */
    public function users()
    {
        return $this->hasOne(Users::class, 'user_id');
    }
    
    public function courier_hubs()
    {
        return $this->belongsTo(courier_hubs::class, 'hub_id');
    }

    public function orders()
    {
        return $this->hasMany(orders::class, 'courier_id');
    }

    public function getNextRunNumber()
        {
            $runNumber = $this->current_run_number;
            $this->current_run_number = $runNumber + 1;
            $this->save();
            return $runNumber;
        }
}
