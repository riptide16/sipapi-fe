<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\StorageController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\TestimonyController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\AssessorProfileController;
use App\Http\Controllers\Auth\VerifyController;
use App\Http\Controllers\FileDownloadController;
use App\Http\Controllers\FAQController;
use App\Http\Controllers\AccreditationController;
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

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('login', [LoginController::class, 'index'])->name('login');
Route::post('login/store', [LoginController::class, 'login'])->name('login.store');
Route::get('logout', [LoginController::class, 'logout'])->name('logout');
Route::prefix('forgot-password')->as('forgot_password.')->group(function () {
    Route::get('/', [ForgotPasswordController::class, 'index'])->name('index');
    Route::post('store', [ForgotPasswordController::class, 'store'])->name('store');
});

Route::get('reset-password', [ForgotPasswordController::class, 'edit'])->name('reset_password.edit');
Route::post('reset-password/update/{token}', [ForgotPasswordController::class, 'update'])->name('reset_password.update');

Route::prefix('register')->as('register.')->group(function () {
    Route::get('/', [RegisterController::class, 'index'])->name('index');
    Route::get('/asesor', [RegisterController::class, 'indexAsesor'])->name('index.asesor');
    Route::post('store', [RegisterController::class, 'store'])->name('store');
    Route::post('store/asesor', [RegisterController::class, 'storeAsesor'])->name('store.asesor');
    Route::get('reload-captcha', [RegisterController::class, 'reloadCaptcha'])->name('reload_captcha');
});

Route::get('verification/{token}', [VerifyController::class, 'index'])->name('verification.index');

Route::prefix('storage_files')->as('storage.')->group(function () {
    Route::get('secure/{path}', [StorageController::class, 'showSecureFile'])
         ->where('path', '.*')
         ->middleware('sessionAuth')
         ->name('secure');
    Route::get('{path}', [StorageController::class, 'showFile'])
         ->where('path', '.*')
         ->name('file');
});

Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/halaman/{parent}/{child}', [HomeController::class, 'dynamicMenu'])->name('home.dynamicMenu');
Route::get('/tentang-kami/informasi-umum', [AboutUsController::class, 'index'])->name('tentang-kami.informasi-umum');
Route::get('/tentang-kami/assessor', [AssessorProfileController::class, 'index'])->name('tentang-kami.asesor');
Route::get('/tentang-kami/assessor/{id}', [AssessorProfileController::class, 'show'])->name('tentang-kami.asesor.show');
Route::get('/tentang-kami/testimoni', [TestimonyController::class, 'index'])->name('tentang-kami.testimoni');
Route::get('/tentang-kami/penelusuran-akreditasi', [AccreditationController::class, 'browse'])->name('tentang-kami.akreditasi.browse');
Route::get('/tentang-kami/jumlah-perpustakaan-terakreditasi', [AccreditationController::class, 'totalByCategory'])->name('tentang-kami.total_by_category');

Route::get('/media/berita', [NewsController::class, 'index'])->name('media.berita.index');
Route::get('/media/berita/{id}', [NewsController::class, 'show'])->name('media.berita.show');
Route::get('/media/galeri', [GalleryController::class, 'index'])->name('media.galeri.index');
Route::get('/media/galeri/album/{slug}', [GalleryController::class, 'galleryAlbum'])->name('media.galeri.album');
Route::get('/media/video', [VideoController::class, 'index'])->name('media.video.index');
Route::get('/media/video/{id}', [VideoController::class, 'show'])->name('media.video.show');

Route::get('/layanan/unduh-berkas', [FileDownloadController::class, 'index'])->name('layanan.unduh.index');
Route::get('/layanan/faq', [FAQController::class, 'index'])->name('layanan.faq.index');

Route::get('/json/cities', [AccreditationController::class, 'getCities'])->name('json.cities');
