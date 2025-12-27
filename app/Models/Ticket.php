<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Enums\TicketStatus;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;


class Ticket extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'customer_id',
        'subject',
        'message',
        'status',
        'answered_at',
        'manager_answer',
    ];

    public function customer()
{
    return $this->belongsTo(Customer::class);
}



protected $casts = [
    'status' => TicketStatus::class,
    'answered_at' => 'datetime',
];

public function scopeStatus($query, string $status)
{
    return $query->where('status', $status);
}

public function scopeLastDay($query)
    {
        return $query->where('created_at', '>=', now()->subDay());
    }


    public function scopeLastWeek($query)
    {
        return $query->where('created_at', '>=', now()->subWeek());
    }
}
