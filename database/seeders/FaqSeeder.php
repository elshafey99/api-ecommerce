<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            // General
            [
                'question' => ['ar' => 'كيف يمكنني إنشاء حساب جديد؟', 'en' => 'How can I create a new account?'],
                'answer' => ['ar' => 'يمكنك إنشاء حساب جديد عن طريق الضغط على زر "تسجيل" في أعلى الصفحة وملء البيانات المطلوبة.', 'en' => 'You can create a new account by clicking the "Register" button at the top of the page and filling in the required information.'],
                'category' => 'general',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'question' => ['ar' => 'هل يمكنني تغيير بيانات حسابي؟', 'en' => 'Can I change my account information?'],
                'answer' => ['ar' => 'نعم، يمكنك تعديل بيانات حسابك من خلال صفحة الملف الشخصي بعد تسجيل الدخول.', 'en' => 'Yes, you can edit your account information through the profile page after logging in.'],
                'category' => 'general',
                'is_active' => true,
                'sort_order' => 2,
            ],

            // Orders
            [
                'question' => ['ar' => 'كيف يمكنني تتبع طلبي؟', 'en' => 'How can I track my order?'],
                'answer' => ['ar' => 'يمكنك تتبع طلبك من خلال صفحة "طلباتي" في حسابك أو عن طريق رقم التتبع المرسل لك عبر البريد الإلكتروني.', 'en' => 'You can track your order through the "My Orders" page in your account or using the tracking number sent to your email.'],
                'category' => 'orders',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'question' => ['ar' => 'هل يمكنني إلغاء طلبي؟', 'en' => 'Can I cancel my order?'],
                'answer' => ['ar' => 'يمكنك إلغاء طلبك قبل شحنه. تواصل معنا عبر خدمة العملاء لإتمام عملية الإلغاء.', 'en' => 'You can cancel your order before it ships. Contact our customer service to complete the cancellation process.'],
                'category' => 'orders',
                'is_active' => true,
                'sort_order' => 2,
            ],

            // Shipping
            [
                'question' => ['ar' => 'ما هي مدة التوصيل؟', 'en' => 'What is the delivery time?'],
                'answer' => ['ar' => 'مدة التوصيل تتراوح من 2-5 أيام عمل حسب موقعك.', 'en' => 'Delivery time ranges from 2-5 business days depending on your location.'],
                'category' => 'shipping',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'question' => ['ar' => 'هل التوصيل مجاني؟', 'en' => 'Is shipping free?'],
                'answer' => ['ar' => 'نعم، التوصيل مجاني للطلبات التي تتجاوز 200 ريال. وللطلبات الأقل يتم احتساب رسوم توصيل.', 'en' => 'Yes, shipping is free for orders over 200 SAR. For smaller orders, a shipping fee applies.'],
                'category' => 'shipping',
                'is_active' => true,
                'sort_order' => 2,
            ],

            // Payment
            [
                'question' => ['ar' => 'ما هي طرق الدفع المتاحة؟', 'en' => 'What payment methods are available?'],
                'answer' => ['ar' => 'نقبل الدفع عن طريق البطاقات الائتمانية، مدى، Apple Pay، وكذلك الدفع عند الاستلام.', 'en' => 'We accept credit cards, Mada, Apple Pay, and cash on delivery.'],
                'category' => 'payment',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'question' => ['ar' => 'هل الموقع آمن للدفع الإلكتروني؟', 'en' => 'Is the website secure for online payment?'],
                'answer' => ['ar' => 'نعم، جميع المعاملات مشفرة ومؤمنة بأحدث تقنيات الحماية SSL.', 'en' => 'Yes, all transactions are encrypted and secured with the latest SSL protection technologies.'],
                'category' => 'payment',
                'is_active' => true,
                'sort_order' => 2,
            ],

            // Returns
            [
                'question' => ['ar' => 'ما هي سياسة الاسترجاع؟', 'en' => 'What is the return policy?'],
                'answer' => ['ar' => 'يمكنك استرجاع المنتج خلال 14 يوم من تاريخ الاستلام بشرط أن يكون في حالته الأصلية.', 'en' => 'You can return the product within 14 days of receipt, provided it is in its original condition.'],
                'category' => 'returns',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'question' => ['ar' => 'كيف يمكنني طلب استرجاع؟', 'en' => 'How can I request a return?'],
                'answer' => ['ar' => 'يمكنك طلب الاسترجاع من خلال صفحة "طلباتي" أو التواصل مع خدمة العملاء.', 'en' => 'You can request a return through the "My Orders" page or by contacting customer service.'],
                'category' => 'returns',
                'is_active' => true,
                'sort_order' => 2,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }
    }
}
