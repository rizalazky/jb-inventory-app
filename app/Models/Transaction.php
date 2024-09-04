<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'cash_paid',
        'change',
        'notes',
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
            $lastSequence = intval(substr($lastTransaction->transaction_number, -5));
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

        static::deleting(function ($transaction) {
            // Retrieve and delete all related TransactionDetail records
            $transaction->transaction_details->each(function ($detail) {
                $detail->delete(); // Triggers the deleting event in TransactionDetail model
            });
        });
    }

    public function transaction_details():HasMany
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class,'user_by','id');
    }

    public function customer():BelongsTo
    {
        return $this->belongsTo(Customer::class,'customer_id','id');
    }

    public function supplier():BelongsTo
    {
        return $this->belongsTo(Supplier::class,'supplier_id','id');
    }

    public function stocks():HasMany
    {
        return $this->hasMany(Stock::class)->onDelete('cascade');;
    }
    
}
