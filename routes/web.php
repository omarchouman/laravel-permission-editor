<?php

use OmarChouman\LaravelPermissionEditor\Http\Controllers\PermissionController;
use OmarChouman\LaravelPermissionEditor\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;

Route::resource('roles', RoleController::class);
Route::resource('permissions', PermissionController::class);
