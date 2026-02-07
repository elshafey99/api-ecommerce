<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Branch::truncate();

        // فرع الجيزة - الفرع الرئيسي
        Branch::create([
            'name' => [
                'ar' => 'فرع الجيزة',
                'en' => 'Giza Branch'
            ],
            'address' => [
                'ar' => 'الجيزة، مصر',
                'en' => 'Giza, Egypt'
            ],
            'phone' => '+201000000001',
            'whatsapp' => '+201000000001',
            'email' => 'giza@example.com',
            'latitude' => 30.0131,
            'longitude' => 31.2089,
            'delivery_fee' => 25.00,
            'min_order_amount' => 100.00,
            'free_delivery_threshold' => 500.00,
            'working_hours' => [
                'saturday' => ['open' => '09:00', 'close' => '22:00'],
                'sunday' => ['open' => '09:00', 'close' => '22:00'],
                'monday' => ['open' => '09:00', 'close' => '22:00'],
                'tuesday' => ['open' => '09:00', 'close' => '22:00'],
                'wednesday' => ['open' => '09:00', 'close' => '22:00'],
                'thursday' => ['open' => '09:00', 'close' => '23:00'],
                'friday' => ['open' => '14:00', 'close' => '23:00'],
            ],
            'is_active' => true,
            'is_main' => true,
            'sort_order' => 1,
        ]);

        // فرع الغردقة
        Branch::create([
            'name' => [
                'ar' => 'فرع الغردقة',
                'en' => 'Hurghada Branch'
            ],
            'address' => [
                'ar' => 'الغردقة، البحر الأحمر، مصر',
                'en' => 'Hurghada, Red Sea, Egypt'
            ],
            'phone' => '+201000000002',
            'whatsapp' => '+201000000002',
            'email' => 'hurghada@example.com',
            'latitude' => 27.2579,
            'longitude' => 33.8116,
            'delivery_fee' => 30.00,
            'min_order_amount' => 150.00,
            'free_delivery_threshold' => 600.00,
            'working_hours' => [
                'saturday' => ['open' => '10:00', 'close' => '23:00'],
                'sunday' => ['open' => '10:00', 'close' => '23:00'],
                'monday' => ['open' => '10:00', 'close' => '23:00'],
                'tuesday' => ['open' => '10:00', 'close' => '23:00'],
                'wednesday' => ['open' => '10:00', 'close' => '23:00'],
                'thursday' => ['open' => '10:00', 'close' => '00:00'],
                'friday' => ['open' => '14:00', 'close' => '00:00'],
            ],
            'is_active' => true,
            'is_main' => false,
            'sort_order' => 2,
        ]);
    }
}
