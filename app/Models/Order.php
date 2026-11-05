<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    public const STATUSES = [
        'received', 'washing', 'drying', 'ironing',
        'ready', 'completed', 'cancelled',
    ];

    public const TRANSITIONS = [
        'received'  => ['washing', 'cancelled'],
        'washing'   => ['drying', 'cancelled'],
        'drying'    => ['ironing', 'cancelled'],
        'ironing'   => ['ready', 'cancelled'],
        'ready'     => ['completed', 'cancelled'],
        'completed' => [],
        'cancelled' => [],
    ];

    protected $fillable = [
        'invoice_no', 'outlet_id', 'user_id',
        'customer_name', 'customer_phone',
        'notes', 'pickup_at',
    ];

    protected $casts = [
        'total_amount' => 'integer',
        'pickup_at'    => 'datetime',
        'delivered_at' => 'datetime',
    ];

    
    public function outlet(): BelongsTo
    {
        return $this->belongsTo(Outlet::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function statusHistories(): HasMany
    {
        return $this->hasMany(OrderStatusHistory::class)->latest('created_at');
    }

    
    public function canTransitionTo(string $status): bool
    {
        return in_array($status, self::TRANSITIONS[$this->status] ?? [], true);
    }

    
    public function recalculateTotals(): void
    {
        $this->total_amount = (int) $this->items()->sum('subtotal');
        $paid = (int) $this->payments()->where('status', 'paid')->sum('amount');

        $this->payment_status = match (true) {
            $paid <= 0                   => 'unpaid',
            $paid >= $this->total_amount => 'paid',
            default                      => 'partial',
        };
        $this->save();
    }
}