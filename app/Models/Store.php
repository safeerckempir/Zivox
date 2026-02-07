<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = ['name', 'address_line1', 'address_line2', 'city', 'state', 'postcode', 'country', 'currency', 'contact_number', 'contact_email', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
