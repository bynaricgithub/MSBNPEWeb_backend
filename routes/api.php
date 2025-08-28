<?php

use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\Circular\CircularController;
use App\Http\Controllers\Faq\FaqController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\FileUploads\FileUploadsController;
use App\Http\Controllers\Gallery\GalleryController;
use App\Http\Controllers\HomeMenu\HomeMenuController;
use App\Http\Controllers\InstituteController;
use App\Http\Controllers\LatestUpdate\LatestUpdateController;
use App\Http\Controllers\Masters\MasterCategoryController;
use App\Http\Controllers\Masters\MasterCategoryTypeController;
use App\Http\Controllers\MembersController;
use App\Http\Controllers\NoticeBoard\NoticeBoardController;
use App\Http\Controllers\PageContent\PageContentController;
use App\Http\Controllers\ProgramsController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SliderImages\SliderImagesController;
use App\Http\Controllers\VideoGalleryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// ?-----------only for the testing--------------------------------
// Route::get('/testing', function (Request $request) {
//     $password = 'admiin';
//     $hashedPassword = Hash::make($password);
//     echo $hashedPassword;
// });
// ?-------------------------------------------------------------------

Route::post('/login', [AuthenticationController::class, 'create'])->name('adminLogin');
// ?-------------if you want to do the registration for the admin----------------------------------------------------
Route::post('/registration', [AuthenticationController::class, 'registration'])->name('adminRegistration');

// //?-------------landing page apis----------------------------

Route::get('/homemenu/listing', [HomemenuController::class, 'fetchHomeMenu'])->name('homemenus.listing');
Route::get('/latest-update/listing', [LatestUpdateController::class, 'fetchLatestUpdate'])->name('latestUpdate.listing');
Route::get('/slider-images/listing', [SliderImagesController::class, 'fetchSliderImages'])->name('sliderImages.listing');
Route::get('/gallery/listing', [GalleryController::class, 'fetchGallery'])->name('GalleryControllers.listing');
Route::get('/notice-board/listing', [NoticeBoardController::class, 'NoticeBoardFetch'])->name('noticeBoard.listing');
Route::get('/programs/listing', [ProgramsController::class, 'fetchPrograms'])->name('programs.listing');
Route::get('/institute/listing', [InstituteController::class, 'fetchInstitute'])->name('institute.listing');
Route::get('/page-content/listing', [PageContentController::class, 'fetchPageContent'])->name('pageContent.listing');
Route::get('/members/listing', [MembersController::class, 'fetchMembers'])->name('members.listing');
Route::get('/faq/listing', [FaqController::class, 'fetchFaq'])->name('faq.listing');
Route::get('/master-categories/listing', [MasterCategoryController::class, 'groupedPublic'])->name('masterCategory.groupedPublic');

// ?---visitorCount-----
Route::post('/visitor', [HomemenuController::class, 'saveVisitorCount']);
Route::get('/visitor/count', [HomemenuController::class, 'getUserVisitCount']);
Route::get('/lastUpdateDate', [HomemenuController::class, 'getLastUpdateDate']);
Route::get('/circular/listing', [CircularController::class, 'index'])->name('circular.index');
Route::get('/video-gallery/listing', [VideoGalleryController::class, 'index'])->name('video-gallery.index');
Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
// ?----------------------------------------------------------

Route::post('/upload-chunk', [FileUploadController::class, 'uploadChunk']);

Route::get('/search', [SearchController::class, 'search']);

// ---------------------------------------------------------------------------------------------------------------------
// artical - articles - php artisan make:model article
// artical - articles - php artisan make:controller articleController

Route::middleware(['auth:api', 'check.token.expiry.admin'])->group(function () {

    Route::get('/feedback', [FeedbackController::class, 'index'])->name('feedback.index');

    // sort / table
    // ?---Reorder-----
    Route::post('/sort/table', [HomemenuController::class, 'sortTable'])->name('homeMenu.sortTable');
    Route::post('/reorder/up', [HomemenuController::class, 'reorderUp'])->name('homeMenu.reorderUp');
    Route::post('/reorder/down', [HomemenuController::class, 'reorderDown'])->name('homeMenu.reorderDown');
    Route::post('/reorder/menu', [HomemenuController::class, 'reorderMenu'])->name('homeMenu.reorderMenu');

    // ?---HomeMenu-----
    Route::get('/homemenu', [HomemenuController::class, 'index'])->name('homemenus.indexHomemenu');
    Route::post('/homemenu', [HomemenuController::class, 'store'])->name('homemenus.addHomemenu');
    Route::delete('/homemenu', [HomemenuController::class, 'destroy'])->name('homemenus.deleteHomemenu');
    Route::put('/homemenu', [HomemenuController::class, 'update'])->name('homemenus.updateHomemenu');
    Route::post('/homemenu/disable', [HomemenuController::class, 'disable'])->name('homemenus.disableHomemenu');

    // ?---latestUpdate-----
    Route::get('/admin/latest-update/listing', [LatestUpdateController::class, 'index'])->name('latesUpdate.index');
    Route::post('/latest-update/add', [LatestUpdateController::class, 'store'])->name('latesUpdate.add');
    Route::put('/latest-update/update', [LatestUpdateController::class, 'edit'])->name('latesUpdate.update');
    Route::put('/latest-update/disable', [LatestUpdateController::class, 'disable'])->name('latesUpdate.disable');
    Route::delete('/latest-update/delete', [LatestUpdateController::class, 'delete'])->name('latesUpdate.delete');
    Route::post('/latest-update/re-ordering', [LatestUpdateController::class, 'reOrdering'])->name('latesUpdate.reOrdering');

    // ?---Slider Images---
    Route::get('/admin/slider-images/listing', [SliderImagesController::class, 'index'])->name('sliderImages.index');
    Route::post('/slider-images/add', [SliderImagesController::class, 'store'])->name('sliderImages.add');
    Route::put('/slider-images/update', [SliderImagesController::class, 'edit'])->name('sliderImages.update');
    Route::post('/slider-images/disable', [SliderImagesController::class, 'disable'])->name('sliderImages.disable');
    Route::delete('/slider-images/delete', [SliderImagesController::class, 'delete'])->name('sliderImages.delete');
    Route::post('/slider-images/re-ordering', [SliderImagesController::class, 'reOrdering'])->name('sliderImages.reOrdering');
    // ---Notice Board---
    Route::get('/admin/notice-board/listing', [NoticeBoardController::class, 'index'])->name('noticeBoard.index');
    Route::post('/notice-board/add', [NoticeBoardController::class, 'store'])->name('noticeBoard.add');
    Route::put('/notice-board/update', [NoticeBoardController::class, 'edit'])->name('noticeBoard.update');
    Route::put('/notice-board/disable', [NoticeBoardController::class, 'disable'])->name('noticeBoard.disable');
    Route::delete('/notice-board/delete', [NoticeBoardController::class, 'delete'])->name('noticeBoard.delete');
    Route::post('/notice-board/re-ordering', [NoticeBoardController::class, 'reOrdering'])->name('noticeBoard.reOrdering');

    // ---Gallery---
    Route::get('/admin/gallery/listing', [GalleryController::class, 'index'])->name('gallery.index');
    Route::post('/gallery/add', [GalleryController::class, 'store'])->name('gallery.add');
    Route::put('/gallery/update', [GalleryController::class, 'edit'])->name('gallery.update');
    Route::put('/gallery/disable', [GalleryController::class, 'disable'])->name('gallery.disable');
    Route::delete('/gallery/delete', [GalleryController::class, 'delete'])->name('gallery.delete');

    // ---Members---
    Route::get('/admin/members/listing', [MembersController::class, 'index'])->name('members.index');
    Route::post('/members/add', [MembersController::class, 'store'])->name('members.add');
    Route::put('/members/update', [MembersController::class, 'edit'])->name('members.update');
    Route::put('/members/disable', [MembersController::class, 'disable'])->name('members.disable');
    Route::delete('/members/delete', [MembersController::class, 'delete'])->name('members.delete');

    // ---Video-Gallery---
    Route::post('/video-gallery/add', [VideoGalleryController::class, 'store'])->name('video-gallery.add');
    Route::put('/video-gallery/update', [VideoGalleryController::class, 'edit'])->name('video-gallery.update');
    Route::put('/video-gallery/disable', [VideoGalleryController::class, 'disable'])->name('video-gallery.disable');
    Route::delete('/video-gallery/delete', [VideoGalleryController::class, 'delete'])->name('video-gallery.delete');

    Route::get('whoAmI', [AuthenticationController::class, 'whoAmI'])->name('whoAmI');

    // ------Programs ------
    Route::get('/admin/programs/listing', [ProgramsController::class, 'index'])->name('programs.index');
    Route::post('/programs/add', [ProgramsController::class, 'store'])->name('programs.add');
    Route::put('/programs/update', [ProgramsController::class, 'edit'])->name('programs.update');
    Route::put('/programs/disable', [ProgramsController::class, 'disable'])->name('programs.disable');
    Route::delete('/programs/delete', [ProgramsController::class, 'delete'])->name('programs.delete');

    // ------Institute ------
    Route::get('/admin/institute/listing', [InstituteController::class, 'index'])->name('institute.index');
    Route::post('/institute/add', [InstituteController::class, 'store'])->name('institute.add');
    Route::put('/institute/update', [InstituteController::class, 'edit'])->name('institute.update');
    Route::put('/institute/disable', [InstituteController::class, 'disable'])->name('institute.disable');
    Route::delete('/institute/delete', [InstituteController::class, 'delete'])->name('institute.delete');

    // -------Circular------

    Route::get('/admin/circular/listing', [CircularController::class, 'indexAdmin'])->name('circular.indexAdmin');
    Route::post('/circular/add', [CircularController::class, 'store'])->name('circular.add');
    Route::put('/circular/update', [CircularController::class, 'edit'])->name('circular.update');
    Route::delete('/circular/delete', [CircularController::class, 'delete'])->name('circular.delete');
    Route::put('/circular/disable', [CircularController::class, 'disable'])->name('circular.disable');

    // -------File Uploads------

    Route::get('/admin/fileuploads/listing', [FileUploadsController::class, 'indexAdmin'])->name('fileuploads.indexAdmin');
    Route::post('/fileuploads/add', [FileUploadsController::class, 'store'])->name('fileuploads.add');
    Route::put('/fileuploads/update', [FileUploadsController::class, 'edit'])->name('fileuploads.update');
    Route::delete('/fileuploads/delete', [FileUploadsController::class, 'delete'])->name('fileuploads.delete');
    Route::put('/fileuploads/disable', [FileUploadsController::class, 'disable'])->name('fileuploads.disable');

    // ------------------------- Page Content --------------------------------------
    Route::get('/admin/page-content/listing', [PageContentController::class, 'indexAdmin'])->name('pageContent.indexAdmin');
    Route::post('/page-content/add', [PageContentController::class, 'store'])->name('pageContent.add');
    Route::put('/page-content/update', [PageContentController::class, 'edit'])->name('pageContent.update');
    Route::delete('/page-content/delete', [PageContentController::class, 'delete'])->name('pageContent.delete');
    Route::put('/page-content/disable', [PageContentController::class, 'disable'])->name('pageContent.disable');

    // ------------------------- FAQ Content --------------------------------------
    Route::get('/admin/faq/listing', [FaqController::class, 'indexAdmin'])->name('faq.indexAdmin');
    Route::post('/faq/add', [FaqController::class, 'store'])->name('faq.add');
    Route::put('/faq/update', [FaqController::class, 'edit'])->name('faq.update');
    Route::delete('/faq/delete', [FaqController::class, 'delete'])->name('faq.delete');
    Route::put('/faq/disable', [FaqController::class, 'disable'])->name('faq.disable');
    Route::post('/faq/re-ordering', [FaqController::class, 'reOrdering'])->name('faq.reOrdering');

    // -------------------- Master Category Types --------------------
    Route::get('/admin/master-category-type/listing', [MasterCategoryTypeController::class, 'index'])->name('masterCategoryType.index');
    Route::post('/master-category-type/add', [MasterCategoryTypeController::class, 'store'])->name('masterCategoryType.add');
    Route::put('/master-category-type/update', [MasterCategoryTypeController::class, 'update'])->name('masterCategoryType.update');
    Route::delete('/master-category-type/delete', [MasterCategoryTypeController::class, 'delete'])->name('masterCategoryType.delete');

    // -------------------- Master Categories (Sub-values) --------------------
    Route::get('/admin/master-category/listing', [MasterCategoryController::class, 'indexAdmin'])->name('masterCategory.indexAdmin');
    Route::post('/master-category/add', [MasterCategoryController::class, 'store'])->name('masterCategory.add');
    Route::put('/master-category/update', [MasterCategoryController::class, 'update'])->name('masterCategory.update');
    Route::delete('/master-category/delete', [MasterCategoryController::class, 'delete'])->name('masterCategory.delete');

    Route::get('/master-category/resolve-label', [MasterCategoryController::class, 'resolveLabel']);

    // -----------logout--------
    Route::post('logout', [AuthenticationController::class, 'logout'])->name('logout');

    // ?----------------this is testing part---------------------------------------------------------
    // Route::get('/testing', function (Request $request) {

    //     echo 'working...';
    // });
});

// Route::resource('authentication', AuthenticationController::class);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
