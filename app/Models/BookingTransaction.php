<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingTransaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'phone_number',
        'email',
        'total_amount',
        'is_paid',
        'total_participant',
        'ticket_id',
        'started_at',
        'proof',
        'booking_trx_id',
    ];

    protected $casts = [
        'started_at' => 'date'
    ];
    
    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }

    // public function user(): BelongsTo
    // {
    //     return $this->belongsTo(User::class);
    // }

    public static function generateUniqueTrxId()
    {
        $prefix = 'JRT';
        do {
            $randomString = $prefix . mt_rand(1000, 9999);
        } while (self::where('booking_trx_id', $randomString)->exists());

        return $randomString;
    }
}
