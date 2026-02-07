<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            [
                'slug' => 'about',
                'title' => ['ar' => 'من نحن', 'en' => 'About Us'],
                'content' => [
                    'ar' => '<h2>مرحباً بكم في دوبل بريك بارادايس</h2><p>نحن شركة رائدة في توزيع المشروبات الغازية والعصائر في مصر. نسعى لتوفير أفضل المنتجات بأسرع خدمة توصيل.</p>',
                    'en' => '<h2>Welcome to Double Break Paradise</h2><p>We are a leading soft drinks and juices distributor in Egypt. We strive to provide the best products with the fastest delivery service.</p>'
                ],
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'slug' => 'terms',
                'title' => ['ar' => 'الشروط والأحكام', 'en' => 'Terms & Conditions'],
                'content' => [
                    'ar' => '<h2>شروط الاستخدام</h2><p>باستخدامك لهذا التطبيق، فإنك توافق على الالتزام بهذه الشروط والأحكام.</p>',
                    'en' => '<h2>Terms of Use</h2><p>By using this application, you agree to comply with these terms and conditions.</p>'
                ],
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'slug' => 'privacy',
                'title' => ['ar' => 'سياسة الخصوصية', 'en' => 'Privacy Policy'],
                'content' => [
                    'ar' => '<h2>حماية خصوصيتك</h2><p>نحن نحترم خصوصيتك ونلتزم بحماية بياناتك الشخصية.</p>',
                    'en' => '<h2>Protecting Your Privacy</h2><p>We respect your privacy and are committed to protecting your personal data.</p>'
                ],
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'slug' => 'return-policy',
                'title' => ['ar' => 'سياسة الإرجاع', 'en' => 'Return Policy'],
                'content' => [
                    'ar' => '<h2>سياسة الإرجاع والاستبدال</h2><p>يمكنك إرجاع المنتجات خلال 24 ساعة من الاستلام في حالة وجود عيب.</p>',
                    'en' => '<h2>Return & Exchange Policy</h2><p>You can return products within 24 hours of delivery if defective.</p>'
                ],
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'slug' => 'delivery',
                'title' => ['ar' => 'سياسة التوصيل', 'en' => 'Delivery Policy'],
                'content' => [
                    'ar' => '<h2>خدمة التوصيل</h2><p>نوفر خدمة توصيل سريعة لجميع المناطق. رسوم التوصيل تختلف حسب المنطقة.</p>',
                    'en' => '<h2>Delivery Service</h2><p>We provide fast delivery to all areas. Delivery fees vary by location.</p>'
                ],
                'is_active' => true,
                'sort_order' => 5,
            ],
        ];

        foreach ($pages as $page) {
            Page::updateOrCreate(
                ['slug' => $page['slug']],
                $page
            );
        }
    }
}
