<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $guarded = [];

    public function category() {
        return $this -> belongsTo(Category::class);
        }
    public function brand() {
        return $this -> belongsTo(Brand::class);
    }
    public function tags() {
        return $this -> belongsToMany(Tag::class);
    }
    public function image() {
        return $this -> hasMany(ProductImage::class);
    }
    public function images() {
        return $this -> hasMany(ProductImage::class);
    }
    public function posts() {
        return $this -> belongsToMany(Post::class, 'post_related_products');
    }
    public function attributeValues() {
        return $this -> hasMany(ProductAttributeValue::class);
    }
    public function carts() {
        return $this -> hasMany(CartItem::class);
    }
    public function wishlists() {
        return $this -> hasMany(WishlistItem::class);
    }
    public function reviews() {
        return $this -> hasMany(Review::class);
    }
    public function relations() {
        return $this -> hasMany(ProductRelation::class);
    }
    public function relatedBy() {
        return $this -> hasMany(ProductRelation::class, 'related_product_id');
    }
    public function orderItems() {
        return $this -> hasMany(OrderItem::class);
    }
}
