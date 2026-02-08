<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            AdminSeeder::class,
            SettingsSeeder::class,
            UserSeeder::class,
            BrandSeeder::class,
            CategorySeeder::class,
            PaymentMethodSeeder::class,
            PageSeeder::class,
            CouponSeeder::class,
            BranchSeeder::class,
            ProductSeeder::class,
            BannerSeeder::class,
            FaqSeeder::class,
            ReviewSeeder::class,
        ]);
    }
}
