<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'service_id',
        'service_name_snapshot', 'unit_snapshot',
        'price_snapshot', 'qty', 'subtotal',
    ];

    protected $casts = [
        'price_snapshot' => 'integer',
        'qty'            => 'integer',
        'subtotal'       => 'integer',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}