<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grup extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $table = 'grup';

    public function grupitem()
    {
        return $this->hasMany(Grup_item::class, 'grup_id', 'id');
    }
}
