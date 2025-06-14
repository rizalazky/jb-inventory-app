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
        "transaction_id",
        "transaction_detail_id",
        "quantity",
        "base_quantity",
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
            $quantity = $stock->base_quantity;
            if ($stock->type == 'in') {
                $product->stock += $quantity;
            } else {
                $product->stock -= $quantity;
            }
            $product->save();
        });

        static::updated(function (Stock $stock) {
             // Get the original Stock instance
             $originalStock = new Stock($stock->getOriginal());

            // Get the original quantity using the get_quantity method
            $originalQuantity = $originalStock->base_quantity;

            $product = $stock->product;
            $newQuantity = $stock->base_quantity;

            // Revert the original stock change
            if ($stock->type == 'in') {
                $product->stock -= $originalQuantity;
                $product->stock += $newQuantity;
            } else {
                $product->stock += $originalQuantity;
                $product->stock -= $newQuantity;
            }

            $product->save();
        });

        static::deleted(function (Stock $stock) {
            $product = $stock->product;
            $quantity = $stock->base_quantity;
            if ($stock->type == 'in') {
                $product->stock -= $quantity;
            } else {
                $product->stock += $quantity;
            }
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

    public function transaction_detail():BelongsTo
    {
        return $this->belongsTo(TransactionDetail::class,'transaction_detail_id','id');
    }

    public function transaction():BelongsTo
    {
        return $this->belongsTo(TransactionDetail::class,'transaction_id','id');
    }

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class,'user_by','id');
    }
}
