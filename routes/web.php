<?php

use App\Livewire\Customer\CreateCustomer;
use App\Livewire\Customer\EditCustomer;
use App\Livewire\Customer\ListCustomers;
use App\Livewire\Items\CreateInventory;
use App\Livewire\Items\CreateItem;
use App\Livewire\Items\EditInventory;
use App\Livewire\Items\EditItem;
use App\Livewire\Items\ListInventories;
use App\Livewire\Items\ListItems;
use App\Livewire\Management\CreatePaymentMethod;
use App\Livewire\Management\CreateUser;
use App\Livewire\Management\EditPaymentMethod;
use App\Livewire\Management\EditUser;
use App\Livewire\Management\ListPaymentMethods;
use App\Livewire\Management\ListUsers;
use App\Livewire\Sales\ListSales;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/manage-users',ListUsers::class)->name('users.index');
    Route::get('/create-user',CreateUser::class)->name('user.create');
    Route::get('/edit-user/{record}',EditUser::class)->name('user.edit');

    Route::get('/manage-items',ListItems::class)->name('items.index');
    Route::get('/create-item',CreateItem::class)->name('item.create');
    Route::get('/edit-item/{record}',EditItem::class)->name('item.edit');

    Route::get('/manage-customers',ListCustomers::class)->name('customers.index');
    Route::get('/create-customer',CreateCustomer::class)->name('customer.create');
    Route::get('/edit-customer/{record}',EditCustomer::class)->name('customer.edit');

    Route::get('/manage-sales',ListSales::class)->name('sales.index');

    Route::get('/manage-payment-method',ListPaymentMethods::class)->name('payment.index');
    Route::get('/create-payment-method',CreatePaymentMethod::class)->name('payment.create');
    Route::get('/edit-payment/{record}',EditPaymentMethod::class)->name('payment.edit');
    
    Route::get('/manage-inventories',ListInventories::class)->name('inventories.index');
    Route::get('/create-inventories',CreateInventory::class)->name('inventory.create');
    Route::get('/edit-inventory/{record}',EditInventory::class)->name('inventory.edit');
});
require __DIR__.'/settings.php';
