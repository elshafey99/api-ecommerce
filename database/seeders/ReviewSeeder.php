<?php

namespace Database\Seeders;

use App\Models\Review;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some users, products, and orders (assuming they exist)
        $users = User::limit(10)->get();
        $products = Product::limit(20)->get();

        if ($users->isEmpty() || $products->isEmpty()) {
            return;
        }

        $reviews = [
            [
                'user_id' => $users->random()->id,
                'product_id' => $products->random()->id,
                'order_id' => null,
                'rating' => 5,
                'comment' => 'منتج ممتاز وجودة عالية جداً، أنصح بشدة بالشراء',
                'is_approved' => true,
            ],
            [
                'user_id' => $users->random()->id,
                'product_id' => $products->random()->id,
                'order_id' => null,
                'rating' => 4,
                'comment' => 'منتج جيد لكن التوصيل كان متأخر قليلاً',
                'is_approved' => true,
            ],
            [
                'user_id' => $users->random()->id,
                'product_id' => $products->random()->id,
                'order_id' => null,
                'rating' => 5,
                'comment' => 'Amazing product! Exactly as described and arrived quickly.',
                'is_approved' => true,
            ],
            [
                'user_id' => $users->random()->id,
                'product_id' => $products->random()->id,
                'order_id' => null,
                'rating' => 3,
                'comment' => 'المنتج مقبول، السعر مرتفع قليلاً',
                'is_approved' => false,
            ],
            [
                'user_id' => $users->random()->id,
                'product_id' => $products->random()->id,
                'order_id' => null,
                'rating' => 5,
                'comment' => 'Very satisfied with my purchase. Will buy again!',
                'is_approved' => true,
            ],
            [
                'user_id' => $users->random()->id,
                'product_id' => $products->random()->id,
                'order_id' => null,
                'rating' => 2,
                'comment' => 'المنتج لا يطابق الوصف، جودة أقل من المتوقع',
                'is_approved' => false,
            ],
            [
                'user_id' => $users->random()->id,
                'product_id' => $products->random()->id,
                'order_id' => null,
                'rating' => 4,
                'comment' => 'Good quality product. Fast delivery.',
                'is_approved' => true,
            ],
            [
                'user_id' => $users->random()->id,
                'product_id' => $products->random()->id,
                'order_id' => null,
                'rating' => 5,
                'comment' => 'رائع! تجربة شراء ممتازة',
                'is_approved' => true,
            ],
            [
                'user_id' => $users->random()->id,
                'product_id' => $products->random()->id,
                'order_id' => null,
                'rating' => 1,
                'comment' => 'منتج سيء جداً، لا يستحق الثمن',
                'is_approved' => false,
            ],
            [
                'user_id' => $users->random()->id,
                'product_id' => $products->random()->id,
                'order_id' => null,
                'rating' => 4,
                'comment' => 'جودة جيدة وسعر مناسب',
                'is_approved' => true,
            ],
        ];

        foreach ($reviews as $review) {
            Review::create($review);
        }
    }
}
