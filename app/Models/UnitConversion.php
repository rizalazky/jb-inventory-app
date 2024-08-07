<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UnitConversion extends Model
{
    use HasFactory;
    protected $fillable =[
        'product_id',
        'product_price_id_from',
        'product_price_id_to',
        'value'
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(ProductPrice::class,'product_id','id');
    }

    public function productprice_from(): BelongsTo
    {
        return $this->belongsTo(ProductPrice::class,'product_price_id_from','id');
    }
    public function productprice_to(): BelongsTo
    {
        return $this->belongsTo(ProductPrice::class,'product_price_id_to','id');
    }
}
