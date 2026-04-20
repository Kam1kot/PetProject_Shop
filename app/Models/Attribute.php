<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    /** @use HasFactory<\Database\Factories\AttributeFactory> */
    use HasFactory;

    protected $guarded = [];

    public function attributeValue() {
        return $this -> hasMany(AttributeValue::class);
    }
    public function productAttributeValue() {
        return $this -> hasMany(ProductAttributeValue::class);
    }
}
