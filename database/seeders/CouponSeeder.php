<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $coupons = [
            [
                'code' => 'WELCOME20',
                'name' => [
                    'ar' => 'خصم الترحيب',
                    'en' => 'Welcome Discount',
                ],
                'description' => [
                    'ar' => 'خصم خاص للعملاء الجدد',
                    'en' => 'Special discount for new customers',
                ],
                'discount_type' => 'percentage',
                'discount_value' => 20.00,
                'min_order_amount' => 100.00,
                'max_discount_amount' => 50.00,
                'usage_limit' => 100,
                'usage_limit_per_user' => 1,
                'used_count' => 15,
                'start_date' => now()->subDays(10),
                'end_date' => now()->addDays(20),
                'is_active' => true,
            ],
            [
                'code' => 'SUMMER2024',
                'name' => [
                    'ar' => 'خصم الصيف',
                    'en' => 'Summer Sale',
                ],
                'description' => [
                    'ar' => 'عروض الصيف لجميع المنتجات',
                    'en' => 'Summer offers on all products',
                ],
                'discount_type' => 'percentage',
                'discount_value' => 15.00,
                'min_order_amount' => 200.00,
                'max_discount_amount' => 100.00,
                'usage_limit' => null, // unlimited
                'usage_limit_per_user' => 3,
                'used_count' => 45,
                'start_date' => now()->subDays(5),
                'end_date' => now()->addDays(60),
                'is_active' => true,
            ],
            [
                'code' => 'FIXED50',
                'name' => [
                    'ar' => 'خصم 50 جنيه',
                    'en' => '50 EGP Discount',
                ],
                'description' => [
                    'ar' => 'خصم ثابت 50 جنيه على جميع الطلبات',
                    'en' => 'Fixed 50 EGP discount on all orders',
                ],
                'discount_type' => 'fixed',
                'discount_value' => 50.00,
                'min_order_amount' => 300.00,
                'max_discount_amount' => null,
                'usage_limit' => 50,
                'usage_limit_per_user' => 2,
                'used_count' => 12,
                'start_date' => now()->subDays(3),
                'end_date' => now()->addDays(30),
                'is_active' => true,
            ],
            [
                'code' => 'BLACKFRIDAY',
                'name' => [
                    'ar' => 'الجمعة السوداء',
                    'en' => 'Black Friday',
                ],
                'description' => [
                    'ar' => 'عروض الجمعة السوداء - خصم 30%',
                    'en' => 'Black Friday deals - 30% off',
                ],
                'discount_type' => 'percentage',
                'discount_value' => 30.00,
                'min_order_amount' => 500.00,
                'max_discount_amount' => 200.00,
                'usage_limit' => 200,
                'usage_limit_per_user' => 1,
                'used_count' => 0,
                'start_date' => now()->addDays(90),
                'end_date' => now()->addDays(93),
                'is_active' => false,
            ],
            [
                'code' => 'VIP100',
                'name' => [
                    'ar' => 'كوبون VIP',
                    'en' => 'VIP Coupon',
                ],
                'description' => [
                    'ar' => 'خصم حصري لعملاء VIP',
                    'en' => 'Exclusive discount for VIP customers',
                ],
                'discount_type' => 'fixed',
                'discount_value' => 100.00,
                'min_order_amount' => 1000.00,
                'max_discount_amount' => null,
                'usage_limit' => 20,
                'usage_limit_per_user' => 5,
                'used_count' => 8,
                'start_date' => now()->subDays(15),
                'end_date' => now()->addDays(45),
                'is_active' => true,
            ],
            [
                'code' => 'EXPIRED10',
                'name' => [
                    'ar' => 'كوبون منتهي',
                    'en' => 'Expired Coupon',
                ],
                'description' => [
                    'ar' => 'كوبون اختبار منتهي الصلاحية',
                    'en' => 'Test expired coupon',
                ],
                'discount_type' => 'percentage',
                'discount_value' => 10.00,
                'min_order_amount' => 50.00,
                'max_discount_amount' => 30.00,
                'usage_limit' => 100,
                'usage_limit_per_user' => 1,
                'used_count' => 75,
                'start_date' => now()->subDays(30),
                'end_date' => now()->subDays(5),
                'is_active' => false,
            ],
        ];

        foreach ($coupons as $coupon) {
            Coupon::create($coupon);
        }
    }
}
