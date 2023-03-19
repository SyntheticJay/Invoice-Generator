<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\Invoice\InvoiceController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Currency\CurrencyController;
use App\Http\Controllers\VATRule\VATRuleController;
use App\Http\Controllers\DefaultSetting\DefaultSettingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function() {
    return redirect()->route('login');
});

Auth::routes(['register' => false]);

Route::middleware(['auth'])->group(function() {
    Route::get('home', [HomeController::class, 'index'])->name('home');
    
    Route::get('profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::middleware(['ensure-proper-setup'])->group(function() {
        Route::resource('invoice', InvoiceController::class)->except(['edit', 'update']);

        Route::middleware(['ensure-correct-access:invoice'])->group(function() {
            Route::get('invoice/{invoice}/edit', [InvoiceController::class, 'edit'])->name('invoice.edit');
            Route::put('invoice/{invoice}', [InvoiceController::class, 'update'])->name('invoice.update');
            Route::get('invoice/{invoice}/resend', [InvoiceController::class, 'resend'])->name('invoice.resend');
        });

        Route::get('invoice/{invoice}/download', [InvoiceController::class, 'download'])->name('invoice.download');    
    });

    Route::get('customer', [CustomerController::class, 'index'])->name('customer.index');
    Route::get('customer/create', [CustomerController::class, 'create'])->name('customer.create');
    Route::middleware(['ensure-correct-access:customer'])->group(function() {
        Route::resource('customer', CustomerController::class)->except(['show', 'index', 'create']);
        Route::get('customer/{customer}/unarchive', [CustomerController::class, 'unarchive'])->name('customer.unarchive');
    });

    Route::get('currency', [CurrencyController::class, 'index'])->name('currency.index');
    Route::get('currency/create', [CurrencyController::class, 'create'])->name('currency.create');
    Route::middleware(['ensure-correct-access:currency'])->group(function() {
        Route::resource('currency', CurrencyController::class)->except(['show', 'index', 'create']);
        Route::get('currency/{currency}/unarchive', [CurrencyController::class, 'unarchive'])->name('currency.unarchive');
    });

    Route::get('vatrule', [VATRuleController::class, 'index'])->name('vatrule.index');
    Route::get('vatrule/create', [VATRuleController::class, 'create'])->name('vatrule.create');
    Route::middleware(['ensure-correct-access:vatRule'])->group(function() {
        Route::resource('vatrule', VATRuleController::class)->except(['show', 'index', 'create']);
        Route::get('vatrule/{vatrule}/unarchive', [VATRuleController::class, 'unarchive'])->name('vatrule.unarchive');
    });
});
