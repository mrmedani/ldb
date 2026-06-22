<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Wilaya extends Model
{
    protected $fillable = ['code', 'name', 'delivery_time'];

    public function offices(): HasMany
    {
        return $this->hasMany(Office::class);
    }
}
