<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\ActionController;
use App\Http\Controllers\DetailServiceInformationController;
use App\Http\Controllers\GoBackController;
use App\Http\Controllers\ImageTypeController;
use App\Http\Controllers\ServiceController;

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

Route::get('/', function () {
    return view('login');
})->name('inicio');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/action/{detailaction}/{detailservice}', [ActionController::class, 'index'])
                ->middleware(['auth'])
                ->middleware(['validateAction'])
                ->name('action');

Route::post('/action/save', [ActionController::class, 'save'])
                ->middleware('auth')
                ->name('guardar_elemento');

Route::get('/action/get/image/{filename}', [ActionController::class, 'getImage'])
                ->name('get_image');

Route::get('/action/delete/service_information/{service_information}', [ActionController::class, 'delete'])
                ->middleware('auth')
                ->name('delete_service_information');

Route::get('/action/edit/service_information/{id_service_information}', [ActionController::class, 'update'])
                ->middleware(['auth'])
                ->name('edit_service_information');

Route::post('/action/confirm/edit/service_information/', [ActionController::class, 'confirm_update'])
                ->middleware('auth')
                ->name('editar_elemento');

Route::get('/confirm_delete/{service_information}', [ActionController::class, 'confirm_delete'])
                ->middleware('auth')
                ->name('confirm_delete_service_information');

Route::get('/action/list/detail_service/{id_service_information}', [DetailServiceInformationController::class, 'listDetailView'])
                ->middleware('auth')
                ->name('list_detail_service');

Route::get('/action/add/detail_service/{id_service_information}', [DetailServiceInformationController::class, 'addDetailView'])
                ->middleware('auth')
                ->name('add_detail_service');
                
Route::post('/action/save/detail_service/', [DetailServiceInformationController::class, 'save'])
                ->middleware('auth')
                ->name('save_detail_service');

Route::get('/action/management/images/{id_image_type}', [ImageTypeController::class, 'index'])
                ->middleware('auth')
                ->name('image_management');

Route::get('/action/get/image_gallery/{id_image_type}', [ImageTypeController::class, 'getImage'])
                ->name('get_image_gallery');

Route::post('/action/save/image_gallery/', [ImageTypeController::class, 'addImageGallery'])
                ->middleware('auth')
                ->name('save_image_gallery');

Route::post('/action/delete/image_gallery/', [ImageTypeController::class, 'deleteImageGallery'])
                ->middleware('auth')
                ->name('delete_image_gallery');

Route::get('/management/services/', [ServiceController::class, 'index'])
                ->middleware('auth')
                ->name('service_management');

Route::post('/action/management/service/add/', [ServiceController::class, 'addService'])
                ->middleware('auth')
                ->name('add_service');

Route::get('/action/management/service/edit/{id_service}', [ServiceController::class, 'editServiceView'])
                ->middleware('auth')
                ->name('edit_service_view');

Route::post('/action/management/service/edit/', [ServiceController::class, 'editService'])
                ->middleware('auth')
                ->name('edit_service');

Route::get('/action/management/service/delete/{id_service}', [ServiceController::class, 'deleteServiceView'])
                ->middleware('auth')
                ->name('delete_service_view');

Route::get('/action/management/service/confirm_delete/{id_service}', [ServiceController::class, 'confirm_delete'])
                ->middleware('auth')
                ->name('confirm_delete_service');

require __DIR__.'/auth.php';
