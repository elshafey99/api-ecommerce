<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $banners = [
            [
                'title' => ['ar' => 'عروض الموسم الجديد', 'en' => 'New Season Offers'],
                'subtitle' => ['ar' => 'خصومات تصل إلى 50%', 'en' => 'Discounts up to 50%'],
                'image' => 'uploads/banners/banner1.jpg',
                'mobile_image' => null,
                'link_type' => 'none',
                'link_id' => null,
                'external_url' => null,
                'position' => 'home_slider',
                'start_date' => null,
                'end_date' => null,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'title' => ['ar' => 'تسوق الآن', 'en' => 'Shop Now'],
                'subtitle' => ['ar' => 'أحدث المنتجات بأفضل الأسعار', 'en' => 'Latest products at best prices'],
                'image' => 'uploads/banners/banner2.jpg',
                'mobile_image' => null,
                'link_type' => 'none',
                'link_id' => null,
                'external_url' => null,
                'position' => 'home_slider',
                'start_date' => null,
                'end_date' => null,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'title' => ['ar' => 'عروض حصرية', 'en' => 'Exclusive Deals'],
                'subtitle' => ['ar' => 'لفترة محدودة فقط', 'en' => 'For a limited time only'],
                'image' => 'uploads/banners/banner3.jpg',
                'mobile_image' => null,
                'link_type' => 'none',
                'link_id' => null,
                'external_url' => null,
                'position' => 'home_banner',
                'start_date' => null,
                'end_date' => null,
                'is_active' => true,
                'sort_order' => 1,
            ],
        ];

        foreach ($banners as $banner) {
            Banner::create($banner);
        }
    }
}
