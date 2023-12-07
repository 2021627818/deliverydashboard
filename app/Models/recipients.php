<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class recipients extends Model
{
    use HasFactory;

    protected $table = 'recipients';

    protected $primaryKey = 'recipient_id';

    protected $fillable = [
        'recipient_first_name', 
        'recipient_last_name', 
        'recipient_phone_number',
        'recipient_address_line1', 
        'recipient_address_line2', 
        'recipient_postal_code', 
        'recipient_city', 
        'recipient_state', 
        'recipient_country'];

    public $timestamps = true;

    // Define relationships
    public function order()
    {
        return $this->belongsTo(orders::class, 'order_id');
    }
}
