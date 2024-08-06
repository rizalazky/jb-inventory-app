<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductUnit extends Model
{
    use HasFactory;
    protected $fillable = [
        'name'
    ];

    protected $table = 'product_unit';

    public function productprices():HasMany
    {
        return $this->hasMany(ProductPrice::class);
    }
}
