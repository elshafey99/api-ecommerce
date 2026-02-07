<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::create([
            'site_name'       => [
                'en' => 'Double Break Paradise',
                'ar' => 'دبل بريك باراديس',
            ],
            'site_desc'       => [
                'en' => "Double Break Paradise is your ultimate destination for premium soft drinks and refreshing beverages. We offer a wide variety of carbonated drinks, juices, and energy drinks delivered right to your doorstep.",
                'ar' => 'دبل بريك باراديس هي وجهتك المثالية للمشروبات الغازية الفاخرة والمشروبات المنعشة. نقدم تشكيلة واسعة من المشروبات الغازية والعصائر ومشروبات الطاقة توصل إلى باب منزلك.',
            ],

            'site_phone'      => '+966500000000',
            'site_address'    => [
                'en' => 'Riyadh, Saudi Arabia',
                'ar' => 'الرياض، المملكة العربية السعودية',
            ],
            'about_us'    => [
                'en' => 'Double Break Paradise is a leading soft drinks distributor, committed to bringing you the freshest and most delicious beverages. With our easy-to-use online platform, you can order your favorite drinks and have them delivered quickly and conveniently.',
                'ar' => 'دبل بريك باراديس هي شركة رائدة في توزيع المشروبات الغازية، ملتزمون بتقديم أفضل المشروبات الطازجة واللذيذة. من خلال منصتنا الإلكترونية السهلة الاستخدام، يمكنك طلب مشروباتك المفضلة وتوصيلها بسرعة وسهولة.',
            ],
            'site_email'      => 'info@doublebreakparadise.com',
            'email_support'   => 'support@doublebreakparadise.com',
            'facebook'        => 'https://facebook.com/doublebreakparadise',
            'x_url'           => 'https://x.com/doublebreakparadise',
            'youtube'         => 'https://youtube.com/@doublebreakparadise',
            'meta_desc'       => [
                'en' => "Double Break Paradise - Your one-stop shop for premium soft drinks, carbonated beverages, juices, and energy drinks. Fast delivery and best prices guaranteed.",
                'ar' => 'دبل بريك باراديس - متجرك الشامل للمشروبات الغازية الفاخرة والعصائر ومشروبات الطاقة. توصيل سريع وأفضل الأسعار مضمونة.',
            ],
            'logo'            => 'uploads/images/logo.png',
            'favicon'         => 'uploads/images/logo.png',
            'site_copyright'  => '© 2025 Double Break Paradise. All rights reserved.',
            'promotion_url'   => 'https://doublebreakparadise.com/promotion',

        ]);
    }
}
