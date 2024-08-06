<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductPrice extends Model
{
    use HasFactory;
    protected $fillable =[
        'product_id',
        'unit_id',
        'price',
        'is_default'
    ];

    public function productunit(): BelongsTo
    {
        return $this->belongsTo(ProductUnit::class,'unit_id','id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
