<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class postalcodes extends Model
{
    use HasFactory;

    protected $table = 'postalcodes';

    protected $primaryKey = 'postal_code';

    public $timestamps = true;

    // Define relationships
    public function courierhubs()
    {
        return $this->belongsTo(courierhubs::class, 'hub_id');
    }
}