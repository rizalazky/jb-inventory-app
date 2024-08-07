<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'name',
        'category_id',
        'description',
        'stock',
    ];

    public function productprices():HasMany
    {
        return $this->hasMany(ProductPrice::class);
    }

    public function unitconversions():HasMany
    {
        return $this->hasMany(UnitConversion::class);
    }
}
