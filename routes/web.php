<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ChapterCardController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ManageRoleController;
use App\Http\Controllers\ManageUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OutlineController;
use App\Http\Controllers\PlotPlannerController;
use App\Http\Controllers\PremiseController;
use App\Http\Controllers\PackageOptionController;
use App\Http\Controllers\SeriesController;
use App\Http\Controllers\TimelineController;
use App\Http\Controllers\TimelineEventTypeController;
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

    Route::prefix('admin/users')->group(function () {
        Route::controller(ManageUserController::class)->group(function () {
            Route::get('/manage-users', 'manageUser')->name('manage.users');
            Route::get('/add-user', 'addUser')->name('user.add');
            Route::post('/add-user', 'addUserData')->name('user.add.data');
            Route::get('/update-user/{userId}', 'updateUser')->name('user.update');
            Route::post('/update-user/{userId}', 'updateUserData')->name('user.update.data');
            Route::get('/user-detail/{userId}', 'getUserDetail')->name('user.detail');
            Route::get('/change-user-status/{companyId}', 'changeUserStatus')->name('user.change.status');
            Route::get('/delete-user/{userId}', 'deleteUser')->name('user.delete');
            Route::get('/get-active-users', 'getActiveUsers')->name('active.users');
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
    Route::prefix('admin/Package_option')->group(function (){
       Route::controller(PackageOptionController::class)->group(function (){
          Route::get('/','index')->name('Package.option');
           Route::get('/add', 'addPackage')->name('Package.option.add');
           Route::post('/add', 'addPackageData')->name('Package.option.add.data');
           Route::get('/update/{id}', 'updatePackage')->name('Package.option.update');
           Route::post('/update/{id}', 'updatePackageData')->name('Package.option.update.data');
           Route::get('/package-option/detail/{id}', 'getPackageDetail')->name('Package.option.detail');
           Route::get('/package-option/delete/{id}', 'changePackageDelete')->name('Package.option.delete');
       });
    });
    Route::prefix('admin/coupon')->group(function (){
        Route::controller(\App\Http\Controllers\CouponController::class)->group(function (){
            Route::get('/','index')->name('coupon');
            Route::get('/add', 'addCoupon')->name('coupon.add');
            Route::post('/add', 'addCouponData')->name('coupon.add.data');
            Route::get('/update/{id}', 'updateCoupon')->name('coupon.update');
            Route::post('/update/{id}', 'updateCouponData')->name('coupon.update.data');
            Route::get('/coupon/detail/{id}', 'getCouponDetail')->name('coupon.detail');
            Route::get('/coupon/delete/{id}', 'couponDelete')->name('coupon.delete');
            Route::get('/coupon-status/{id}','changeCouponStatus')->name('coupon.status');
        });
    });
    Route::prefix('admin/package')->group(function (){
        Route::controller(\App\Http\Controllers\PackageController::class)->group(function (){
            Route::get('/','index')->name('package');
            Route::get('/add', 'addPackage')->name('package.add');
            Route::post('/add', 'addPackageData')->name('package.add.data');
            Route::get('/update/{id}', 'updatePackage')->name('package.update');
            Route::post('/update/{id}', 'updatePackageData')->name('package.update.data');
            Route::get('/package/detail/{id}', 'getPackageDetail')->name('package.detail');
            Route::get('/package/delete/{id}', 'PackageDelete')->name('package.delete');
            Route::get('/package-status/{id}','changePackageStatus')->name('package.status');
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
            Route::get('/change-image-status/{imageId}', 'changeImageStatus')->name('image.change.status');
            Route::get('/delete/{imageId}', 'deleteImage')->name('user.gallery.delete');
        });
    });

    Route::prefix('admin/colors')->group(function () {
        Route::controller(ColorController::class)->group(function () {
            Route::get('/', 'index')->name('manage.colors');
            Route::get('/add', 'addColor')->name('color.add');
            Route::post('/add', 'addColorData')->name('color.add.data');
            Route::get('/update/{colorId}', 'updateColor')->name('color.update');
            Route::post('/update/{colorId}', 'updateColorData')->name('color.update.data');
            Route::get('/color-detail/{colorId}', 'getColorDetail')->name('color.detail');
            Route::get('/change-color-status/{colorId}', 'changeColorStatus')->name('color.change.status');
            Route::get('/delete/{colorId}', 'deleteColor')->name('color.delete');
        });
    });

    Route::prefix('admin/calendars')->group(function () {
        Route::controller(CalendarController::class)->group(function () {
            Route::get('/', 'index')->name('manage.calendars');
            Route::get('/add', 'addCalendar')->name('calendar.add');
            Route::post('/add', 'addCalendarData')->name('calendar.add.data');
            Route::get('/update/{calendarId}', 'updateCalendar')->name('calendar.update');
            Route::post('/update/{calendarId}', 'updateCalendarData')->name('calendar.update.data');
            Route::get('/calendar-detail/{calendarId}', 'calendarDetail')->name('calendar.detail');
            Route::get('/delete/{calendarId}', 'deleteCalendar')->name('calendar.delete');
        });
    });

    Route::prefix('admin/series')->group(function () {
        Route::controller(SeriesController::class)->group(function () {
            Route::get('/', 'index')->name('manage.series');
            Route::get('/add', 'addSeries')->name('series.add');
            Route::post('/add', 'addSeriesData')->name('series.add.data');
            Route::get('/update/{seriesId}', 'updateSeries')->name('series.update');
            Route::post('/update/{seriesId}', 'updateSeriesData')->name('series.update.data');
            Route::get('/series-detail/{seriesId}', 'getSeriesDetail')->name('series.detail');
            Route::get('/change-series-status/{seriesId}', 'changeSeriesStatus')->name('series.change.status');
            Route::get('/delete/{seriesId}', 'deleteSeries')->name('series.delete');
            Route::get('/get-user-books', 'getUserBooks')->name('user.books');
        });
    });

    Route::prefix('admin/book')->group(function () {
        Route::controller(BookController::class)->group(function () {
            Route::get('/', 'index')->name('manage.books');
            Route::get('/add', 'addBook')->name('book.add');
            Route::post('/add', 'addBookData')->name('book.add.data');
            Route::get('/update/{bookId}', 'updateBook')->name('book.update');
            Route::post('/update/{bookId}', 'updateBookData')->name('book.update.data');
            Route::get('/book-detail/{bookId}', 'getBookDetail')->name('book.detail');
            Route::get('/change-book-status/{bookId}', 'changeBookStatus')->name('book.change.status');
            Route::get('/delete/{bookId}', 'deleteBook')->name('book.delete');
            Route::get('/get-user-series', 'getUserSeries')->name('user.series');
            Route::get('/get-book/by-series', 'getBookBySeries')->name('book.series');
        });
    });

    Route::prefix('admin/premises')->group(function () {
        Route::controller(PremiseController::class)->group(function () {
            Route::get('/', 'index')->name('manage.premises');
            Route::get('/add', 'addPremise')->name('premise.add');
            Route::post('/add', 'addPremiseData')->name('premise.add.data');
            Route::get('/update/{premiseId}', 'updatePremise')->name('premise.update');
            Route::post('/update/{premiseId}', 'updatePremiseData')->name('premise.update.data');
            Route::get('/premise-detail/{premiseId}', 'getPremiseDetail')->name('premise.detail');
            Route::get('/change-premise-status/{premiseId}', 'changePremiseStatus')->name('premise.change.status');
            Route::get('/delete/{premiseId}', 'deletePremise')->name('premise.delete');
        });
    });
    Route::prefix('admin/brain-storm')->group(function () {
        Route::controller(\App\Http\Controllers\BrainStormController::class)->group(function () {
            Route::get('/', 'index')->name('brain-storm');
            Route::get('/add', 'addBrainStorm')->name('brain-storm.add');
            Route::post('/add', 'addBrainStormData')->name('brain-storm.add.data');
            Route::get('/update/{brainId}', 'updateBrainStorm')->name('brain-storm.update');
            Route::post('/update/{brainId}', 'updateBrainStormData')->name('brain-storm.update.data');
            Route::get('/brain-storm-detail/{brainId}', 'getBrainStormDetail')->name('brain-storm.detail');
            Route::get('/change-brain-storm-status/{brainId}', 'changeBrainStormStatus')->name('brain-storm.change.status');
            Route::get('/delete/{brainId}', 'deleteBrainStorm')->name('brain-storm.delete');
        });
    });
    Route::prefix('admin/outlines')->group(function () {
        Route::controller(OutlineController::class)->group(function () {
            Route::get('/', 'index')->name('manage.outlines');
            Route::get('/add', 'addOutline')->name('outline.add');
            Route::post('/add', 'addOutlineData')->name('outline.add.data');
            Route::get('/update/{outlineId}', 'updateOutline')->name('outline.update');
            Route::post('/update/{outlineId}', 'updateOutlineData')->name('outline.update.data');
            Route::get('/outline-detail/{outlineId}', 'getOutlineDetail')->name('outline.detail');
            Route::get('/change-outline-status/{outlineId}', 'changeOutlineStatus')->name('outline.change.status');
            Route::get('/delete/{outlineId}', 'deleteOutline')->name('outline.delete');
            Route::get('/get-outline/by-book', 'getOutlineByBook')->name('outline.book');
        });
    });

    Route::prefix('admin/chapters')->group(function () {
        Route::controller(ChapterController::class)->group(function () {
            Route::get('/', 'index')->name('manage.chapters');
            Route::get('/add', 'addChapter')->name('chapter.add');
            Route::post('/add', 'addChapterData')->name('chapter.add.data');
            Route::get('/update/{chapterId}', 'updateChapter')->name('chapter.update');
            Route::post('/update/{chapterId}', 'updateChapterData')->name('chapter.update.data');
            Route::get('/chapter-detail/{chapterId}', 'getChapterDetail')->name('chapter.detail');
            Route::get('/change-chapter-status/{chapterId}', 'changeChapterStatus')->name('chapter.change.status');
            Route::get('/delete/{chapterId}', 'deleteChapter')->name('chapter.delete');
            Route::geT('/get_chapter/by-outline', 'getChapterByOutline')->name('chapter.outline');
        });
    });

    Route::prefix('admin/chapter-cards')->group(function () {
        Route::controller(ChapterCardController::class)->group(function () {
            Route::get('/', 'index')->name('manage.cards');
            Route::get('/add', 'addCard')->name('card.add');
            Route::post('/add', 'addCardData')->name('card.add.data');
            Route::get('/update/{cardId}', 'updateCard')->name('card.update');
            Route::post('/update/{cardId}', 'updateCardData')->name('card.update.data');
            Route::get('/card-detail/{cardId}', 'getCardDetail')->name('card.detail');
            Route::get('/change-card-status/{cardId}', 'changeCardStatus')->name('card.change.status');
            Route::get('/delete/{cardId}', 'deleteCard')->name('card.delete');
            Route::geT('/get_card/by-outline', 'getCardByOutline')->name('card.outline');
        });
    });

    Route::prefix('admin/timelines')->group(function () {
        Route::controller(TimelineController::class)->group(function () {
            Route::get('/', 'index')->name('manage.timelines');
            Route::get('/add', 'addTimeline')->name('timeline.add');
            Route::post('/add', 'addTimelineData')->name('timeline.add.data');
            Route::get('/update/{timelineId}', 'updateTimeline')->name('timeline.update');
            Route::post('/update/{timelineId}', 'updateTimelineData')->name('timeline.update.data');
            Route::get('/timeline-detail/{timelineId}', 'getTimelineDetail')->name('timeline.detail');
            Route::get('/change-timeline-status/{timelineId}', 'changeTimelineStatus')->name('timeline.change.status');
            Route::get('/delete/{timelineId}', 'deleteTimeline')->name('timeline.delete');
            Route::get('/get-timeline/by-book', 'getTimelineByBook')->name('timeline.book');
        });
    });

    Route::prefix('admin/timeline-event-types')->group(function () {
        Route::controller(TimelineEventTypeController::class)->group(function () {
            Route::get('/', 'index')->name('manage.timeline.event.types');
            Route::get('/add', 'addEventType')->name('timeline.event.type.add');
            Route::post('/add', 'addEventTypeData')->name('timeline.event.type.add.data');
            Route::get('/update/{eventTypeId}', 'updateEventType')->name('timeline.event.type.update');
            Route::post('/update/{eventTypeId}', 'updateEventTypeData')->name('timeline.event.type.update.data');
            Route::get('/detail/{eventTypeId}', 'getEventTypeDetail')->name('timeline.event.type.detail');
            Route::get('/change-event-type-status/{eventTypeId}', 'changeEventTypeStatus')->name('timeline.event.type.change.status');
            Route::get('/delete/{eventTypeId}', 'deleteEventType')->name('timeline.event.type.delete');
            Route::geT('/get_chapter/by-outline', 'getEventTypeByOutline')->name('timeline.event.type.outline');
        });
    });

    Route::prefix('admin/plot-planners')->group(function () {
        Route::controller(PlotPlannerController::class)->group(function () {
            Route::get('/', 'index')->name('manage.planners');
            Route::get('/add', 'addPlotPlanner')->name('planner.add');
            Route::post('/add', 'addPlotPlannerData')->name('planner.add.data');
            Route::get('/update/{plannerId}', 'updatePlotPlanner')->name('planner.update');
            Route::post('/update/{plannerId}', 'updatePlotPlannerData')->name('planner.update.data');
            Route::get('/planner-detail/{plannerId}', 'getPlotPlannerDetail')->name('planner.detail');
            Route::get('/change-planner-status/{plannerId}', 'changePlotPlannerStatus')->name('planner.change.status');
            Route::get('/delete/{plannerId}', 'deletePlotPlanner')->name('planner.delete');
            Route::get('/get-planner/by-book', 'getPlotPlannerByBook')->name('planner.book');
        });
    });

    Route::prefix('admin/groups')->group(function () {
        Route::controller(GroupController::class)->group(function () {
            Route::get('/', 'index')->name('manage.groups');
            Route::get('/add', 'addGroup')->name('group.add');
            Route::post('/add', 'addGroupData')->name('group.add.data');
            Route::get('/update/{groupId}', 'updateGroup')->name('group.update');
            Route::post('/update/{groupId}', 'updateGroupData')->name('group.update.data');
            Route::get('/group-detail/{groupId}', 'getGroupDetail')->name('group.detail');
            Route::get('/delete/{groupId}', 'deleteGroup')->name('group.delete');
        });
    });

    Route::controller(AccountController::class)->group(function () {
        Route::get('/manage-account', 'index')->name('manage.account');
        Route::post('/manage-account-data', 'manageAccountData')->name('manage.account.data');
    });
});
