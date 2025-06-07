<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PhoneController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\SoStatusController;
use App\Http\Controllers\SoStatusStepController;
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
        // Exemplo de rota com prefixo e nome
        Route::group(['prefix' => 'test', 'as' => 'child.'], function () {
            Route::get('/child1', function () {
                return Inertia::render('Dashboard', [
                    'title' => 'Child 1',
                    'breadcrumbs' => [
                        ['title' => 'Dashboard', 'href' => '/dashboard'],
                        ['title' => 'Child 1', 'disabled' => true],
                    ]
                ]);
            })->name('child1');
            Route::get('/child2', function () {
                return Inertia::render('Dashboard', [
                    'title' => 'Child 2',
                    'breadcrumbs' => [
                        ['title' => 'Dashboard', 'href' => '/dashboard'],
                        ['title' => 'Child 2', 'disabled' => true],
                    ]
                ]);
            })->name('child2');
            Route::get('/child3', function () {
                return Inertia::render('Dashboard', [
                    'title' => 'Child 3',
                    'breadcrumbs' => [
                        ['title' => 'Dashboard', 'href' => '/dashboard'],
                        ['title' => 'Child 3', 'disabled' => true],
                    ]
                ]);
            })->name('child3');
            // na rota: route('child.child1')
            // no navegador: http://localhost:8000/child/child1
        });

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
        Route::controller(PhoneController::class)->prefix('phones')->as('phone.')->group(function () {
            Route::put('/{id}', 'update')->name('update');
            Route::delete('/{id}', 'destroy')->name('destroy');
        });
        // Route groups for Company
        Route::controller(CompanyController::class)->prefix('companies')->as('company.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/{id}/phone', 'storePhone')->name('phone.store');
            Route::post('/{id}/address', 'storeAddress')->name('address.store');
            Route::put('/{id}', 'update')->name('update');
            Route::delete('/{id}', 'destroy')->name('destroy');
        });
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

        // Route groups for Client
        Route::controller(ClientController::class)->prefix('clients')->as('client.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::get('/show/{id}', 'show')->name('show');
            Route::get('/{id}/edit', 'edit')->name('edit');
            Route::post('/{id}/phone', 'storePhone')->name('phone.store');
            Route::post('/{id}/address', 'storeAddress')->name('address.store');
            Route::put('/{id}', 'update')->name('update');
            Route::delete('/{id}', 'destroy')->name('destroy');
        });

        // Route groups for Supplier
        Route::controller(SupplierController::class)->prefix('suppliers')->as('supplier.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::get('/show/{id}', 'show')->name('show');
            Route::get('/{id}/edit', 'edit')->name('edit');
            Route::post('/{id}/phone', 'storePhone')->name('phone.store');
            Route::post('/{id}/address', 'storeAddress')->name('address.store');
            Route::put('/{id}', 'update')->name('update');
            Route::delete('/{id}', 'destroy')->name('destroy');
        });
    });

    // Route groups for Order
    Route::group(['prefix' => 'orders', 'as' => 'orders.'], function () {
        // Route groups for SoStatus
        Route::controller(SoStatusController::class)->prefix('statuses')->as('soStatus.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::get('/show/{id}', 'show')->name('show');
            Route::get('/{id}/edit', 'edit')->name('edit');
            Route::put('/{id}', 'update')->name('update');
            Route::delete('/{id}', 'destroy')->name('destroy');
        });
        // Route groups for SoStatusStep
    Route::controller(SoStatusStepController::class)->prefix('so-status-steps')->as('soStatusStep.')->group(function () {
      Route::get('/', 'index') ->name('index');
      Route::get('/create', 'create') ->name('create');
      Route::post('/', 'store') ->name('store');
      Route::get('/show/{id}', 'show') ->name('show');
      Route::get('/{id}/edit', 'edit') ->name('edit');
      Route::post('/{id}/phone', 'storePhone')->name('phone.store');
      Route::post('/{id}/address', 'storeAddress')->name('address.store');
      Route::put('/{id}', 'update') ->name('update');
      Route::delete('/{id}', 'destroy') ->name('destroy');
    });
    // addRoute


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
