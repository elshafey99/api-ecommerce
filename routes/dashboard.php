<?php

use Livewire\Livewire;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\SettingsController;
use App\Http\Controllers\Dashboard\Auth\AuthController;
use App\Http\Controllers\Dashboard\Auth\ForgotController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\Dashboard\Auth\ResetPasswordController;






Route::group([
    'prefix' => LaravelLocalization::setLocale() . '/dashboard',
    'as' => 'dashboard.',
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
], function () {

    Livewire::setUpdateRoute(function ($handle) {
        return Route::post('/livewire/update', $handle);
    });


    ############################### Auth Routes ############################################
    Route::get('login',       [AuthController::class, 'login'])->name('login');
    Route::post('login/post', [AuthController::class, 'loginPost'])->name('login.post');
    Route::post('logout',     [AuthController::class, 'logout'])->name('logout');

    ############################### Forgot Password Routes ############################################
    Route::group(['prefix' => 'password', 'as' => 'password.'], function () {
        Route::get('email',          [ForgotController::class, 'showEmailForm'])->name('email');
        Route::post('email',         [ForgotController::class, 'sendOTP'])->name('sendOTP');
        Route::get('verify/{email}', [ForgotController::class, 'showOtpForm'])->name('showOtpForm');
        Route::post('verify',        [ForgotController::class, 'verifyOtp'])->name('verifyOtp');

        ############################### Reset Password Routes ############################################
        Route::get('reset/{email}',  [ResetPasswordController::class, 'showResetForm'])->name('resetForm');
        Route::post('reset',         [ResetPasswordController::class, 'resetPassword'])->name('reset');
    });

    ############################### Admin Routes ############################################
    Route::group(['middleware' => 'auth:admin'], function () {

        ############################### Auth Routes ############################################
        Route::get('home', [AuthController::class, 'home'])->name('home');
        Route::get('profile', [ProfileController::class, 'profile'])->name('profile');
        Route::get('security', [ProfileController::class, 'security'])->name('security');
        Route::post('profile/update', [ProfileController::class, 'profileUpdate'])->name('profile.update');
        Route::post('profile/update/password', [ProfileController::class, 'profileUpdatePassword'])->name('profile.update.password');

        ############################### Role Routes ############################################
        Route::get('roles', function () {
            return view('dashboard.roles.index');
        })->middleware('can:roles')->name('roles.index');
        ############################### End Role Routes ############################################

        ############################### Brands Routes ############################################
        Route::get('brands', function () {
            return view('dashboard.brands.index');
        })->middleware('can:brands')->name('brands.index');
        ############################### End Brands Routes ############################################

        ############################### Categories Routes ############################################
        Route::get('categories', function () {
            return view('dashboard.categories.index');
        })->middleware('can:categories')->name('categories.index');
        ############################### End Categories Routes ############################################

        ############################### Branches Routes ############################################
        Route::get('branches', function () {
            return view('dashboard.branches.index');
        })->middleware('can:branches')->name('branches.index');
        ############################### End Branches Routes ############################################

        ############################### Payment Methods Routes ############################################
        Route::get('payment-methods', function () {
            return view('dashboard.paymentmethods.index');
        })->middleware('can:payment_methods')->name('payment-methods.index');
        ############################### End Payment Methods Routes ############################################

        ############################### Products Routes ############################################
        Route::get('products', function () {
            return view('dashboard.products.index');
        })->middleware('can:products')->name('products.index');
        ############################### End Products Routes ############################################

        ############################### Banners Routes ############################################
        Route::get('banners', function () {
            return view('dashboard.banners.index');
        })->middleware('can:banners')->name('banners.index');
        ############################### End Banners Routes ############################################

        ############################### FAQs Routes ############################################
        Route::get('faqs', function () {
            return view('dashboard.faqs.index');
        })->middleware('can:faqs')->name('faqs.index');
        ############################### End FAQs Routes ############################################

        ############################### Reviews Routes ############################################
        Route::get('reviews', function () {
            return view('dashboard.reviews.index');
        })->middleware('can:reviews')->name('reviews.index');
        ############################### End Reviews Routes ############################################

        ############################### Pages Routes ############################################
        Route::get('pages', function () {
            return view('dashboard.pages.index');
        })->middleware('can:pages')->name('pages.index');
        ############################### End Pages Routes ############################################

        ############################### Coupons Routes ############################################
        Route::get('coupons', function () {
            return view('dashboard.coupons.index');
        })->middleware('can:coupons')->name('coupons.index');
        ############################### End Coupons Routes ############################################


        ############################### Admin Routes ############################################
        Route::get('admins', function () {
            return view('dashboard.admins.index');
        })->middleware('can:admins')->name('admins.index');
        ############################### End Amin Routes ############################################

        ############################### Users Routes ############################################
        // Route::get('users',                  [UserController::class, 'index'])->middleware('can:users')->name('users.index');
        // Route::get('user/profile/{id}',      [UserController::class, 'userProfile'])->middleware('can:users')->name('user.profile');
        // ############################### End Users Routes #########################################

        ############################### Locations Routes ############################################
        // Route::get('locations', function () {
        //     return view('dashboard.locations.countries.index');
        // })->name('locations.index');
        // Route::get('governorates', function () {
        //     return view('dashboard.locations.governorates.index');
        // })->name('governorates.index');
        // Route::get('governorate-centers', function () {
        //     return view('dashboard.locations.center-governorate.index');
        // })->name('centers.index');
        ############################### End Locations Routes ############################################ 

        ############################### settings Routes ############################################
        Route::get('settings',            [SettingsController::class, 'genralSetting'])->middleware('can:settings')->name('settings');
        ############################### End settings Routes ############################################

    });
});
