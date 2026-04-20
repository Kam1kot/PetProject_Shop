<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $guarded = false;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function orders() {
        return $this -> hasMany(Order::class);
    }
    public function addresses() {
        return $this -> hasMany(UserAddress::class);
    }
    public function reviews() {
        return $this -> hasMany(Review::class);
    }
    public function posts() {
        return $this -> hasMany(Post::class, 'author_id');
    }
    public function postComments() {
        return $this -> hasMany(PostComment::class);
    }
    public function roles() {
        return $this -> belongsToMany(Role::class);
    }
    public function cart() {
        return $this -> hasOne(Cart::class);
    }
    public function wishlist() {
        return $this -> hasOne(Wishlist::class);
    }
    public function wishlists() {
        return $this -> hasOne(Wishlist::class);
    }
    
}
