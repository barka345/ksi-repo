<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'outlet_id', 'name', 'unit', 'price', 'duration_hours', 'is_active',
    ];

    protected $casts = [
        'price'          => 'integer',
        'duration_hours' => 'integer',
        'is_active'      => 'boolean',
    ];

    public function outlet(): BelongsTo
    {
        return $this->belongsTo(Outlet::class);
    }

    
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
