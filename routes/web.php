<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminSalesController;
use App\Http\Controllers\AdminPerumahanController;
use App\Http\Controllers\AdminSecondaryController;
use App\Http\Controllers\AdminLandController;
use App\Http\Controllers\AdminRumahController;
use App\Http\Controllers\AdminKonsumenController;
use App\Http\Controllers\AdminSurveyController;
use App\Http\Controllers\AdminPenawaranController;
use App\Http\Controllers\AdminAgentController;
use App\Http\Controllers\AdminResellerController;
use App\Http\Controllers\AdminWishlistController;
use App\Http\Controllers\AdminReportController;
use App\Http\Controllers\AdminInfoController;
use App\Http\Controllers\AdminTestimonyController;
use App\Http\Controllers\AdminServiceController;
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
    Route::get('/secondary-home', [AdminSecondaryController::class, 'indexSecondary'])->name('admin.secondary-home');
    Route::get('/showSecondary', [AdminSecondaryController::class, 'showSecondary'])->name('admin.showSecondary');
    Route::get('/createSecondary', [AdminSecondaryController::class, 'createSecondary'])->name('admin.createSecondary');
    Route::post('/storeSecondary', [AdminSecondaryController::class, 'storeSecondary'])->name('admin.storeSecondary');
    Route::get('/secondary/{id}/', [AdminSecondaryController::class, 'editSecondary'])->name('admin.editSecondary');
    Route::delete('/deleteSecondary', [AdminSecondaryController::class, 'destroySecondary'])->name('admin.deleteSecondary');
    Route::post('/admin/secondary/remove-image', [AdminSecondaryController::class, 'removeImageSecondary'])->name('secondary.removeImageSecondary');
    Route::put('/secondary/update/{id}', [AdminSecondaryController::class, 'updateSecondary'])->name('admin.updateSecondary');
    Route::delete('/deleteSecondaryImage', [AdminSecondaryController::class, 'destroyImageSecondary'])->name('admin.deleteImageSecondary');



    //Land
    Route::get('/land-home', [AdminLandController::class, 'indexLand'])->name('admin.land');
    Route::get('/showLand', [AdminLandController::class, 'showLand'])->name('admin.showLand');
    Route::get('/createLand', [AdminLandController::class, 'createLand'])->name('admin.createLand');
    Route::post('/storeLan', [AdminLandController::class, 'storeLand'])->name('admin.storeLand');
    Route::get('/land/{id}/', [AdminLandController::class, 'editLand'])->name('admin.editLand');
    Route::delete('/deleteLand', [AdminLandController::class, 'destroyLand'])->name('admin.deleteLand');
    Route::post('/admin/land/remove-image', [AdminLandController::class, 'removeImageLand'])->name('land.removeImageLand');
    Route::put('/land/update/{id}', [AdminLandController::class, 'updateLand'])->name('admin.updateLand');
    Route::delete('/deleteLandImage', [AdminLandController::class, 'destroyImageLand'])->name('admin.deleteImageLand');

    //Rumah
    Route::get('/rumah', [AdminRumahController::class, 'indexRumah'])->name('admin.rumah');
    Route::get('/showRumah', [AdminRumahController::class, 'showRumah'])->name('admin.showRumah');
    Route::get('/createRumah', [AdminRumahController::class, 'createRumah'])->name('admin.createRumah');
    Route::post('/storeRumah', [AdminRumahController::class, 'storeRumah'])->name('admin.storeRumah');
    Route::get('/rumah/{id}/', [AdminRumahController::class, 'editRumah'])->name('admin.editRumah');
    Route::put('/rumah/update/{id}', [AdminRumahController::class, 'updateRumah'])->name('admin.updateRumah');
    Route::delete('/deleteRumah', [AdminRumahController::class, 'destroyRumah'])->name('admin.deleteRumah');

    //Konsumen
    Route::get('/konsumen', [AdminKonsumenController::class, 'indexKonsumen'])->name('admin.konsumen');
    Route::get('/createKonsumen', [AdminKonsumenController::class, 'createKonsumen'])->name('admin.createKonsumen');
    Route::post('/storeKonsumen', [AdminKonsumenController::class, 'storeKonsumen'])->name('admin.storeKonsumen');
    Route::get('/konsumen/{id}/', [AdminKonsumenController::class, 'editKonsumen'])->name('admin.editKonsumen');
    Route::put('/konsumen/update/{id}', [AdminKonsumenController::class, 'updateKonsumen'])->name('admin.updateKonsumen');
    Route::delete('/deleteKonsumen', [AdminKonsumenController::class, 'destroyKonsumen'])->name('admin.deleteKonsumen');

    //Survey
    Route::get('/survey', [AdminSurveyController::class, 'indexSurvey'])->name('admin.survey');
    Route::get('/createSurvey', [AdminSurveyController::class, 'createSurvey'])->name('admin.createSurvey');
    Route::post('/storeSurvey', [AdminSurveyController::class, 'storeSurvey'])->name('admin.storeSurvey');
    Route::get('/survey/{id}/', [AdminSurveyController::class, 'editSurvey'])->name('admin.editSurvey');
    Route::put('/survey/update/{id}', [AdminSurveyController::class, 'updateSurvey'])->name('admin.updateSurvey');
    Route::delete('/deleteSurvey', [AdminSurveyController::class, 'destroySurvey'])->name('admin.deleteSurvey');
    Route::get('/survey/pdf/{id}', function ($id) {
        $survey = Survey::with(['rumah', 'perumahan','agent'])->findOrFail($id);

        $pdf = Pdf::loadView('admin.survey.pdfSurvey', compact('survey'));
        return $pdf->download('Konsumen_Survey.pdf'); // Unduh file
        // return $pdf->stream(); // Tampilkan di browser
    });

    //Reseller
    Route::get('/reseller', [AdminResellerController::class, 'indexReseller'])->name('admin.reseller');
    Route::get('/showReseller', [AdminResellerController::class, 'showReseller'])->name('admin.showReseller');
    Route::get('/createReseller', [AdminResellerController::class, 'createReseller'])->name('admin.createReseller');
    Route::post('/storeReseller', [adminController::class, 'storeReseller'])->name('admin.storeReseller');
    Route::get('/reseller/{id}/', [AdminResellerController::class, 'editReseller'])->name('admin.editReseller');
    Route::put('/reseller/update/{id}', [AdminResellerController::class, 'updateReseller'])->name('admin.updateReseller');
    Route::delete('/deleteReseller', [AdminResellerController::class, 'destroyReseller'])->name('admin.deleteReseller');

    //Info
    Route::get('/info-home', [AdminInfoController::class, 'indexInfo'])->name('admin.info');
    Route::get('/showInfo', [AdminInfoController::class, 'showInfo'])->name('admin.showInfo');
    Route::get('/createInfo', [AdminInfoController::class, 'createInfo'])->name('admin.createInfo');
    Route::post('/storeInfo', [AdminInfoController::class, 'storeInfo'])->name('admin.storeInfo');
    Route::get('/info-home/{id}/', [AdminInfoController::class, 'editInfo'])->name('admin.editInfo');
    Route::delete('/deleteInfo', [AdminInfoController::class, 'destroyInfo'])->name('admin.deleteInfo');
    Route::put('/info/update/{id}', [AdminInfoController::class, 'updateInfo'])->name('admin.updateInfo');
    Route::delete('/deleteInfoImage', [AdminInfoController::class, 'destroyImageInfo'])->name('admin.deleteImageInfo');

    //Services
    Route::get('/service-home', [AdminServiceController::class, 'indexService'])->name('admin.service');
    Route::get('/showServices', [AdminServiceController::class, 'showService'])->name('admin.showService');
    Route::get('/createService', [AdminServiceController::class, 'createService'])->name('admin.createService');
    Route::post('/storeService', [AdminServiceController::class, 'storeService'])->name('admin.storeService');
    Route::get('/service-home/{id}/', [AdminServiceController::class, 'editService'])->name('admin.editService');
    Route::delete('/deleteService', [AdminServiceController::class, 'destroyService'])->name('admin.deleteService');
    Route::put('/service/update/{id}', [AdminServiceController::class, 'updateService'])->name('admin.updateService');
    Route::delete('/deleteServiceImage', [AdminServiceController::class, 'destroyImageService'])->name('admin.deleteImageService');

    //Testimony
    Route::get('/testimony-home', [AdminTestimonyController::class, 'indexTestimony'])->name('admin.testimony');
    Route::get('/showTestimony', [AdminTestimonyController::class, 'showTestimony'])->name('admin.showTestimony');
    Route::get('/createTestimony', [AdminTestimonyController::class, 'createTestimony'])->name('admin.createTestimony');
    Route::post('/storeTestimony', [AdminTestimonyController::class, 'storeTestimony'])->name('admin.storeTestimony');
    Route::get('/testimony/{id}/', [AdminTestimonyController::class, 'editTestimony'])->name('admin.editTestimony');
    Route::delete('/deleteTestimony', [AdminTestimonyController::class, 'destroyTestimony'])->name('admin.deleteTestimony');
    Route::put('/testimony/update/{id}', [AdminTestimonyController::class, 'updateTestimony'])->name('admin.updateTestimony');
    Route::delete('/deleteTestimonyImage', [AdminTestimonyController::class, 'destroyImageTestimony'])->name('admin.deleteImageTestimony');


    //Penawaran
    Route::get('/penawaran', [AdminPenawaranController::class, 'indexPenawaran'])->name('admin.penawaran');
    Route::get('/createPenawaran', [AdminPenawaranController::class, 'createPenawaran'])->name('admin.createPenawaran');
    Route::post('/store-Penawaran', [AdminPenawaranController::class, 'storePenawaran'])->name('admin.storePenawaran');
    Route::get('/penawaran/{id}/', [AdminPenawaranController::class, 'editPenawaran'])->name('admin.editPenawaran');
    Route::put('/penawaran/update/{id}', [AdminPenawaranController::class, 'updatePenawaran'])->name('admin.updatePenawaran');
    Route::delete('/deletePenawaran', [AdminPenawaranController::class, 'destroyPenawaran'])->name('admin.deletePenawaran');
    Route::get('/penawaran/pdf/{id}', function ($id) {
        $penawaran = Penawaran::with(['rumah', 'perumahan'])->findOrFail($id);

        $pdf = Pdf::loadView('admin.penawaran.pdfPenawaran', compact('penawaran'));
        return $pdf->download('Surat_Penawaran.pdf'); // Unduh file
        // return $pdf->stream(); // Tampilkan di browser
    });

    //Report
    Route::get('/report', [AdminReportController::class, 'indexReport'])->name('admin.report');
    Route::get('/showReport', [AdminReportController::class, 'createReport'])->name('admin.createReport');
    Route::get('/createReport', [adminController::class, 'createReport'])->name('admin.createReport');
    Route::post('/storeReport', [adminController::class, 'storeReport'])->name('admin.storeReport');
    Route::get('/reportKonsumen/{id}', [AdminReportController::class, 'getKonsumen']);
    Route::get('/report/{id}/', [AdminReportController::class, 'editReport'])->name('admin.editReport');
    Route::put('/report/update/{id}', [AdminReportController::class, 'updateReport'])->name('admin.updateReport');
    Route::post('/addReports/{id}', [AdminReportController::class, 'addReports']);
    Route::post('/reports/add/{id}', [AdminReportController::class, 'addedReports'])->name('admin.addReport');
    Route::delete('/deleteReport', [AdminReportController::class, 'destroyReport'])->name('admin.deleteReport');

     //wishlist
    Route::get('/admin-wishlist', [AdminWishlistController::class, 'indexWishlist'])->name('admin.wishlist');
    Route::get('/showAgent', [AdminWishlistController::class, 'showAgent'])->name('admin.showAgent');
    Route::get('/createWishlist', [AdminWishlistController::class, 'createWishlist'])->name('admin.createWishlist');
    Route::post('/storeWishlistt', [AdminWishlistController::class, 'storeWishlistt'])->name('admin.storeWishlistt');
    Route::get('/wishlist/{id}/', [AdminWishlistController::class, 'editWishlist'])->name('admin.editWishlist');
    Route::put('/wishlist/update/{id}', [AdminWishlistController::class, 'updateWishlist'])->name('admin.updateWishlist');
    Route::delete('/deleteWishlist', [AdminWishlistController::class, 'destroyWishlist'])->name('admin.deleteWishlist');

     //Agent
    Route::get('/agent', [AdminAgentController::class, 'indexAgent'])->name('admin.agent');
    Route::get('/showAgent', [AdminAgentController::class, 'showAgent'])->name('admin.showAgent');
    Route::get('/createAgent', [AdminAgentController::class, 'createAgent'])->name('admin.createAgent');
    Route::post('/storeAgent', [adminController::class, 'storeAgent'])->name('admin.storeAgent');
    Route::get('/agent/{id}/', [AdminAgentController::class, 'editAgent'])->name('admin.editAgent');
    Route::put('/agent/update/{id}', [AdminAgentController::class, 'updateAgent'])->name('admin.updateAgent');
    Route::delete('/deleteAgent', [AdminAgentController::class, 'destroyAgent'])->name('admin.deleteAgent');


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

  //Perumahan
    Route::get('/perumahan', [AdminPerumahanController::class, 'indexPerumahan'])->name('admin.perumahan');
    Route::get('/showPerumahan', [AdminController::class, 'showPerumahan'])->name('admin.showPerumahan');

    Route::group(['middleware' => ['auth', 'checkRole:admin']], function () {

        Route::get('/createPerumahan', [AdminPerumahanController::class, 'createPerumahan'])->name('admin.createPerumahan');
        Route::post('/storePerumahan', [AdminPerumahanController::class, 'storePerumahan'])->name('admin.storePerumahan');
        Route::get('/perumahan/{id}/', [AdminPerumahanController::class, 'editPerumahan'])->name('admin.editPerumahan');
        Route::delete('/deletePerumahan', [AdminPerumahanController::class, 'destroyPerumahan'])->name('admin.deletePerumahan');
        Route::post('/admin/perumahan/remove-image', [AdminPerumahanController::class, 'removeImage'])->name('perumahan.removeImage');
        Route::put('/perumahan/update/{id}', [AdminPerumahanController::class, 'updatePerumahan'])->name('admin.updatePerumahan');
        Route::delete('/deletePerumahanImage', [AdminPerumahanController::class, 'destroyImage'])->name('admin.deleteImage');

        //User
        Route::get('/user-home', [AdminController::class, 'indexUser'])->name('admin.user');
        Route::get('/createUser', [AdminController::class, 'createUser'])->name('admin.createUser');
        Route::post('/storeUser', [adminController::class, 'storeUser'])->name('admin.storeUser');
        Route::get('/user-home/{id}/', [AdminController::class, 'editUser'])->name('admin.editUser');
        Route::delete('/deleteUser', [AdminController::class, 'destroyUser'])->name('admin.deleteUser');
        Route::put('/user/update/{id}', [AdminController::class, 'updateUser'])->name('admin.updateUser');

        //Sales
        Route::get('/sales-home', [AdminSalesController::class, 'indexSales'])->name('admin.sales');
        Route::get('/createSales', [AdminSalesController::class, 'createSales'])->name('admin.createSales');
        Route::post('/storeSales', [adminController::class, 'storeSales'])->name('admin.storeSales');
        Route::get('/sales-home/{id}/', [AdminSalesController::class, 'editSales'])->name('admin.editSales');
        Route::put('/sales/update/{id}', [AdminSalesController::class, 'updateSales'])->name('admin.updateSales');
        Route::delete('/deleteSales', [AdminSalesController::class, 'destroySales'])->name('admin.deleteSales');


        //updateuser
        Route::put('/admin/secondary/update-user/{id}', [AdminSecondaryController::class, 'updateUserIdSecondary'])->name('admin.updateUserIdSecondary');
        Route::put('/admin/land/update-user/{id}', [AdminLandController::class, 'updateUserIdLand'])->name('admin.updateUserIdLand');
        Route::put('/admin/konsumen/update-user/{id}', [AdminKonsumenController::class, 'updateUserIdKonsumen'])->name('admin.updateUserIdKonsumen');
        Route::put('/admin/penawaran/update-user/{id}', [AdminPenawaranController::class, 'updateUserIdPenawaran'])->name('admin.updateUserIdPenawaran');
        Route::put('/admin/survey/update-user/{id}', [AdminSurveyController::class, 'updateUserIdSurvey'])->name('admin.updateUserIdSurvey');
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
