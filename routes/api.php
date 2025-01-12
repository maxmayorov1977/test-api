<?php

use App\Http\Controllers\Api\v1\OrganizationController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1'], static function () {
    Route::get('/organizations', [OrganizationController::class, 'organizations']);
    Route::get('/organizationById', [OrganizationController::class, 'organizationById']);
    Route::get('/organizationByName', [OrganizationController::class, 'organizationByName']);
    Route::get('/organizationsByBuilding', [OrganizationController::class, 'organizationsByBuilding']);
    Route::get('/organizationsByActivity', [OrganizationController::class, 'organizationsByActivity']);
    Route::get('/organizationsByAllActivities', [OrganizationController::class, 'organizationsByAllActivities']);
    Route::get('/organizationsByRadius', [OrganizationController::class, 'organizationsByRadius']);
    Route::get('/organizationsBySquare', [OrganizationController::class, 'organizationsBySquare']);
});
