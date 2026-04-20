<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Banner;
use App\Models\Brand;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\PostComment;
use App\Models\Product;
use App\Models\ProductAttributeValue;
use App\Models\ProductImage;
use App\Models\ProductRelation;
use App\Models\Promocode;
use App\Models\Review;
use App\Models\Role;
use App\Models\Tag;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\Wishlist;
use App\Models\WishlistItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $roles = Role::factory()->count(4)->create();

        $admin = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $users = User::factory()->count(14)->create();
        $allUsers = $users->prepend($admin);

        $allUsers->each(function (User $user) use ($roles, $admin): void {
            $roleIds = $roles->random(fake()->numberBetween(1, 2))->pluck('id')->all();

            if ($user->is($admin)) {
                $roleIds = $roles->pluck('id')->take(2)->all();
            }

            $user->roles()->sync($roleIds);
        });

        $allUsers->each(function (User $user): void {
            UserAddress::factory()->count(fake()->numberBetween(1, 2))->create([
                'user_id' => $user->id,
            ]);
        });

        $categories = Category::factory()->count(6)->create();
        $brands = Brand::factory()->count(8)->create();
        $tags = Tag::factory()->count(12)->create();

        $attributes = collect([
            Attribute::factory()->create([
                'name' => 'Color',
                'slug' => 'color',
                'type' => 'select',
            ]),
            Attribute::factory()->create([
                'name' => 'Storage',
                'slug' => 'storage',
                'type' => 'select',
            ]),
            Attribute::factory()->create([
                'name' => 'Warranty',
                'slug' => 'warranty',
                'type' => 'number',
            ]),
            Attribute::factory()->create([
                'name' => 'Material',
                'slug' => 'material',
                'type' => 'text',
            ]),
        ]);

        $attributeValues = collect();
        $attributeValues = $attributeValues->merge($this->seedAttributeValues($attributes));

        $products = Product::factory()->count(30)->create()->each(function (Product $product) use (
            $categories,
            $brands,
            $tags,
            $attributes,
            $attributeValues
        ): void {
            $product->update([
                'category_id' => $categories->random()->id,
                'brand_id' => $brands->random()->id,
            ]);

            $product->tags()->sync($tags->random(fake()->numberBetween(1, 4))->pluck('id')->all());

            ProductImage::factory()->count(fake()->numberBetween(1, 3))->create([
                'product_id' => $product->id,
            ]);

            $attributes->each(function (Attribute $attribute) use ($product, $attributeValues): void {
                $payload = [
                    'product_id' => $product->id,
                    'attribute_id' => $attribute->id,
                    'attribute_value_id' => null,
                    'value_text' => null,
                    'value_number' => null,
                ];

                if ($attribute->type === 'select') {
                    $payload['attribute_value_id'] = $attributeValues
                        ->where('attribute_id', $attribute->id)
                        ->random()
                        ->id;
                }

                if ($attribute->type === 'text') {
                    $payload['value_text'] = fake()->words(2, true);
                }

                if ($attribute->type === 'number') {
                    $payload['value_number'] = fake()->randomFloat(1, 1, 36);
                }

                ProductAttributeValue::factory()->create($payload);
            });

            Review::factory()->count(fake()->numberBetween(0, 4))->create([
                'product_id' => $product->id,
            ]);
        });

        $this->seedProductRelations($products);

        $postCategories = PostCategory::factory()->count(4)->create();
        $posts = Post::factory()->count(12)->create()->each(function (Post $post) use (
            $allUsers,
            $postCategories,
            $tags,
            $products
        ): void {
            $post->update([
                'author_id' => $allUsers->random()->id,
                'category_id' => $postCategories->random()->id,
            ]);

            $post->tags()->sync($tags->random(fake()->numberBetween(1, 3))->pluck('id')->all());
            $post->products()->sync($products->random(fake()->numberBetween(1, 4))->pluck('id')->all());

            PostComment::factory()->count(fake()->numberBetween(0, 5))->create([
                'post_id' => $post->id,
                'user_id' => $allUsers->random()->id,
            ]);
        });

        $allUsers->take(10)->each(function (User $user) use ($products): void {
            $cart = Cart::factory()->create([
                'user_id' => $user->id,
            ]);

            $cartProducts = $products->random(fake()->numberBetween(1, 4));
            foreach ($cartProducts as $product) {
                CartItem::factory()->create([
                    'cart_id' => $cart->id,
                    'product_id' => $product->id,
                    'price' => $product->price,
                ]);
            }
        });

        $allUsers->take(8)->each(function (User $user) use ($products): void {
            $wishlist = Wishlist::factory()->create([
                'user_id' => $user->id,
            ]);

            $wishlistProducts = $products->random(fake()->numberBetween(1, 5));
            foreach ($wishlistProducts as $product) {
                WishlistItem::factory()->create([
                    'wishlist_id' => $wishlist->id,
                    'product_id' => $product->id,
                ]);
            }
        });

        $orders = Order::factory()->count(18)->create()->each(function (Order $order) use ($allUsers, $products): void {
            if ($order->user_id === null) {
                $order->update(['user_id' => $allUsers->random()->id]);
            }

            $orderProducts = $products->random(fake()->numberBetween(1, 4));
            $subtotal = 0;

            foreach ($orderProducts as $product) {
                $quantity = fake()->numberBetween(1, 3);
                $price = $product->price;
                $lineTotal = round($price * $quantity, 2);
                $subtotal += $lineTotal;

                OrderItem::factory()->create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_sku' => $product->sku ?? strtoupper(fake()->bothify('SKU-####-??')),
                    'price' => $price,
                    'quantity' => $quantity,
                    'total' => $lineTotal,
                ]);
            }

            $discount = fake()->randomFloat(2, 0, min(5000, $subtotal / 3));
            $delivery = fake()->randomFloat(2, 0, 1500);

            $order->update([
                'subtotal' => round($subtotal, 2),
                'discount_amount' => round($discount, 2),
                'delivery_amount' => round($delivery, 2),
                'total_amount' => round($subtotal - $discount + $delivery, 2),
            ]);

            Payment::factory()->create([
                'order_id' => $order->id,
                'amount' => $order->total_amount,
            ]);

            Delivery::factory()->create([
                'order_id' => $order->id,
            ]);
        });

        Banner::factory()->count(4)->create();
        Promocode::factory()->count(6)->create();
    }

    private function seedAttributeValues(Collection $attributes): Collection
    {
        $map = [
            'color' => ['black', 'white', 'silver', 'blue'],
            'storage' => ['128gb', '256gb', '512gb', '1tb'],
        ];

        $values = collect();

        foreach ($attributes as $attribute) {
            if (! isset($map[$attribute->slug])) {
                continue;
            }

            foreach ($map[$attribute->slug] as $value) {
                $values->push(AttributeValue::factory()->create([
                    'attribute_id' => $attribute->id,
                    'name' => ucfirst($value),
                    'value' => $value,
                    'slug' => $attribute->slug.'-'.$value,
                ]));
            }
        }

        return $values;
    }

    private function seedProductRelations(Collection $products): void
    {
        $products->each(function (Product $product) use ($products): void {
            $relatedProducts = $products
                ->where('id', '!=', $product->id)
                ->random(fake()->numberBetween(1, min(3, $products->count() - 1)));

            foreach ($relatedProducts as $relatedProduct) {
                ProductRelation::factory()->create([
                    'product_id' => $product->id,
                    'related_product_id' => $relatedProduct->id,
                ]);
            }
        });
    }
}
