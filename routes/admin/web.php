<?php


use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\ClientsController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EmployeesController;
use App\Http\Controllers\Admin\EmployeeWorkingDaysController;
use App\Http\Controllers\Admin\PositionsController;
use App\Http\Controllers\Admin\SectionsController;
use App\Http\Controllers\Admin\ServicesController;
use App\Http\Controllers\Admin\VisitsController;
use App\Http\Controllers\Admin\Settings\GeneralSettingsController;
use App\Http\Controllers\Admin\Settings\WorkingDaysSettingsController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

Route::get('/login', [AuthenticatedSessionController::class, 'create'])
    ->middleware(['guest:'.config('fortify.guard')])
    ->name('login');

Route::middleware(['auth'])
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])
            ->name('dashboard');

        Route::resource('/clients', ClientsController::class);
        Route::resource('/sections', SectionsController::class);
        Route::resource('/categories', CategoriesController::class);
        Route::resource('/services', ServicesController::class);
        Route::resource('/visits', VisitsController::class);
        Route::resource('/working-days', GeneralSettingsController::class);
        Route::resource('/positions', PositionsController::class);
        Route::resource('/employees', EmployeesController::class);

        Route::prefix('employees')->group(function(){
            Route::get('/{id}/working-days/edit', [EmployeeWorkingDaysController::class, 'edit'])
                ->name('employees.working-days.edit');
            Route::put('/{id}/working-days/update', [EmployeeWorkingDaysController::class, 'update'])
                ->name('employees.working-days.update');
        });

        Route::prefix('settings')->group(function(){
            Route::get('/general', [GeneralSettingsController::class, 'edit'])
                ->name('settings.general.edit');
            Route::put('/general', [GeneralSettingsController::class, 'update'])
                ->name('settings.general.update');
            Route::get('/working-days', [WorkingDaysSettingsController::class, 'edit'])
                ->name('settings.working-days.edit');
            Route::put('/working-days', [WorkingDaysSettingsController::class, 'update'])
                ->name('settings.working-days.update');
        });

    });
