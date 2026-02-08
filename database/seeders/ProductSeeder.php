<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure we have some categories and brands
        if (Category::count() == 0) {
            $this->call(CategorySeeder::class);
        }
        if (Brand::count() == 0) {
            $this->call(BrandSeeder::class);
        }

        $categories = Category::all();
        $brands = Brand::all();

        // Generate 50 dummy products
        for ($i = 0; $i < 50; $i++) {
            $nameEn = fake()->unique()->words(3, true);
            $nameAr = 'منتج تجريبي ' . fake()->unique()->numberBetween(1000, 9999);

            $price = fake()->randomFloat(2, 10, 1000);
            $hasSale = fake()->boolean(30); // 30% chance of sale

            $product = Product::create([
                'name' => ['ar' => $nameAr, 'en' => ucfirst($nameEn)],
                'slug' => Str::slug($nameEn),
                'description' => [
                    'ar' => fake()->paragraph(3),
                    'en' => fake()->paragraph(3)
                ],
                'price' => $price,
                'sale_price' => $hasSale ? $price * 0.8 : null,
                'cost_price' => $price * 0.6,
                'sku' => strtoupper(Str::random(8)),
                'barcode' => fake()->ean13(),
                'stock_quantity' => fake()->numberBetween(0, 500),
                'min_order_quantity' => 1,
                'max_order_quantity' => fake()->numberBetween(10, 100),
                'weight' => fake()->randomFloat(2, 0.1, 10),
                'is_active' => fake()->boolean(90),
                'is_featured' => fake()->boolean(20),
                'track_stock' => true,
                'brand_id' => $brands->random()->id ?? null,
                'category_id' => $categories->random()->id ?? null,
            ]);

            // Add images for each product (using placeholders or existing files if mapped)
            // For now, we will create records without physical files, or point to a default placeholder
            // In a real seeder with images, you'd copy files to storage.

            // Let's assume we have a placeholder or just create DB records
            // To make it look real in frontend, we'll use a placeholder URL structure if the app supports it, 
            // OR simply put dummy paths that might not render but show the logic.
            // Better: Use a reliable placeholder service or a local asset if available.

            // Creating 1-4 images per product
            $imageCount = fake()->numberBetween(1, 4);
            for ($j = 0; $j < $imageCount; $j++) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => 'products/default.png', // Default placeholder path in storage
                    'is_primary' => $j === 0,
                    'sort_order' => $j,
                    'alt_text' => ['ar' => $nameAr, 'en' => $nameEn]
                ]);
            }
        }
    }
}
