<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitConversion extends Model
{
    use HasFactory;
    protected $fillable =[
        'product_id',
        'unit_id_from',
        'unit_id_to',
        'value'
    ];
}
