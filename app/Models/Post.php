<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory;

    protected $guarded = [];

    public function category() {
        return $this -> belongsTo(PostCategory::class);
    }
    public function tags() {
        return $this -> belongsToMany(Tag::class);
    }
    public function products() {
        return $this -> belongsToMany(Product::class, "post_related_products");
    }
    public function author() {
        return $this -> belongsTo(User::class);
    }
    public function comments() {
        return $this -> hasMany(PostComment::class);
    }
}
