<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Enums\TicketStatus;
use Carbon\Carbon;
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

 public function scopeToday($query)
    {
        return $query->whereDate('created_at', Carbon::today());
    }

    // Текущая неделя
    public function scopeThisWeek($query)
    {
        return $query->whereBetween('created_at', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek(),
        ]);
    }

    // Текущий месяц
    public function scopeThisMonth($query)
    {
        return $query
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month);
    }
}
