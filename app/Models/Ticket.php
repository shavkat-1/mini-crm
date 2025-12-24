<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Enums\TicketStatus;


class Ticket extends Model
{
    protected $fillable = ['customer_id', 'subject', 'message', 'status', 'answered_at'];

    public function customer(): BelongsTo
{
    return $this->belongsTo(Customer::class);
}


protected $casts = [
    'status' => TicketStatus::class,
    'answered_at' => 'datetime',
];


}
