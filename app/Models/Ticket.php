<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = ['customer_id', 'subject', 'message', 'status', 'answered_at'];

    public function customer(){
        $this->belongsTo(Customer::class);
    }
}
