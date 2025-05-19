<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    use HasFactory;
    protected $fillable = [
        'warranty_code',
        'unit',
        'serial_number',
        'customer',
        'po_number',
        'so_number',
        'expired_date',
        'delivery_date',
        'installed_date',
        'handover_date',
    ];

    protected $table = 'items';
        
}
