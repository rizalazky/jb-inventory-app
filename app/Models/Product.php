<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'name',
        'category_id',
        'description',
        'stock',
        'image',
    ];

    public static function generateProductCode()
    {
        // Generate the date part
        $date = now()->format('Ymd'); // e.g., '20240825'

        // Get the last transaction number for the day
        $lastProduct = self::whereDate('created_at', now()->format('Y-m-d'))
            ->orderBy('id', 'desc')
            ->first();

        // Determine the next sequence number
        if ($lastProduct) {
            $lastSequence = intval(substr($lastProduct->code, -5));
            $nextSequence = $lastSequence + 1;
        } else {
            $nextSequence = 1;
        }

        // Format the sequence number as a 5-digit string
        $sequence = str_pad($nextSequence, 5, '0', STR_PAD_LEFT);

        
        $productCode = 'ITM-' . $date . '-' . $sequence;

        return $productCode;
    }

    public static function boot()
    {
        parent::boot();

        // Automatically generate the transaction number before saving
        static::creating(function ($product) {
            $product->code = self::generateProductCode();
        });

    }

    public function productprices():HasMany
    {
        return $this->hasMany(ProductPrice::class);
    }

    public function transaction_details():HasMany
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public function stoks():HasMany
    {
        return $this->hasMany(Stock::class);
    }

    public function unitconversions():HasMany
    {
        return $this->hasMany(UnitConversion::class);
    }

    public function productcategory(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class,'category_id','id');
    }
}
