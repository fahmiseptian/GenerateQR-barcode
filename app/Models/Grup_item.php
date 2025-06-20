<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grup_item extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'grup_item';

    public function grup()
    {
        return $this->belongsTo(Grup::class, 'grup_id');
    }

    public function item()
    {
        return $this->belongsTo(Items::class, 'item_id');
    }
}
