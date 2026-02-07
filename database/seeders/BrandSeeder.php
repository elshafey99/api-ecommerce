<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            [
                'name' => ['ar' => 'دوبل بريك', 'en' => 'Double Break'],
                'slug' => 'double-break',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => ['ar' => 'كوكاكولا', 'en' => 'Coca-Cola'],
                'slug' => 'coca-cola',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => ['ar' => 'بيبسي', 'en' => 'Pepsi'],
                'slug' => 'pepsi',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => ['ar' => 'فانتا', 'en' => 'Fanta'],
                'slug' => 'fanta',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => ['ar' => 'سبرايت', 'en' => 'Sprite'],
                'slug' => 'sprite',
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'name' => ['ar' => 'ميرندا', 'en' => 'Miranda'],
                'slug' => 'miranda',
                'is_active' => true,
                'sort_order' => 6,
            ],
            [
                'name' => ['ar' => 'سفن أب', 'en' => '7UP'],
                'slug' => '7up',
                'is_active' => true,
                'sort_order' => 7,
            ],
        ];

        foreach ($brands as $brand) {
            Brand::updateOrCreate(
                ['slug' => $brand['slug']],
                $brand
            );
        }
    }
}
