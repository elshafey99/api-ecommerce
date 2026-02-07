<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $paymentMethods = [
            [
                'code' => 'cash',
                'name' => ['ar' => 'الدفع عند الاستلام', 'en' => 'Cash on Delivery'],
                'description' => ['ar' => 'ادفع نقداً عند استلام طلبك', 'en' => 'Pay cash when you receive your order'],
                'icon' => 'cash.png',
                'is_active' => true,
                'requires_payment_proof' => false,
                'sort_order' => 1,
            ],
            [
                'code' => 'wallet',
                'name' => ['ar' => 'المحفظة', 'en' => 'Wallet'],
                'description' => ['ar' => 'ادفع من رصيد محفظتك', 'en' => 'Pay from your wallet balance'],
                'icon' => 'wallet.png',
                'is_active' => true,
                'requires_payment_proof' => false,
                'sort_order' => 2,
            ],
            [
                'code' => 'visa',
                'name' => ['ar' => 'بطاقة ائتمان', 'en' => 'Credit Card'],
                'description' => ['ar' => 'ادفع ببطاقة الائتمان الخاصة بك', 'en' => 'Pay with your credit card'],
                'icon' => 'visa.png',
                'is_active' => true,
                'requires_payment_proof' => false,
                'sort_order' => 3,
            ],
            [
                'code' => 'instapay',
                'name' => ['ar' => 'انستاباي', 'en' => 'InstaPay'],
                'description' => ['ar' => 'حول عبر تطبيق انستاباي', 'en' => 'Transfer via InstaPay app'],
                'icon' => 'instapay.png',
                'is_active' => true,
                'requires_payment_proof' => true,
                'sort_order' => 4,
            ],
            [
                'code' => 'vodafone_cash',
                'name' => ['ar' => 'فودافون كاش', 'en' => 'Vodafone Cash'],
                'description' => ['ar' => 'حول عبر فودافون كاش', 'en' => 'Transfer via Vodafone Cash'],
                'icon' => 'vodafone.png',
                'is_active' => true,
                'requires_payment_proof' => true,
                'sort_order' => 5,
            ],
        ];

        foreach ($paymentMethods as $method) {
            PaymentMethod::updateOrCreate(
                ['code' => $method['code']],
                $method
            );
        }
    }
}
