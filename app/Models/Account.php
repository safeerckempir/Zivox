<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = ['store_id', 'name', 'type', 'balance'];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
