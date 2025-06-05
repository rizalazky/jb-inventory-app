<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductPrice extends Model
{
    use HasFactory;
    protected $fillable =[
        'product_id',
        'unit_id',
        'buy_price',
        'sell_price',
        'unit_conversion_value',
        'is_default'
    ];

    public function unitconversions_from():HasMany
    {
        return $this->hasMany(UnitConversion::class, 'product_price_id_from');
    }

    public function unitconversions_to():HasMany
    {
        return $this->hasMany(UnitConversion::class, 'product_price_id_to');
    }

    public function convert_stock($targetUnitId,$value,$isReverse=false){
        $conversion = $this->unitconversions_to()->first();
        
        if ($conversion) {
            if($isReverse){
                return $value / $conversion->value;
            }else{
                return $value * $conversion->value;
            }
        }
        

        return null;
    }

    public function productunit(): BelongsTo
    {
        return $this->belongsTo(ProductUnit::class,'unit_id','id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
