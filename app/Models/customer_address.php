<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class customer_address extends Model
{
    use HasFactory;

    protected $table = 'customer_address';

    protected $primaryKey = 'address_id';

    protected $fillable = ['address_line1', 'address_line2', 'postal_code', 'city', 'state', 'country'];

    /**
     * Define the relationship with the User model.
     */

    public function customer_profiles()
    {
        return $this->belongsTo(customer_profiles::class, 'customer_id');
    }
}
