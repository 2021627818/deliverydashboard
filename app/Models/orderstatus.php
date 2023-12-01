<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class orderstatus extends Model
{
    use HasFactory;

    protected $table = 'orderstatus';

    protected $primaryKey = 'status_id';

    protected $fillable = [
        'status',
        'order_id',
    ];

    public $timestamps = true;

    // Define relationships
    public function orders()
    {
        return $this->belongsTo(orders::class, 'order_id');
    }
}
