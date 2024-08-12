<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Stock extends Model
{
    use HasFactory;
    protected $fillable =[
        "product_id",
        "product_price_id",
        "type",
        // "transaction_id",
        // "transaction_detail_id",
        "quantity",
        "notes",
        "user_by"
    ];

    protected function get_quantity(Stock $stock){
        $productprice = $stock->productprice;
        $quantity = $stock->quantity;
        if(!$productprice->is_default){
            $quantity = $productprice->convert_stock($productprice->id,$quantity,true);
        }
        return $quantity;
    }

    protected static function booted(): void
    {
        static::created(function (Stock $stock) {
            $product = $stock->product;
            $quantity= $stock->get_quantity($stock);
            $product->stock += $quantity;
            $product->save();
        });

        static::updated(function (Stock $stock) {
            $originalQuantity = $stock->getOriginal('quantity');
            $product = $stock->product;
            $quantity= $stock->get_quantity($stock);
            $product->stock += ($quantity - $originalQuantity);
            $product->save();
        });

        static::deleted(function (Stock $stock) {
            $product = $stock->product;
            $product->stock -= $stock->quantity;
            $product->save();
        });
    }

    public function product() : BelongsTo
    {
        return $this->belongsTo(Product::class,'product_id','id');
    }

    public function productprice():BelongsTo
    {
        return $this->belongsTo(ProductPrice::class,'product_price_id','id');
    }
}
