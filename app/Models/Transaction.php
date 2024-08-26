<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'type',
        'transaction_number',
        'date',
        'customer_id',
        'supplier_id',
        'sub_total',
        'discount',
        'total',
        'user_by',
    ];

    public static function generateTransactionNo()
    {
        // Generate the date part
        $date = now()->format('Ymd'); // e.g., '20240825'

        // Get the last transaction number for the day
        $lastTransaction = self::whereDate('created_at', now()->format('Y-m-d'))
            ->orderBy('id', 'desc')
            ->first();

        // Determine the next sequence number
        if ($lastTransaction) {
            $lastSequence = intval(substr($lastTransaction->transaction_no, -5));
            $nextSequence = $lastSequence + 1;
        } else {
            $nextSequence = 1;
        }

        // Format the sequence number as a 5-digit string
        $sequence = str_pad($nextSequence, 5, '0', STR_PAD_LEFT);

        // Combine parts to form the transaction number
        $transactionNo = 'TRX-' . $date . '-' . $sequence;

        return $transactionNo;
    }

    public static function boot()
    {
        parent::boot();

        // Automatically generate the transaction number before saving
        static::creating(function ($transaction) {
            $transaction->transaction_number = self::generateTransactionNo();
        });
    }

    public function transaction_details():HasMany
    {
        return $this->hasMany(TransactionDetail::class);
    }
    
}
