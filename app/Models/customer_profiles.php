<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class customer_profiles extends Model
{
    use HasFactory;

    protected $primaryKey = 'customer_id';

    protected $fillable = ['first_name', 'last_name', 'phone_number'];

    /**
     * Define the relationship with the User model.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function customer_address()
    {
        return $this->hasOne(customer_address::class, 'customer_id');
    }

    public function order()
    {
        return $this->hasMany(orders::class, 'customer_id');
    }
}
