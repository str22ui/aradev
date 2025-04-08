<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ManagementController;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Penawaran;
use App\Models\Survey;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::middleware(['auth'])->group(function () {
    // Logout route
    Route::post('/logout',  [AuthController::class, 'logout']);
    Route::get('/dashboard', [AdminController::class, 'indexAdmin'])->name('admin.index');

    //Secondary
    Route::get('/secondary-home', [AdminController::class, 'indexSecondary'])->name('admin.secondary-home');
    Route::get('/showSecondary', [AdminController::class, 'showSecondary'])->name('admin.showSecondary');
    Route::get('/createSecondary', [AdminController::class, 'createSecondary'])->name('admin.createSecondary');
    Route::post('/storeSecondary', [adminController::class, 'storeSecondary'])->name('admin.storeSecondary');
    Route::get('/secondary/{id}/', [AdminController::class, 'editSecondary'])->name('admin.editSecondary');
    Route::delete('/deleteSecondary', [AdminController::class, 'destroySecondary'])->name('admin.deleteSecondary');
    Route::post('/admin/secondary/remove-image', [PerumahanController::class, 'removeImageSecondary'])->name('secondary.removeImageSecondary');
    Route::put('/secondary/update/{id}', [AdminController::class, 'updateSecondary'])->name('admin.updateSecondary');
    Route::delete('/deleteSecondaryImage', [AdminController::class, 'destroyImageSecondary'])->name('admin.deleteImageSecondary');

    //Land
    Route::get('/land-home', [AdminController::class, 'indexLand'])->name('admin.land');
    Route::get('/showLand', [AdminController::class, 'showLand'])->name('admin.showLand');
    Route::get('/createLand', [AdminController::class, 'createLand'])->name('admin.createLand');
    Route::post('/storeLan', [adminController::class, 'storeLand'])->name('admin.storeLand');
    Route::get('/land/{id}/', [AdminController::class, 'editLand'])->name('admin.editLand');
    Route::delete('/deleteLand', [AdminController::class, 'destroyLand'])->name('admin.deleteLand');
    Route::post('/admin/land/remove-image', [PerumahanController::class, 'removeImageLand'])->name('land.removeImageLand');
    Route::put('/land/update/{id}', [AdminController::class, 'updateLand'])->name('admin.updateLand');
    Route::delete('/deleteLandImage', [AdminController::class, 'destroyImageLand'])->name('admin.deleteImageLand');

    //Rumah
    Route::get('/rumah', [AdminController::class, 'indexRumah'])->name('admin.rumah');
    Route::get('/showRumah', [AdminController::class, 'showRumah'])->name('admin.showRumah');
    Route::get('/createRumah', [AdminController::class, 'createRumah'])->name('admin.createRumah');
    Route::post('/storeRumah', [adminController::class, 'storeRumah'])->name('admin.storeRumah');
    Route::get('/rumah/{id}/', [AdminController::class, 'editRumah'])->name('admin.editRumah');
    Route::put('/rumah/update/{id}', [AdminController::class, 'updateRumah'])->name('admin.updateRumah');
    Route::delete('/deleteRumah', [AdminController::class, 'destroyRumah'])->name('admin.deleteRumah');

    //Konsumen
    Route::get('/konsumen', [AdminController::class, 'indexKonsumen'])->name('admin.konsumen');
    Route::get('/createKonsumen', [AdminController::class, 'createKonsumen'])->name('admin.createKonsumen');
    Route::post('/storeKonsumen', [adminController::class, 'storeKonsumen'])->name('admin.storeKonsumen');
    Route::get('/konsumen/{id}/', [AdminController::class, 'editKonsumen'])->name('admin.editKonsumen');
    Route::put('/konsumen/update/{id}', [AdminController::class, 'updateKonsumen'])->name('admin.updateKonsumen');
    Route::delete('/deleteKonsumen', [AdminController::class, 'destroyKonsumen'])->name('admin.deleteKonsumen');

    //Survey
    Route::get('/survey', [AdminController::class, 'indexSurvey'])->name('admin.survey');
    Route::get('/createSurvey', [AdminController::class, 'createSurvey'])->name('admin.createSurvey');
    Route::post('/storeSurvey', [adminController::class, 'storeSurvey'])->name('admin.storeSurvey');
    Route::get('/survey/{id}/', [AdminController::class, 'editSurvey'])->name('admin.editSurvey');
    Route::put('/survey/update/{id}', [AdminController::class, 'updateSurvey'])->name('admin.updateSurvey');
    Route::delete('/deleteSurvey', [AdminController::class, 'destroySurvey'])->name('admin.deleteSurvey');
    Route::get('/survey/pdf/{id}', function ($id) {
        $survey = Survey::with(['rumah', 'perumahan','agent'])->findOrFail($id);

        $pdf = Pdf::loadView('admin.survey.pdfSurvey', compact('survey'));
        return $pdf->download('Konsumen_Survey.pdf'); // Unduh file
        // return $pdf->stream(); // Tampilkan di browser
    });

    //Agent
    Route::get('/agent', [AdminController::class, 'indexAgent'])->name('admin.agent');
    Route::get('/showAgent', [AdminController::class, 'showAgent'])->name('admin.showAgent');
    Route::get('/createAgent', [AdminController::class, 'createAgent'])->name('admin.createAgent');
    Route::post('/storeAgent', [adminController::class, 'storeAgent'])->name('admin.storeAgent');
    Route::get('/agent/{id}/', [AdminController::class, 'editAgent'])->name('admin.editAgent');
    Route::put('/agent/update/{id}', [AdminController::class, 'updateAgent'])->name('admin.updateAgent');
    Route::delete('/deleteAgent', [AdminController::class, 'destroyAgent'])->name('admin.deleteAgent');


    //Reseller
    Route::get('/reseller', [AdminController::class, 'indexReseller'])->name('admin.reseller');
    Route::get('/showReseller', [AdminController::class, 'showReseller'])->name('admin.showReseller');
    Route::get('/createReseller', [AdminController::class, 'createReseller'])->name('admin.createReseller');
    Route::post('/storeReseller', [adminController::class, 'storeReseller'])->name('admin.storeReseller');
    Route::get('/reseller/{id}/', [AdminController::class, 'editReseller'])->name('admin.editReseller');
    Route::put('/reseller/update/{id}', [AdminController::class, 'updateReseller'])->name('admin.updateReseller');
    Route::delete('/deleteReseller', [AdminController::class, 'destroyReseller'])->name('admin.deleteReseller');

    //Info
    Route::get('/info-home', [AdminController::class, 'indexInfo'])->name('admin.info');
    Route::get('/showInfo', [AdminController::class, 'showInfo'])->name('admin.showInfo');
    Route::get('/createInfo', [AdminController::class, 'createInfo'])->name('admin.createInfo');
    Route::post('/storeInfo', [adminController::class, 'storeInfo'])->name('admin.storeInfo');
    Route::get('/info-home/{id}/', [AdminController::class, 'editInfo'])->name('admin.editInfo');
    Route::delete('/deleteInfo', [AdminController::class, 'destroyInfo'])->name('admin.deleteInfo');
    Route::put('/info/update/{id}', [AdminController::class, 'updateInfo'])->name('admin.updateInfo');
    Route::delete('/deleteInfoImage', [AdminController::class, 'destroyImageInfo'])->name('admin.deleteImageInfo');

    //Services
    Route::get('/service-home', [AdminController::class, 'indexService'])->name('admin.service');
    Route::get('/showServices', [AdminController::class, 'showService'])->name('admin.showService');
    Route::get('/createService', [AdminController::class, 'createService'])->name('admin.createService');
    Route::post('/storeService', [adminController::class, 'storeService'])->name('admin.storeService');
    Route::get('/service-home/{id}/', [AdminController::class, 'editService'])->name('admin.editService');
    Route::delete('/deleteService', [AdminController::class, 'destroyService'])->name('admin.deleteService');
    Route::put('/service/update/{id}', [AdminController::class, 'updateService'])->name('admin.updateService');
    Route::delete('/deleteServiceImage', [AdminController::class, 'destroyImageService'])->name('admin.deleteImageService');

    //Testimony
    Route::get('/testimony-home', [AdminController::class, 'indexTestimony'])->name('admin.testimony');
    Route::get('/showTestimony', [AdminController::class, 'showTestimony'])->name('admin.showTestimony');
    Route::get('/createTestimony', [AdminController::class, 'createTestimony'])->name('admin.createTestimony');
    Route::post('/storeTestimony', [adminController::class, 'storeTestimony'])->name('admin.storeTestimony');
    Route::get('/testimony/{id}/', [AdminController::class, 'editTestimony'])->name('admin.editTestimony');
    Route::delete('/deleteTestimony', [AdminController::class, 'destroyTestimony'])->name('admin.deleteTestimony');
    Route::put('/testimony/update/{id}', [AdminController::class, 'updateTestimony'])->name('admin.updateTestimony');
    Route::delete('/deleteTestimonyImage', [AdminController::class, 'destroyImageTestimony'])->name('admin.deleteImageTestimony');


    //Penawaran
    Route::get('/penawaran', [AdminController::class, 'indexPenawaran'])->name('admin.penawaran');
    Route::get('/createPenawaran', [AdminController::class, 'createPenawaran'])->name('admin.createPenawaran');
    Route::post('/storePenawaran', [adminController::class, 'storePenawaran'])->name('admin.storePenawaran');
    Route::get('/penawaran/{id}/', [AdminController::class, 'editPenawaran'])->name('admin.editPenawaran');
    Route::put('/penawaran/update/{id}', [AdminController::class, 'updatePenawaran'])->name('admin.updatePenawaran');
    Route::delete('/deletePenawaran', [AdminController::class, 'destroyPenawaran'])->name('admin.deletePenawaran');
    Route::get('/penawaran/pdf/{id}', function ($id) {
        $penawaran = Penawaran::with(['rumah', 'perumahan'])->findOrFail($id);

        $pdf = Pdf::loadView('admin.penawaran.pdfPenawaran', compact('penawaran'));
        return $pdf->download('Surat_Penawaran.pdf'); // Unduh file
        // return $pdf->stream(); // Tampilkan di browser
    });

    //Report
    Route::get('/report', [AdminController::class, 'indexReport'])->name('admin.report');
    Route::get('/showReport', [AdminController::class, 'createReport'])->name('admin.createReport');
    Route::get('/createReport', [adminController::class, 'createReport'])->name('admin.createReport');
    Route::post('/storeReport', [adminController::class, 'storeReport'])->name('admin.storeReport');
    Route::get('/reportKonsumen/{id}', [AdminController::class, 'getKonsumen']);
    Route::get('/report/{id}/', [AdminController::class, 'editReport'])->name('admin.editReport');
    Route::put('/report/update/{id}', [AdminController::class, 'updateReport'])->name('admin.updateReport');
    Route::post('/addReports/{id}', [AdminController::class, 'addReports']);
    Route::post('/reports/add/{id}', [AdminController::class, 'addedReports'])->name('admin.addReport');
    Route::delete('/deleteReport', [AdminController::class, 'destroyReport'])->name('admin.deleteReport');

     //wishlist
    Route::get('/admin-wishlist', [AdminController::class, 'indexWishlist'])->name('admin.wishlist');
    Route::get('/showAgent', [AdminController::class, 'showAgent'])->name('admin.showAgent');
    Route::get('/createWishlist', [AdminController::class, 'createWishlist'])->name('admin.createWishlist');
    Route::post('/storeWishlist', [adminController::class, 'storeWishlist'])->name('admin.storeWishlist');
    Route::get('/wishlist/{id}/', [AdminController::class, 'editWishlist'])->name('admin.editWishlist');
    Route::put('/wishlist/update/{id}', [AdminController::class, 'updateWishlist'])->name('admin.updateWishlist');
    Route::delete('/deleteWishlist', [AdminController::class, 'destroyWishlist'])->name('admin.deleteWishlist');

    // Export Excel
    Route::post('/exportData', [AdminController::class, 'exportToExcel']);
    Route::post('/exportReport', [AdminController::class, 'exportReport']);
    Route::get('report/export/excel', [AdminController::class, 'exportReport'])->name('report.export.excel');
    Route::post('/exportKonsumen', [AdminController::class, 'exportKonsumen']);
    Route::get('konsumen/export/excel', [AdminController::class, 'exportKonsumen'])->name('konsumen.export.excel');
    Route::post('/exportSurvey', [AdminController::class, 'exportSurvey']);
    Route::get('survey/export/excel', [AdminController::class, 'exportSurvey'])->name('survey.export.excel');
    Route::post('/exportPenawaran', [AdminController::class, 'exportPenawaran']);
    Route::get('penawaran/export/excel', [AdminController::class, 'exportPenawaran'])->name('penawaran.export.excel');
    Route::post('/exportAgent', [AdminController::class, 'exportAgent']);
    Route::get('agent/export/excel', [AdminController::class, 'exportAgent'])->name('agent.export.excel');
    Route::post('/exportReseller', [AdminController::class, 'exportReseller']);
    Route::get('reseller/export/excel', [AdminController::class, 'exportReseller'])->name('reseller.export.excel');

    Route::group(['middleware' => ['auth', 'checkRole:admin']], function () {
        //Perumahan
        Route::get('/perumahan', [AdminController::class, 'indexPerumahan'])->name('admin.perumahan');
        Route::get('/showPerumahan', [AdminController::class, 'showPerumahan'])->name('admin.showPerumahan');
        Route::get('/createPerumahan', [AdminController::class, 'createPerumahan'])->name('admin.createPerumahan');
        Route::post('/storePerumahan', [adminController::class, 'storePerumahan'])->name('admin.storePerumahan');
        Route::get('/perumahan/{id}/', [AdminController::class, 'editPerumahan'])->name('admin.editPerumahan');
        Route::delete('/deletePerumahan', [AdminController::class, 'destroyPerumahan'])->name('admin.deletePerumahan');
        Route::post('/admin/perumahan/remove-image', [PerumahanController::class, 'removeImage'])->name('perumahan.removeImage');
        Route::put('/perumahan/update/{id}', [AdminController::class, 'updatePerumahan'])->name('admin.updatePerumahan');
        Route::delete('/deletePerumahanImage', [AdminController::class, 'destroyImage'])->name('admin.deleteImage');

        //User
        Route::get('/user-home', [AdminController::class, 'indexUser'])->name('admin.user');
        Route::get('/createUser', [AdminController::class, 'createUser'])->name('admin.createUser');
        Route::post('/storeUser', [adminController::class, 'storeUser'])->name('admin.storeUser');
        Route::get('/user-home/{id}/', [AdminController::class, 'editUser'])->name('admin.editUser');
        Route::delete('/deleteUser', [AdminController::class, 'destroyUser'])->name('admin.deleteUser');
        Route::put('/user/update/{id}', [AdminController::class, 'updateUser'])->name('admin.updateUser');
    });

});
// Route::prefix('/admin')->middleware(['auth', 'verified', 'admin'])->group(function(){
    // Route::get('/dashboard', [AdminController::class, 'indexAdmin'])->name('admin.index');


//     Route::get('/checkSlugArticle', [AdminController::class, 'checkSlugArticle']);
//     Route::get('/checkSlugName', [AdminController::class, 'checkSlugName']);
//     Route::get('/checkSlugTitle', [AdminController::class, 'checkSlugTitle']);
// });

Route::get('/loginUser', [AuthController::class, 'login'])->name('login')->middleware('guest');
Route::post('/loginUser', [AuthController::class, 'authenticate']);

// require __DIR__.'/auth.php';

Route::middleware('log.visits')->group(function(){
    Route::get('/', [LandingController::class, 'index'])->name('dashboard');
    Route::get('/perumahan/{kota}', [LandingController::class, 'getPerumahanByKota']);
    Route::get('/perumahan/filter', [PerumahanController::class, 'filterPerumahan']);

    Route::get('/about', [LandingController::class, 'about'])->name('about');

    Route::get('/secondary', [LandingController::class, 'indexSecondary'])->name('index.secondary');
    // Route::get('/showSecondary/{id}', [LandingController::class, 'showSecondary'])->name('showSecondary');
    Route::get('/showSecondary/{id}', [LandingController::class, 'showSecondary'])->name('showSecondary');
    Route::get('/kotaSecondary/{kota}', [LandingController::class, 'kotaSecondary'])->name('kotaSecondary');

    Route::get('/land', [LandingController::class, 'indexLand'])->name('index.land');
    Route::get('/showLand/{id}', [LandingController::class, 'showLand'])->name('showLand');
    Route::get('/kotaLand/{kota}', [LandingController::class, 'kotaLand'])->name('kotaLand');

    Route::get('/services', [LandingController::class, 'services'])->name('services');
    Route::get('/showService/{id}', [LandingController::class, 'showService'])->name('showService');

    Route::get('/testimony', [LandingController::class, 'indexTestimony'])->name('index.testimony');

    Route::get('/info', [LandingController::class, 'indexInfo'])->name('index.info');
    Route::get('/info/{id}', [LandingController::class, 'showInfo'])->name('info.show');


    Route::get('/contact', [LandingController::class, 'contact'])->name('contact');
    Route::get('/showProject/{kota}', [LandingController::class, 'showProject'])->name('showProject');

    Route::get('/form/{id}', [LandingController::class, 'form'])->name('landingpage.form');
    Route::get('/form-download/{id}', [LandingController::class, 'download'])->name('download.form');
    Route::post('/form-create/{id}', [LandingController::class, 'storeKonsumen'])->name('form.konsumen');

    Route::get('/formPenawaran/{id}', [LandingController::class, 'formPenawaran'])->name('landingpage.formPenawaran');
    Route::post('/storePenawaran', [LandingController::class, 'storePenawaranKonsumen'])->name('form.penawaran');

    Route::get('/wishlist', [LandingController::class, 'wishlist'])->name('wishlist');
    Route::get('/formWishlist', [LandingController::class, 'formWishlist'])->name('landingpage.formWishlist');
    Route::post('/storeWishlist', [LandingController::class, 'storeWishlist'])->name('form.wishlist');


    Route::get('/formSurvey/{id}', [LandingController::class, 'formSurvey'])->name('landingpage.formSurvey');
    Route::post('/survey/store/{id}', [LandingController::class, 'storeSurvey'])->name('form.survey');
    //
    Route::get('/showPerumahan/{id}', [LandingController::class, 'showPerumahan'])->name('landingpage.showPerumahan');

    Route::get('/download-brosur/{id}', [LandingController::class, 'downloadBrosur'])->name('download.brosur');
    Route::get('/download-pricelist/{id}', [LandingController::class, 'downloadPricelist'])->name('download.pricelist');

    // Route::get('/checkSlug', [MessageController::class, 'checkSlug']);


    Route::get('/pages/{page}', [LandingController::class, 'show']);
    Route::get('/download/{slug}', [EbookController::class, 'download'])->name('download');


});
