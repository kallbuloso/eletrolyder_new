<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PhoneController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\ProfileController;
// routeImport

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render(
            'Dashboard',
            [
                'title' => 'Dashboard',
                'breadcrumbs' => [
                    ['title' => 'Dashboard', 'disabled' => true],
                ]
            ]
        );
    })->name('dashboard');

    // Route groups for Settings
    Route::group(['prefix' => 'settings', 'as' => 'settings.'], function () {

        // Route groups for Role
        Route::controller(RoleController::class)->prefix('role')->as('roles.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::get('/show/{id}', 'show')->name('show');
            Route::get('/{id}/edit', 'edit')->name('edit');
            Route::put('/{id}', 'update')->name('update');
            Route::delete('/{id}', 'destroy')->name('destroy');
        });

        // Route groups for Address
        Route::controller(AddressController::class)->prefix('addresses')->as('address.')->group(function () {
            Route::put('/{id}', 'update')->name('update');
            Route::delete('/{id}', 'destroy')->name('destroy');
        });
        // Route groups for Phone
        Route::controller(PhoneController::class)->prefix('phones')->as('phones.')->group(function () {
            Route::put('/{id}', 'update')->name('update');
            Route::delete('/{id}', 'destroy')->name('destroy');
        });
        // addRoute


    });

    // Route groups for Registrations
    Route::group(['prefix' => 'registers', 'as' => 'registers.'], function () {

        // Route groups for User
        Route::controller(UserController::class)->prefix('user')->as('user.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::get('/show/{id}', 'show')->name('show');
            Route::get('/{id}/edit', 'edit')->name('edit');
            Route::put('/{id}', 'update')->name('update');
            Route::delete('/{id}', 'destroy')->name('destroy');
        });
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// exemplo de rota para notificação
Route::post('/notify/{type}', function ($type) {
    return redirect()->back()->toast('Notificação do servidor =)', $type);
});

require __DIR__ . '/auth.php';
