<?php

use App\Http\Controllers\Center\CenterController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Course\CourseController;
use App\Http\Controllers\Enrollment\EnrollmentController;
use App\Http\Controllers\Prefix\PrefixController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Subject\SubjectController;
use Illuminate\Support\Facades\Route;

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
Route::group(['middleware' => 'logs'], function () {

    /************************** Auth Routes *********************************/
    Route::view('/', 'auth.login')->name('loginPage');
    Route::view('/forgot-password', 'auth.forgot-password')->name('forgotPasswordPage');


    Route::group(['middleware' => 'auth'], function () {

        /************************* Dashboard Routes *********************************/
        Route::get('/dashboard', [DashboardController::class, 'dashboardView'])->name('dashboardView');
        Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


        /************************* Subject Routes *********************************/
        Route::get('/add-subject/{id}', [SubjectController::class, 'addSubjectView'])->name('addSubjectPage');
        Route::post('/add-subject', [SubjectController::class, 'addSubject'])->name('addSubject');
        Route::get('/update-subject/{id}', [SubjectController::class, 'updateSubjectView'])->name('updateSubjectView');
        Route::post('/update-subjects', [SubjectController::class, 'updateSubjects'])->name('updateSubjects');

        /************************* Course Routes *********************************/
        Route::get('/courses', [CourseController::class, 'courses'])->name('coursesPage');
        Route::get('/add-course', [CourseController::class, 'addCourseView'])->name('addCoursePage');
        Route::post('/add-course', [CourseController::class, 'addCourse'])->name('addCourse');
        Route::post('/update-course-status', [CourseController::class, 'updateCourseStatus']);
        Route::get('/update-course/{id}', [CourseController::class, 'updateCourseView'])->name('updateCourseView');
        Route::post('/update-course', [CourseController::class, 'updateCourse'])->name('updateCourse');


        /************************* Enrollment Routes *********************************/
        Route::get('/enrollment', [EnrollmentController::class, 'enrollments'])->name('enrollmentsPage');
        Route::get('/add-enrollment', [EnrollmentController::class, 'addEnrollmentView'])->name('addEnrollmentPage');
        Route::post('/add-enrollment', [EnrollmentController::class, 'addEnrollment'])->name('addEnrollment');
        Route::post('/update-enrollment-status', [EnrollmentController::class, 'updateEnrollmentStatus']);
        Route::get('/update-enrollment/{id}', [EnrollmentController::class, 'updateEnrollmentView'])->name('updateEnrollmentView');
        Route::post('/update-enrollment', [EnrollmentController::class, 'updateEnrollment'])->name('updateEnrollment');


        /************************* Prefix Routes *********************************/
        Route::get('/prefixes', [PrefixController::class, 'prefixes'])->name('prefixesPage');
        Route::get('/add-prefix', [PrefixController::class, 'addPrefixView'])->name('addPrefixPage');
        Route::post('/add-prefix', [PrefixController::class, 'addPrefix'])->name('addPrefix');
        Route::post('/update-prefix-status', [PrefixController::class, 'updatePrefixStatus']);
        Route::get('/update-prefix/{id}', [PrefixController::class, 'updatePrefixView'])->name('updatePrefixView');
        Route::post('/update-prefix', [PrefixController::class, 'updatePrefix'])->name('updatePrefix');


        /********************************* Center Routes *********************************/
        Route::get('/centers', [CenterController::class, 'centers'])->name('centersPage');
        Route::get('/add-center', [CenterController::class, 'addCenterView'])->name('addCenterPage');
        Route::post('/add-center', [CenterController::class, 'addCenter'])->name('addCenter');
        Route::post('/update-center-status', [CenterController::class, 'updateCenterStatus']);
        Route::get('/update-center/{id}', [CenterController::class, 'updateCenterView'])->name('updateCenterView');
        Route::post('/update-center', [CenterController::class, 'updateCenter'])->name('updateCenter');


        /********************************* Profile Routes *********************************/
        Route::get('/profile-setting', [DashboardController::class, 'profileSetting'])->name('profileSettingPage');
        Route::post('/update-profile', [DashboardController::class, 'updateProfile'])->name('updateProfile');


        /********************************* Setting Routes *********************************/
        Route::get('/site-setting', [DashboardController::class, 'siteSetting'])->name('siteSettingPage');
        Route::post('/update-setting', [DashboardController::class, 'updateSetting'])->name('updateSetting');
    });


    Route::post('/', [AuthController::class, 'login'])->name('login');
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgotPassword');
});

