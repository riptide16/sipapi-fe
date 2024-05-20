<?php

use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProvinceController;
use App\Http\Controllers\Admin\RegionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\AccessController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\InstitutionController;
use App\Http\Controllers\Admin\InstrumentAspectController;
use App\Http\Controllers\Admin\InstrumentComponentController;
use App\Http\Controllers\Admin\InstrumentController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\SubdistrictController;
use App\Http\Controllers\Admin\VillageController;
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\Admin\TestimonyController;
use App\Http\Controllers\Admin\EmailTemplateController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\WilayahController;
use App\Http\Controllers\Admin\AccreditationController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\FileDownloadController;
use App\Http\Controllers\Admin\LogController;
use App\Http\Controllers\Admin\EvaluationController;
use App\Http\Controllers\Admin\CertificationController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\PublicMenuController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SelfAssessmentController;
use Illuminate\Support\Facades\Route;

Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::prefix('dashboard')->as('dashboard.')->group(function () {
    Route::get('get-chart-admin', [DashboardController::class, 'getDataChart'])->name('get_chart_admin');
    Route::get('get-chart-asesi', [DashboardController::class, 'getDataAsesi'])->name('get_chart_asesi');
    Route::get('get-chart-asesor', [DashboardController::class, 'getDataAsesor'])->name('get_chart_asesor');
});

Route::get('profile', [ProfileController::class, 'index'])->name('profile');
Route::post('profile', [ProfileController::class, 'update'])->name('profile.update');

Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('create', [UserController::class, 'create'])->name('create');
    Route::post('store', [UserController::class, 'store'])->name('store');
    Route::get('edit/{id}', [UserController::class, 'edit'])->name('edit');
    Route::post('update/{id}', [UserController::class, 'update'])->name('update');
    Route::delete('delete/{id}', [UserController::class, 'delete'])->name('delete');
    Route::get('/{id}', [UserController::class, 'show'])->name('show');
});

Route::group(['prefix' => 'role', 'as' => 'role.'], function () {
    Route::get('/', [RoleController::class, 'index'])->name('index');
    Route::get('create', [RoleController::class, 'create'])->name('create');
    Route::post('store', [RoleController::class, 'store'])->name('store');
    Route::get('edit/{id}', [RoleController::class, 'edit'])->name('edit');
    Route::post('update/{id}', [RoleController::class, 'update'])->name('update');
    Route::delete('delete/{id}', [RoleController::class, 'delete'])->name('delete');
});

Route::group(['prefix' => 'access', 'as' => 'access.'], function () {
    Route::get('/', [AccessController::class, 'index'])->name('index');
    Route::get('/{id}/edit', [AccessController::class, 'edit'])->name('edit');
    Route::post('/{id}/update', [AccessController::class, 'update'])->name('update');
    Route::get('/{id}/show', [AccessController::class, 'show'])->name('show');
});

Route::group(['prefix' => 'data-kelembagaan', 'as' => 'data_kelembagaan.'], function () {
    Route::get('/', [InstitutionController::class, 'index'])->name('index');
    Route::get('show/{id}', [InstitutionController::class, 'show'])->name('show');
    Route::get('verifikasi/{id}', [InstitutionController::class, 'verify'])->name('verify');
    Route::post('verified/{id}', [InstitutionController::class, 'verified'])->name('verified');
    Route::get('edit/{id}', [InstitutionController::class, 'edit'])->name('edit');
    Route::post('update/{id}', [InstitutionController::class, 'update'])->name('update');
    Route::post('store', [InstitutionController::class, 'store'])->name('store');
});

Route::prefix('kategori-instrumen')->as('kategori_instrumen.')->group(function () {
    Route::get('/', [InstrumentComponentController::class, 'index'])->name('index');
    Route::get('create/{type}', [InstrumentComponentController::class, 'create'])->name('create');
    Route::post('store', [InstrumentComponentController::class, 'store'])->name('store');
    Route::get('edit/{id}/{type}', [InstrumentComponentController::class, 'edit'])->name('edit');
    Route::post('update/{id}', [InstrumentComponentController::class, 'update'])->name('update');
    Route::delete('delete/{id}', [InstrumentComponentController::class, 'delete'])->name('delete');
    Route::get('filter', [InstrumentComponentController::class, 'filter'], 'filter')->name('filter');
    Route::get('/{id}/{type}', [InstrumentComponentController::class, 'show'])->name('show');
});

Route::group(['prefix' => 'instrumen', 'as' => 'instrumen.'], function () {
    Route::resource('aspects', InstrumentAspectController::class)->only([
        'store'
    ]);

    Route::prefix('aspects')->as('aspects.')->group(function () {
        Route::get('/index/{instrument}', [InstrumentAspectController::class, 'index'])->name('index');
        Route::get('/create/{instrument}', [InstrumentAspectController::class, 'create'])->name('create');
        Route::get('/edit/{instrument}/aspects/{aspect}', [InstrumentAspectController::class, 'edit'])->name('edit');
        Route::put('update/{aspect}', [InstrumentAspectController::class, 'update'])->name('update');
        Route::get('/show/{instrument}/aspects/{aspect}', [InstrumentAspectController::class, 'show'])->name('show');
        Route::delete('/destroy/{instrument}/aspects/{aspect}', [InstrumentAspectController::class, 'destroy'])
            ->name('destroy');
        Route::get('sub-components-aspects', [InstrumentAspectController::class, 'getSubComponentAspect'])
            ->name('sub_components_aspects');
        Route::post('add-fields', [InstrumentAspectController::class, 'addField'])->name('add_fields');
        Route::post('remove-field', [InstrumentAspectController::class, 'removeField'])->name('remove_field');
    });
});

Route::prefix('master-data')->as('master_data.')->group(function () {
    Route::get('/', [RegionController::class, 'index'])->name('index');
    Route::get('get-location', [RegionController::class, 'getLocation'])->name('get_location');
    Route::prefix('provinces')->as('provinces.')->group(function () {
        Route::get('index', [ProvinceController::class, 'index'])->name('index');
        Route::get('create', [ProvinceController::class, 'create'])->name('create');
        Route::post('store', [ProvinceController::class, 'store'])->name('store');
        Route::get('edit/{id}', [ProvinceController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [ProvinceController::class, 'update'])->name('update');
        Route::delete('delete/{id}', [ProvinceController::class, 'delete'])->name('delete');
        Route::get('/{id}', [ProvinceController::class, 'show'])->name('show');
    });

    Route::prefix('cities')->as('cities.')->group(function () {
        Route::get('index', [CityController::class, 'index'])->name('index');
        Route::get('create', [CityController::class, 'create'])->name('create');
        Route::post('store', [CityController::class, 'store'])->name('store');
        Route::get('{id}/edit', [CityController::class, 'edit'])->name('edit');
        Route::put('{id}/update', [CityController::class, 'update'])->name('update');
        Route::delete('delete/{id}', [CityController::class, 'destroy'])->name('delete');
        Route::get('/{id}', [CityController::class, 'show'])->name('show');
    });

    Route::prefix('subdistricts')->as('subdistricts.')->group(function () {
        Route::get('index', [SubdistrictController::class, 'index'])->name('index');
        Route::get('create', [SubdistrictController::class, 'create'])->name('create');
        Route::post('store', [SubdistrictController::class, 'store'])->name('store');
        Route::get('{id}/edit', [SubdistrictController::class, 'edit'])->name('edit');
        Route::put('{id}/update', [SubdistrictController::class, 'update'])->name('update');
        Route::delete('delete/{id}', [SubdistrictController::class, 'destroy'])->name('delete');
        Route::get('/{id}', [SubdistrictController::class, 'show'])->name('show');
    });

    Route::resource('regions', WilayahController::class);

    Route::prefix('villages')->as('villages.')->group(function () {
        Route::get('index', [VillageController::class, 'index'])->name('index');
        Route::get('create', [VillageController::class, 'create'])->name('create');
        Route::post('store', [VillageController::class, 'store'])->name('store');
        Route::get('{id}/edit', [VillageController::class, 'edit'])->name('edit');
        Route::put('{id}/update', [VillageController::class, 'update'])->name('update');
        Route::delete('delete/{id}', [VillageController::class, 'destroy'])->name('delete');
        Route::get('/{id}', [VillageController::class, 'show'])->name('show');
    });
});

Route::group(['prefix' => 'video', 'as' => 'video.'], function () {
    Route::get('/', [VideoController::class, 'index'])->name('index');
    Route::get('create', [VideoController::class, 'create'])->name('create');
    Route::post('store', [VideoController::class, 'store'])->name('store');
    Route::get('edit/{id}', [VideoController::class, 'edit'])->name('edit');
    Route::post('update/{id}', [VideoController::class, 'update'])->name('update');
    Route::delete('delete/{id}', [VideoController::class, 'destroy'])->name('delete');
    Route::get('/{id}', [VideoController::class, 'show'])->name('show');
});

Route::resource('berita', NewsController::class);

Route::resource('banner', BannerController::class);

Route::resource('galeri', GalleryController::class);

Route::resource('testimoni', TestimonyController::class);

Route::resource('email-template', EmailTemplateController::class);

Route::resource('faq', FaqController::class);

Route::resource('akreditasi', AccreditationController::class)->only('index', 'store', 'create', 'show', 'edit');
Route::get('results/{id}', [AccreditationController::class, 'results'])->name('akreditasi.results');
Route::post('finalize/{id}', [AccreditationController::class, 'finalize'])->name('akreditasi.finalize');
Route::prefix('akreditasi')->as('akreditasi.')->group(function () {
    Route::get('verifikasi/{id}', [AccreditationController::class, 'verify'])->name('verify');
    Route::post('verifikasi/{id}', [AccreditationController::class, 'postVerify'])->name('verify.post');
    Route::get('proses/{id}', [AccreditationController::class, 'process'])->name('process');
    Route::post('proses/{id}', [AccreditationController::class, 'postProcess'])->name('process.post');
    Route::get('file-download/{id}', [AccreditationController::class, 'downloadFile'])->name('file_download');
    Route::get('accept/{id}', [AccreditationController::class, 'accept'])->name('accept');
    Route::get('accept/{id}/process', [AccreditationController::class, 'acceptProcess'])->name('accept.process');
});

Route::prefix('self-assessment')->as('self-assessment.')->group(function () {
    Route::get('/', [SelfAssessmentController::class, 'create'])->name('create');
    Route::post('/', [SelfAssessmentController::class, 'store'])->name('store');
    Route::post('self-assessment/finalize/{id}', [SelfAssessmentController::class, 'finalize'])->name('finalize');
});

Route::resource('instrumen', InstrumentController::class)->only([
    'index', 'show', 'create', 'destroy', 'update', 'edit'
]);

Route::resource('penilaian', EvaluationController::class)->only('index', 'show');
Route::prefix('penilaian')->as('penilaian.')->group(function () {
    Route::get('evaluate/{penilaian}', [EvaluationController::class, 'evaluate'])->name('evaluate');
    Route::post('save/{id}', [EvaluationController::class, 'save'])->name('save');
    Route::get('result/{id}', [EvaluationController::class, 'results'])->name('results');
    Route::post('result/{id}/finalize', [EvaluationController::class, 'finalize'])->name('finalize');
    Route::get('rekap/{id}', [EvaluationController::class, 'recap'])->name('recap');
    Route::post('rekap/{id}/upload', [EvaluationController::class, 'uploadDocument'])->name('upload');
    Route::get('file-download/{id}', [EvaluationController::class, 'downloadFile'])->name('file_download');
    Route::get('show-institution/{id}', [EvaluationController::class, 'showInstitution'])->name('show_institution');
});

Route::prefix('sertifikasi')->as('sertifikasi.')->group(function () {
    Route::get('/', [CertificationController::class, 'index'])->name('index');
    Route::get('/{sertifikasi}', [CertificationController::class, 'edit'])->name('edit');
    Route::post('update/{sertifikasi}', [CertificationController::class, 'update'])->name('update');
});

Route::prefix('notification')->as('notification.')->group(function () {
    Route::get('/', [NotificationController::class, 'index'])->name('index');
    Route::get('/{id}', [NotificationController::class, 'show'])->name('show');
    Route::get('/update/status/{id}', [NotificationController::class, 'update'])->name('update');
});

Route::resource('file-download', FileDownloadController::class);

Route::prefix('log')->as('log.')->group(function () {
    Route::get('/', [LogController::class, 'index'])->name('index');
    Route::get('/{id}', [LogController::class, 'show'])->name('show');
});

Route::prefix('content-website')->name('content-website.')->group(function () {
    Route::resource('public-menu', PublicMenuController::class);
    Route::resource('page', PageController::class);
    Route::get('page/slug-availability/{slug}', [PageController::class, 'checkSlugAvailability'])->name('page.slug_availability');
    Route::get('/', function () {
        return redirect()->route('admin.content-website.public-menu.index');
    });
});

Route::resource('report', ReportController::class)->only('index');
Route::prefix('report')->as('report.')->group(function () {
    Route::get('total', [ReportController::class, 'totalReport'])->name('total');
    // Library Type
    Route::prefix('library-type')->as('library_type.')->group(function () {
        // In Year
        Route::prefix('in-year')->as('in_year.')->group(function () {
            Route::get('/', [ReportController::class, 'reportLibraryTypeInYear'])->name('index');
            Route::get('detail-type-year', [ReportController::class, 'showDetailPerType'])->name('detail_type_year');
        });

        Route::get('by-year', [ReportController::class, 'reportByTypeByYear'])->name('by_year');
        Route::get('latest', [ReportController::class, 'reportLibraryTypeLatest'])->name('latest');

        // Terkakreditas
        Route::prefix('terakreditasi-in-year')->as('terakreditasi_in_year.')->group(function () {
            Route::get('/', [ReportController::class, 'reportLibraryTerakreditasiInYear'])->name('index');
            Route::get('show', [ReportController::class, 'reportLibraryTerakreditasiInYearDetail'])->name('show');
            Route::get('by-year', [ReportController::class, 'reportTerakreditasiByLibraryTypePerYear'])->name('by_year');
        });
    });
    // Provinsi
    Route::prefix('province')->as('province.')->group(function () {
        Route::get('/', [ReportController::class, 'provinceByYear'])->name('index');

        // In Year
        Route::get('in-year', [ReportController::class, 'reportByProvinceInYear'])->name('in_year');

        // Terakreditasi
        Route::prefix('terakreditasi')->as('terakreditasi.')->group(function () {
            Route::get('/', [ReportController::class, 'reportTerakreditasiByProvinceInYear'])->name('index');
            Route::get('show', [ReportController::class, 'reportDetailTerakreditasiByProvinceInYear'])->name('show');
            Route::get('by-year', [ReportController::class, 'reportTerakreditasiByProvinsiPerYear'])->name('by_year');
        });
    });
});
