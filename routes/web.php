<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\ManageRoleController;
use App\Http\Controllers\ManageUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserGalleryController;
use Illuminate\Support\Facades\Route;

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


Route::group(['middleware' => ['web','guest', 'throttle']], function (){

    Route::controller(UserController::class)->group(function () {

        Route::get('/login', 'login')->name('admin.login');
        Route::post('/login', 'loginData')->name('admin.login.data');
        Route::get('/forgot-password', 'forgotPassword')->name('admin.forgot.password');
        Route::post('/forgot-password', 'forgotPasswordData')->name('admin.forgot.password.data');
        Route::get('/reset-password/{token}', 'resetPassword')->name('admin.reset.password');
        Route::post('/reset-password/{token}', 'resetPasswordData')->name('admin.reset.password.data');

    });

});


//Route::group(['middleware' => ['auth', 'permission']],function () {
Route::group(['middleware' => ['auth']],function () {

    Route::get('/logout', [UserController::class, 'logout'])->name('admin.logout');

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('admin/roles')->group(function () {
        Route::controller(ManageUserController::class)->group(function () {
            Route::get('/manage-users', 'manageUser')->name('manage.users');
            Route::get('/add-user', 'addUser')->name('user.add');
            Route::post('/add-user', 'addUserData')->name('user.add.data');
            Route::get('/update-user/{userId}', 'updateUser')->name('user.update');
            Route::post('/update-user/{userId}', 'updateUserData')->name('user.update.data');
            Route::get('/user-detail/{userId}', 'getUserDetail')->name('user.detail');
            Route::get('/change-user-status/{companyId}', 'changeUserStatus')->name('user.change.status');
            Route::get('/delete-user/{userId}', 'deleteUser')->name('user.delete');
        });
    });

    Route::prefix('admin/roles')->group(function () {
        Route::controller(ManageRoleController::class)->group(function () {
            Route::get('/', 'manageRoles')->name('manage.roles');
            Route::get('/add', 'addRole')->name('role.add');
            Route::post('/add', 'addRoleData')->name('role.add.data');
            Route::get('/update/{roleId}', 'updateRole')->name('role.update');
            Route::post('/update/{roleId}', 'updateRoleData')->name('role.update.data');
            Route::get('/role-detail/{roleId}', 'getRoleDetail')->name('role.detail');
            Route::get('/change-role-status/{roleId}', 'changeRoleStatus')->name('role.change.status');
        });
    });

    Route::prefix('admin/user-gallery')->group(function () {
        Route::controller(UserGalleryController::class)->group(function () {
            Route::get('/', 'index')->name('manage.user.gallery');
            Route::get('/add', 'addImage')->name('user.gallery.add');
            Route::post('/add', 'addImageData')->name('user.gallery.add.data');
            Route::get('/update/{imageId}', 'updateImage')->name('user.gallery.update');
            Route::post('/update/{imageId}', 'updateImageData')->name('user.gallery.update.data');
            Route::get('/image-detail/{imageId}', 'getImageDetail')->name('user.gallery.detail');
            Route::get('/change-role-status/{imageId}', 'changeImageStatus')->name('image.change.status');
            Route::get('/delete/{imageId}', 'deleteImage')->name('user.gallery.delete');
        });
    });

    Route::controller(AccountController::class)->group(function () {
        Route::get('/manage-account', 'index')->name('manage.account');
        Route::post('/manage-account-data', 'manageAccountData')->name('manage.account.data');
    });
});
