<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['store_id', 'account_id', 'type', 'amount', 'description', 'transaction_date'];

    protected $casts = ['transaction_date' => 'date'];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
