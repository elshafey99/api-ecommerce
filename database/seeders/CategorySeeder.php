<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => ['ar' => 'مشروبات غازية', 'en' => 'Soft Drinks'],
                'slug' => 'soft-drinks',
                'description' => ['ar' => 'تشكيلة متنوعة من المشروبات الغازية', 'en' => 'Wide variety of soft drinks'],
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => ['ar' => 'عصائر', 'en' => 'Juices'],
                'slug' => 'juices',
                'description' => ['ar' => 'عصائر طبيعية ومركزة', 'en' => 'Natural and concentrated juices'],
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => ['ar' => 'مياه معدنية', 'en' => 'Mineral Water'],
                'slug' => 'mineral-water',
                'description' => ['ar' => 'مياه معدنية طبيعية', 'en' => 'Natural mineral water'],
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => ['ar' => 'مشروبات الطاقة', 'en' => 'Energy Drinks'],
                'slug' => 'energy-drinks',
                'description' => ['ar' => 'مشروبات الطاقة والتنشيط', 'en' => 'Energy and power drinks'],
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => ['ar' => 'مشروبات ساخنة', 'en' => 'Hot Beverages'],
                'slug' => 'hot-beverages',
                'description' => ['ar' => 'شاي وقهوة ومشروبات ساخنة', 'en' => 'Tea, coffee and hot beverages'],
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'name' => ['ar' => 'عروض خاصة', 'en' => 'Special Offers'],
                'slug' => 'special-offers',
                'description' => ['ar' => 'عروض وتخفيضات حصرية', 'en' => 'Exclusive deals and discounts'],
                'is_active' => true,
                'sort_order' => 6,
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
