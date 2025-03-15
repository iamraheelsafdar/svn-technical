<?php

use App\Http\Controllers\Student\StudentReferenceController;
use App\Http\Controllers\Certificate\CertificateController;
use App\Http\Controllers\Enrollment\EnrollmentController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Subject\SubjectController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\Center\CenterController;
use App\Http\Controllers\Course\CourseController;
use App\Http\Controllers\Prefix\PrefixController;
use App\Http\Controllers\Result\ResultController;
use App\Http\Controllers\Auth\AuthController;
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
    Route::post('/', [AuthController::class, 'login'])->name('login');
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgotPassword');
    Route::get('/set-password/{email}/{token}', [AuthController::class, 'setPasswordView'])->name('setPasswordView');
    Route::post('/set-password', [AuthController::class, 'setPassword'])->name('setPassword');


    Route::group(['middleware' => ['auth']], function () {
        /*********************** Application Form **********************/
        Route::get('/form/{id}', [CertificateController::class, 'applicationForm'])->name('applicationForm');

        /************************ Students Routes ***********************************/
        Route::get('/students', [StudentController::class, 'students'])->name('studentsView');
        Route::get('/add-student', [StudentController::class, 'addStudentView'])->name('addStudentView');
        Route::post('/add-student', [StudentController::class, 'addStudent'])->name('addStudent');


        /************************* Dashboard Routes *********************************/
        Route::get('/dashboard', [DashboardController::class, 'dashboardView'])->name('dashboardView');
        Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

        /********************************* Profile Routes *********************************/
        Route::get('/profile-setting', [DashboardController::class, 'profileSetting'])->name('profileSettingPage');
        Route::post('/update-profile', [DashboardController::class, 'updateProfile'])->name('updateProfile');


        Route::group(['middleware' => ['admin']], function () {

            /******************** Result Routes ********************/
            Route::get('/create-result/{id}/{student_id}', [ResultController::class, 'createResultView'])->name('createResultView');
            Route::post('/create-result', [ResultController::class, 'createResult'])->name('createResult');
            Route::get('/view-result/{id}', [ResultController::class, 'viewResult'])->name('viewResult');



            /******************** Student Referece ********************/
            Route::get('/student-reference', [StudentReferenceController::class, 'studentsReference'])->name('studentsReference');
            Route::get('/add-student-reference', [StudentReferenceController::class, 'addStudentReferenceView'])->name('addStudentReference');
            Route::get('/update-student-reference', [StudentReferenceController::class, 'updateStudentReferenceView'])->name('updateStudentReferenceView');
            Route::post('/add-student-reference', [StudentReferenceController::class, 'addStudentReference'])->name('addStudentReference');
            Route::post('/update-student-reference', [StudentReferenceController::class, 'updateStudentReference'])->name('updateStudentReference');
            Route::post('/update-reference-status', [StudentReferenceController::class, 'updateReferenceStatus']);


            /*********************** Certificates **********************/
            Route::get('/migration/{id}', [CertificateController::class, 'migrationForm'])->name('migrationForm');
            Route::get('/paramedical-registration-certificate/{id}', [CertificateController::class, 'paramedicalRegCertificate'])->name('paramedicalRegCertificate');
            Route::get('/certificate/{id}', [CertificateController::class, 'certificate'])->name('certificate');

            /************************ Students Routes ***********************************/
            Route::post('/update-student-status', [StudentController::class, 'updateStudentStatus']);
            Route::get('/update-student/{id}', [StudentController::class, 'updateStudentView'])->name('updateStudentView');
            Route::post('/update-student', [StudentController::class, 'updateStudent'])->name('updateStudent');

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


            /********************************* Setting Routes *********************************/
            Route::get('/site-setting', [DashboardController::class, 'siteSetting'])->name('siteSettingPage');
            Route::post('/update-setting', [DashboardController::class, 'updateSetting'])->name('updateSetting');
        });
    });

});
