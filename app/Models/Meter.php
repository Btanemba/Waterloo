<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meter extends Model
{
    use HasFactory;

    protected $fillable = [
        'customers_id',  // Foreign key
        'meter_number',
        'address',
        'postCode',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customers_id'); // Foreign key column
    }
}
