<?php


use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\ClientsController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EmployeesController;
use App\Http\Controllers\Admin\PositionsController;
use App\Http\Controllers\Admin\SectionsController;
use App\Http\Controllers\Admin\ServicesController;
use App\Http\Controllers\Admin\VisitsController;
use App\Http\Controllers\Admin\WorkingDaysController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

Route::get('/login', [AuthenticatedSessionController::class, 'create'])
    ->middleware(['guest:'.config('fortify.guard')])
    ->name('login');

Route::middleware(['auth'])
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])
            ->name('dashboard');
        Route::resource('/employees', EmployeesController::class);
        Route::resource('/clients', ClientsController::class);
        Route::resource('/sections', SectionsController::class);
        Route::resource('/categories', CategoriesController::class);
        Route::resource('/services', ServicesController::class);
        Route::resource('/visits', VisitsController::class);
        Route::resource('/working-days', WorkingDaysController::class);
        Route::resource('/positions', PositionsController::class);
    });
