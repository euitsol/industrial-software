<?php
use Illuminate\Support\Facades\Route;



    // Payment Routes for bKash
    Route::post('bkash/get-token', 'BkashController@getToken')->name('bkash-get-token');
    Route::post('bkash/create-payment', 'BkashController@createPayment')->name('bkash-create-payment');
    Route::post('bkash/execute-payment', 'BkashController@executePayment')->name('bkash-execute-payment');
    Route::get('bkash/query-payment', 'BkashController@queryPayment')->name('bkash-query-payment');
    Route::post('bkash/success', 'BkashController@bkashSuccess')->name('bkash-success');

    // Refund Routes for bKash
    Route::get('bkash/refund', 'BkashRefundController@index')->name('bkash-refund');
    Route::post('bkash/refund', 'BkashRefundController@refund')->name('bkash-refund');

    // SSLCOMMERZ Start
    Route::get('/online-payment/example1', 'SslCommerzPaymentController@exampleEasyCheckout');
    Route::get('/online-payment/example2', 'SslCommerzPaymentController@exampleHostedCheckout');
    
    Route::post('/online-payment/pay', 'SslCommerzPaymentController@index');
    Route::post('/online-payment/pay-via-ajax', 'SslCommerzPaymentController@payViaAjax');
    
    Route::post('/online-payment/success', 'SslCommerzPaymentController@success');
    Route::post('/online-payment/fail', 'SslCommerzPaymentController@fail');
    Route::post('/online-payment/cancel', 'SslCommerzPaymentController@cancel');
    
    Route::post('/online-payment/ipn', 'SslCommerzPaymentController@ipn');
    //SSLCOMMERZ END


//online registration
Route::get('/registration', 'Online_registrationController@create')->name('web.registration');
Route::post('/online_store', 'Online_registrationController@store')->name('web.store');
Route::get('/registration/{student_id}/cheackout', 'Online_registrationController@cheackout')->name('web.cheackout');
Route::post('/post-checkout', 'Online_registrationController@course_update')->name('web.post-checkout');
Route::get('/registration/{student_id}/cheackout/payment', 'Online_registrationController@payment1')->name('web.payment1');

//online payment 
Route::get('/online-payment', 'OnlinePaymentController@index')->name('op.index');
Route::post('/online-payment/student/search', 'OnlinePaymentController@search')->name('op.student.search');
Route::get('/online-payment/student/{id}', 'OnlinePaymentController@checkout')->name('op.student.checkout');

Route::get('/online-payment/successfull-payments', 'OnlinePaymentController@successfullPayments')->name('op.payments.success');

//bkash 
Route::post('/token', 'BkashController@token')->name('token');




Auth::routes();

Route::get('/pdf', function () {
    $pdf = PDF::loadView('utility.cv2');
    return $pdf->stream('utility.cv2');
});

Route::get('/ad', function () {
    \App\Models\Account::query()->delete();
});



Route::group(['middleware' => 'auth'], function () {


//classrooom

        Route::get('/classroom' ,'ClassroomController@index')->name('classroom');
        Route::get('/classroom/exam' ,'ClassroomController@exam')->name('classroom.exam');
        Route::post('/classroom/exam/store' ,'ClassroomController@exam_store')->name('classroom.exam.store');
        Route::get('/classroom/exam/{exam_id}/question_paper' ,'ClassroomController@exam_question_paper')->name('classroom.question_paper');
        Route::post('/classroom/exam/store' ,'ClassroomController@exam_question_paper_store')->name('classroom.question_paper.store');
        
//Lab-management

        Route::get('/lab-management' ,'LabController@index')->name('lab-management');
        Route::get('/lab-management/create', 'LabController@create')->name('lab-management.create');
        Route::post('/lab-management/store' ,'LabController@store')->name('lab-management.store');
        Route::get('/lab-management/{labid}/edit', 'LabController@edit')->name('lab-management.edit');
        Route::post('/lab-management/update', 'LabController@update')->name('lab-management.update');
        Route::get('/lab-management/delete/{labid}', 'LabController@destroy')->name('lab-management.delete');
        Route::get('/lab-management/show/{labid}', 'LabController@show')->name('lab-management.show');
// Running Closed
        Route::get('/lab-running/{labid}' ,'LabController@lab_runnig')->name('lab.running');
        Route::get('/lab-closed/{labid}' ,'LabController@lab_closed')->name('lab.closed');


// Session

        Route::get('/session' ,'SessionController@index')->name('session');
        Route::get('/session/create','SessionController@create')->name('session.create');
        Route::post('/session/store', 'SessionController@store')->name('session.store');
        Route::get('/session/edit/{id}', 'SessionController@edit')->name('session.edit');
        Route::post('/session/update', 'SessionController@update')->name('session.update');
        Route::get('/session/delete/{id}', 'SessionController@destroy')->name('session.delete');
        Route::get('/session/show/{id}', 'SessionController@show')->name('session.show');
        Route::get('/session/status/{id}', 'SessionController@statusChange')->name('session.status');

//Student Analytics

        Route::get('/student-analytics/show/{session_id?}' ,'AnalyticsController@index')->name('analytics');

        //source

        Route::get('/student-analytics/add-source' ,'AnalyticsController@addSource')->name('analytics.source.add');
        Route::post('/student-analytics/add-source/store' ,'AnalyticsController@addSourceStore')->name('analytics.source.store');
        Route::get('/student-analytics/edit-source/{id}' ,'AnalyticsController@editSource')->name('analytics.source.edit');
        Route::post('/student-analytics/update-source' ,'AnalyticsController@updateSource')->name('analytics.source.update');
        Route::get('/student-analytics/delete-source/{id}' ,'AnalyticsController@deleteSource')->name('analytics.source.delete');
        Route::get('/student-analytics/source-status/{id}' ,'AnalyticsController@sourceStatus')->name('analytics.source.status');

        //referral

        Route::get('/student-analytics/add-referral' ,'AnalyticsController@addReferral')->name('analytics.referral.add');
        Route::post('/student-analytics/add-referral/store' ,'AnalyticsController@addReferralStore')->name('analytics.referral.store');
        Route::get('/student-analytics/edit-referral/{id}' ,'AnalyticsController@editReferral')->name('analytics.referral.edit');
        Route::post('/student-analytics/update-referral' ,'AnalyticsController@updateReferral')->name('analytics.referral.update');
        Route::get('/student-analytics/delete-referral/{id}' ,'AnalyticsController@deleteReferral')->name('analytics.referral.delete');
        Route::get('/student-analytics/referral-status/{id}' ,'AnalyticsController@referralStatus')->name('analytics.referral.status');


//industrial marketing

    Route::get('/industrial/student' ,'IndustrialMarketingController@student')->name('marketing.industrial.student');
    Route::post('/industrial/student/add' ,'IndustrialMarketingController@add_student')->name('marketing.industrial.student.add');
    
    Route::get('/industrial/message' ,'IndustrialMarketingController@message_index')->name('marketing.industrial.message');
    Route::post('/industrial/message/search' ,'IndustrialMarketingController@message_search')->name('marketing.industrial.message.search');
    Route::post('/industrial/message/view' ,'IndustrialMarketingController@view')->name('marketing.industrial.message.view');
    Route::post('/industrial/message/send' ,'IndustrialMarketingController@message_send')->name('marketing.industrial.message.send');


//Institute visit
    Route::get('/institute-visit' ,'InstituteVisitController@index')->name('iv');
    Route::get('/institute-visit/add' ,'InstituteVisitController@add')->name('iv.add');
    Route::post('/institute-visit/create' ,'InstituteVisitController@store')->name('iv.store');
    Route::get('/institute-visit/show/{id}' ,'InstituteVisitController@show')->name('iv.show');
    Route::get('/institute-visit/edit/{id}' ,'InstituteVisitController@edit')->name('iv.edit');



//online operatiion
        Route::get('/online_operation' ,'Online_opController@index')->name('online_op');
        Route::get('/online_operation/course-discount' ,'Online_opController@course_dis')->name('online_op.course_dis');
        Route::get('/online_operation/course-discount-history' ,'Online_opController@course_dis_history')->name('online_op.course_dis_history');
        Route::get('/online_operation/course-discount/create' ,'Online_opController@course_dis_create')->name('online_op.course_dis_create');
        Route::post('/online_operation/course-discount/store' ,'Online_opController@course_dis_store')->name('online_op.course_dis_store');
        Route::get('/online_operation/course-discount/{cid}/update' ,'Online_opController@course_dis_update')->name('online_op.course_dis_update');
        Route::post('/online_operation/course-discount/{cid}/update/store' ,'Online_opController@course_dis_update_store')->name('online_op.course_dis_update_store');
        //online registration
        Route::get('/online_reg' ,'Online_opController@online_reg')->name('online_reg');
        //course status
        Route::get('/course_status' ,'Online_opController@course_status')->name('course_status');
        Route::post('/course_status/store' ,'Online_opController@course_status_store')->name('course_status.store');
        
        
        Route::get('/online-operation/admit/{id}' ,'Online_opController@admit')->name('online_op.admit');

//summary report
        Route::get('/summary_report' ,'summary_reportController@index')->name('summary_report');
        Route::post('/summary_report/search', 'summary_reportController@summaryReport')->name('summary_report.search');
        Route::get('/summary_report/batch/{bid}/report', 'summary_reportController@reportsByBatch')->name('summary_report.report.batch');
        Route::get('/summary_report/course/{cid}/report', 'summary_reportController@reportsByCourse')->name('summary_report.report.course');
        Route::get('/summary_report/type/{ct}/report', 'summary_reportController@reportsByCourseType')->name('summary_report.report.course_type');
        Route::get('/summary_report/all', 'summary_reportController@all_reports')->name('summary_report.all');

//Attendance
        Route::get('/attendance' ,'AttendanceController@index')->name('attendance');
        Route::post('/attendance/search', 'AttendanceController@attendanceClass')->name('attendance.search');
        Route::get('/attendance/page/{id}', 'AttendanceController@attendancePage')->name('attendance.page');
        Route::get('/attendance/create/{id}/{class}', 'AttendanceController@create')->name('attendance.create');
        Route::post('/attendance/store', 'AttendanceController@store')->name('attendance.store');
        Route::get('/attendance/report/{id}', 'AttendanceController@attendanceReport')->name('attendance.report');

//Attendance Report(Batch Wise)
        Route::get('/attendance_batch' ,'AttendanceReportController@batchWise')->name('attendance.batch');
        Route::post('/attendance_batch/search', 'AttendanceReportController@batchWiseSearch')->name('attendance_batch.search');
        Route::get('/attendance_report/batch/{id}', 'AttendanceReportController@batchAttendanceReport')->name('attendance_report.batch');


// Discount Report
        Route::get('/discount-report' ,'ReportController@discount_report')->name('discount.report');



//indivisual report
        Route::get('/indivisual_report' ,'Indivisual_reportController@index')->name('indivisual_report');

        Route::post('/indivisual_report/search', 'Indivisual_reportController@indivisual_report')->name('indivisual_report.search');

        Route::get('/indivisual_report/batch/{bid}/report', 'Indivisual_reportController@reportsByBatch')->name('indivisual_report.report.batch');

        Route::get('/indivisual_report/course/{cid}/report', 'Indivisual_reportController@reportsByCourse')->name('indivisual_report.report.course');

        Route::get('/indivisual_report/type/{ct}/report', 'Indivisual_reportController@reportsByCourseType')->name('indivisual_report.report.course_type');

        Route::get('/indivisual_report/all', 'Indivisual_reportController@all_reports')->name('indivisual_report.all');

//nav assign
        Route::get('/nav_assign','NavController@index')->name('nav_assign');
        //AJAX Request
        Route::get('/nav_assign/user/{type}', 'NavController@userByType')->name('user.type');
        Route::get('/nav_assign/user/{user_name}', 'NavController@userById')->name('user.id');


        Route::post('/nav_assign/search', 'NavController@indivisual_menu')->name('nav_assign.search');

        Route::get('/nav_assign/{user_name}/menus', 'NavController@menus')->name('nav_assign.menu');

        Route::post('/nav_assign/save', 'NavController@save')->name('nav_assign.save');


//dynamic menu
        Route::get('/dynamic_menu','Dynamic_sidebar_controller@sideber')->name('dynamic_menu');
        Route::get('/ds','SideberController@index')->name('ds');
        Route::get('/f','SideberController@view')->name('f');
        Route::get('/s','SideberController@view2')->name('s');


//test

        Route::get('/attach_file', 'ImportController@getImport')->name('import');
        Route::post('/import_parse', 'ImportController@parseImport')->name('import_parse');
        Route::get('/add_promotion_type', 'ImportController@add')->name('add_promotion_type');
        Route::post('/add_promotion_type', 'ImportController@save')->name('promotion_type.save');
        Route::get('/promotion_type/{id}/show', 'ImportController@show')->name('promotion_type.show');
        Route::get('/promotion_type/{id}/edit', 'ImportController@edit')->name('promotion_type.edit');
        Route::post('/promotion_type/{id}/update', 'ImportController@update')->name('promotion_type.update');
        Route::get('/promotion_type/{id}/delete', 'ImportController@destroy')->name('promotion_type.delete');
        Route::post('/import_parse/{id}/process', 'ImportController@csv_save')->name('import_parse.process');

        Route::get('/csv_info', 'ImportController@csv_info')->name('csv_info');
        Route::post('/csv_info/search', 'ImportController@csv_info_search')->name('csv_info.search');

        Route::get('/csv_info/{id}/edit', 'ImportController@csv_edit')->name('csv_info.edit');
        Route::get('/csv_info/{id}/delete', 'ImportController@csv_delete')->name('csv_info.delete');
        Route::post('/csv_info/update', 'ImportController@csv_update')->name('csv_info.update');



//sms controller
        Route::get('/promotion_type/sms/index', 'SmsController@promotional_sms_index')->name('promotion_type.sms.index');
        Route::post('/promotion_type/sms/search', 'SmsController@promotional_sms_search')->name('promotion_type.sms.search');
        Route::get('/promotion_type/{id}/sms', 'ImportController@csv_view')->name('promotion_type.sms');

        Route::post('/promotion_type/sms/send', 'SmsController@sms_send')->name('promotion_type.sms.send');



//sms students
        Route::get('/sms/sms_students', 'SmsController@sms_students')->name('sms.sms_students');
        Route::post('/sms/sms_students/search', 'SmsController@sms_students_search')->name('sms.sms_students.search');
        Route::post('/sms/sms_students/send', 'SmsController@sms_students_send')->name('sms.sms_students.send');

//sms history
        Route::get('/sms/history', 'SmsController@sms_history')->name('sms.history');
        Route::get('/sms/history/{id}/view', 'SmsController@sms_history_show')->name('sms.history.view');
//sms indivisual
        Route::get('/sms/indivisual', 'SmsController@sms_indivisual')->name('sms.indivisual');
        Route::post('/sms/indivisual/send', 'SmsController@sms_indivisual_send')->name('sms.indivisual.send');
//sms to teacher
        Route::get('/sms/teacher/{year?}', 'SmsController@sms_teacher')->name('sms.teacher');
        Route::post('/sms/teacher/send', 'SmsController@sms_teacher_send')->name('sms.teacher.send');



//Cash to Bank
        Route::get('/cash-to-bank', 'CashToBankController@index')->name('ctb');
        Route::post('/cash-to-bank/search', 'CashToBankController@search')->name('ctb.search');
        Route::get('/cash-to-bank/{date}/{user}/{type}', 'CashToBankController@ctb_all')->name('ctb.all');
        Route::post('/cash-to-bank/add', 'CashToBankController@cash_add')->name('ctb.add');
        Route::get('/cash-to-bank/details', 'CashToBankController@ctb_detail')->name('ctb.detail');
        
        // additional fee
        Route::get('/additional-fee', 'AccountController@additional_fee')->name('add_fee');


            Route::get('/', 'HomeController@index')->name('home');

            Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

            Route::group(['middleware' => 'admin'], function () {
                Route::get('/users', 'UserController@index')->name('users');
                Route::post('/user/store', 'UserController@store')->name('user.store');
                Route::get('/user/{uid}/edit', 'UserController@edit')->name('user.edit');
                Route::post('/user/update', 'UserController@update')->name('user.update');
                Route::get('/user/{uid}/delete', 'UserController@destroy')->name('user.destroy');

                Route::get('/institutes', 'InstituteController@index')->name('institutes');
                Route::get('/institute/create', 'InstituteController@create')->name('institute.create');
                Route::post('/institute/store', 'InstituteController@store')->name('institute.store');
                Route::get('/institute/{iid}/show', 'InstituteController@show')->name('institute.show');
                Route::get('/institute/{iid}/edit', 'InstituteController@edit')->name('institute.edit');
                Route::post('/institute/update', 'InstituteController@update')->name('institute.update');
                Route::get('/institute/{iid}/delete', 'InstituteController@destroy')->name('institute.delete');

                Route::get('/teachers/find', 'TeacherController@index')->name('teachers.find');
                Route::post('/teachers/find', 'TeacherController@findTeachers');
                Route::get('/teachers/{iid}/found', 'TeacherController@get_teachers')->name('teachers.found');
                Route::get('/teacher/create', 'TeacherController@create')->name('teacher.create');
                Route::post('/teacher/store', 'TeacherController@store')->name('teacher.store');
                Route::get('/teacher/{tid}/edit', 'TeacherController@edit')->name('teacher.edit');
                Route::post('/teacher/update', 'TeacherController@update')->name('teacher.update');
                Route::get('/teacher/{tid}/delete', 'TeacherController@destroy')->name('teacher.delete');
                Route::get('/teacher/{tid}/show', 'TeacherController@show')->name('teacher.show');

                Route::get('/teacher/payment-setup/{year?}', 'TeacherController@teacher_payment_setup_index')->name('teacher.payment.setup.index');
                Route::get('/teacher/payment/setup', 'TeacherController@teacher_payment_setup')->name('teacher.payment.setup');
                Route::post('/teacher/payment/setup/process', 'TeacherController@teacher_payment_setup_process')->name('teacher.payment.setup.process');
                Route::get('/teacher/payment/setup/{tpiid}/edit', 'TeacherController@teacher_payment_setup_edit')->name('teacher.payment.setup.edit');
                Route::post('/teacher/payment/setup/update', 'TeacherController@teacher_payment_setup_update')->name('teacher.payment.setup.update');
                Route::post('/teacher/payment/setup/delete', 'TeacherController@teacher_payment_setup_destroy')->name('teacher.payment.setup.delete');

                Route::get('/teacher/payment/institute', 'TeacherPaymentController@index')->name('teacher.payment.institute');
                Route::post('/teacher/payment/institute/find', 'TeacherPaymentController@institute_find')->name('teacher.payment.institute.find');
                Route::get('/teacher/payment/{iid}/{year}', 'TeacherPaymentController@institute_payment')->name('teacher.payment');
                Route::post('/teacher/payment/process', 'TeacherPaymentController@teacher_payment')->name('teacher.payment.process');

                Route::get('/teacher/payment/history', 'TeacherPaymentController@teacher_payment_history')->name('teacher.payment.history');

                Route::get('institute/{iid}/teacher/payment/years', 'TeacherPaymentController@teacher_payment_years')->name('teacher.payment.years');

                Route::get('/sectors', 'CourseTypeController@index')->name('course_types');
                Route::get('/sector/create', 'CourseTypeController@create')->name('course_type.create');
                Route::post('/sector/store', 'CourseTypeController@store')->name('course_type.store');
                Route::get('/sector/{ctid}/edit', 'CourseTypeController@edit')->name('course_type.edit');
                Route::post('/sector/update', 'CourseTypeController@update')->name('course_type.update');
                Route::get('/sector/{ctid}/delete', 'CourseTypeController@destroy')->name('course_type.delete');

                Route::get('/courses', 'CourseController@index')->name('courses');
                Route::get('/course/create', 'CourseController@create')->name('course.create');
                Route::post('/course/store', 'CourseController@store')->name('course.store');
                Route::get('/course/{cid}/show', 'CourseController@show')->name('course.show');
                Route::get('/course/{cid}/edit', 'CourseController@edit')->name('course.edit');
                Route::post('/course/update', 'CourseController@update')->name('course.update');
                Route::get('/course/{cid}/delete', 'CourseController@destroy')->name('course.delete');
                Route::get('/course/{cid}/status', 'CourseController@status')->name('course.running');

                // AJAX Request
                Route::get('/courses/{type}', 'CourseController@courseByType')->name('courses.type');
                Route::get('/courses/mentor/{type}', 'CourseController@courseByMentor')->name('courses.mentor');

                Route::get('/course/{cid}/batches', 'CourseController@getBatchesByCourse')->name('course.batches');
                Route::get('/course/mentor/{cid}/batches', 'CourseController@getBatchesByMentor')->name('mentor.batches');

                Route::get('/course/{cid}/{year}/batch-name', 'CourseController@createBatchName')->name('course.batch.create');
                Route::get('/course-details/{id}', 'CourseController@course_details')->name('courses.id');

                Route::get('/batches', 'BatchController@index')->name('batches');
                Route::get('/batch/create', 'BatchController@create')->name('batch.create');
                Route::post('/batch/store', 'BatchController@store')->name('batch.store');
                Route::get('/batch/{bid}/edit', 'BatchController@edit')->name('batch.edit');
                Route::post('/batch/update', 'BatchController@update')->name('batch.update');
                Route::get('/batch/{bid}/delete', 'BatchController@destroy')->name('batch.delete');
                Route::get('/batch/{bid}/status', 'BatchController@status')->name('batch.status');
                Route::get('/batch/{bid}/details', 'BatchController@details')->name('batch.details');

                Route::get('/mentors', 'MentorController@index')->name('mentors');
                Route::get('/mentor/create', 'MentorController@create')->name('mentor.create');
                Route::post('/mentor/store', 'MentorController@store')->name('mentor.store');
                Route::get('/mentor/{mid}/show', 'MentorController@show')->name('mentor.show');
                Route::get('/mentor/{mid}/edit', 'MentorController@edit')->name('mentor.edit');
                Route::get('/mentor/{mid}/delete', 'MentorController@destroy')->name('mentor.delete');

                Route::get('/mentor/{mid}/career-objective/create', 'MentorController@career_objective')->name('mentor.career-objective');
                Route::post('/mentor/career-objective/store', 'MentorController@career_objective_store')->name('mentor.career-objective.store');
                Route::get('/mentor/{mid}/academic-q/create', 'MentorController@academic_qualification')->name('mentor.academic-qualification');
                Route::post('/mentor/academic-q/store', 'MentorController@academic_q_store')->name('mentor.academic-q-store.store');
                Route::get('/mentor/{mid}/specialization/create', 'MentorController@create_specialization')->name('mentor.specialization.create');
                Route::post('/mentor/specialization/store', 'MentorController@specialization_store')->name('mentor.specialization.store');
                Route::get('/mentor/{mid}/employment-h/create', 'MentorController@create_employment_h')->name('mentor.employment-history.create');
                Route::post('/mentor/employment-h/store', 'MentorController@employment_history_store')->name('mentor.employment-history.store');
                Route::get('/mentor/{mid}/personal-info/edit', 'MentorController@edit_personal_info')->name('mentor.personal-info.edit');
                Route::post('/mentor/personal-info/update', 'MentorController@update_personal_info')->name('mentor.personal-info.update');
                Route::get('/mentor/{mid}/career-objective/edit', 'MentorController@edit_career_objective')->name('mentor.career-objective.edit');
                Route::post('/mentor/career-objective/update', 'MentorController@update_career_objective')->name('mentor.career-objective.update');
                Route::get('/mentor/{mid}/employment-history/edit', 'MentorController@edit_employment_history')->name('mentor.employment-history.edit');
                Route::post('/mentor/employment-history/update', 'MentorController@update_employment_history')->name('mentor.employment-history.update');
                Route::get('/mentor/employment-history/{eid}/delete', 'MentorController@delete_employment_history')->name('mentor.employment-history.delete');
                Route::get('/mentor/{mid}/academic-q/edit', 'MentorController@edit_academic_qualification')->name('mentor.academic-qualification.edit');
                Route::post('/mentor/academic-q/update', 'MentorController@update_academic_qualification')->name('mentor.academic-qualification.update');
                Route::get('/mentor/academic-q/{aid}/delete', 'MentorController@delete_academic_qualification')->name('mentor.academic-qualification.delete');
                Route::get('/mentor/{mid}/specialization/edit', 'MentorController@edit_specialization')->name('mentor.specialization.edit');
                Route::post('/mentor/specialization/update', 'MentorController@update_specialization')->name('mentor.specialization.update');
                Route::get('/mentor/specialization/{sid}/delete', 'MentorController@delete_specialization')->name('mentor.specialization.delete');

                Route::get('/mentor/{mid}/setup-payments', 'MentorController@mentor_payment_setup_index')->name('mentor.setup-payments');
                Route::get('/mentor/{mid}/payment/setup', 'MentorController@mentor_payment_setup')->name('mentor.payment.setup');
                Route::post('/mentor/payment-setup', 'MentorController@mentor_payment_setup_process')->name('mentor.payment-setup.process');
                Route::get('/mentor/payment/setup/{mpiid}/edit', 'MentorController@mentor_payment_setup_edit')->name('mentor.payment-setup.edit');
                Route::post('/mentor/payment-setup/update', 'MentorController@mentor_payment_setup_update')->name('mentor.payment-setup.update');
                Route::post('/mentor/payment-setup/delete', 'MentorController@mentor_payment_setup_delete')->name('mentor.payment-setup.delete');

                Route::get('/mentor/payment', 'MentorPaymentController@index')->name('mentor.payment.mentor-search');
                Route::post('/mentor/payment/mentor-search', 'MentorPaymentController@mentor_search')->name('mentor.payment.mentor-search.process');
                Route::get('/mentor/payment/{mid}/info', 'MentorPaymentController@mentor_payment_info')->name('mentor.payment.info');
                Route::get('/mentor/payment/{mpiid}/p', 'MentorPaymentController@mentor_payment')->name('mentor.payment.p');
                Route::post('/mentor/payment/receive', 'MentorPaymentController@mentor_payment_receive')->name('mentor.payment.receive');

                Route::get('/mentor/batch-setup', 'MentorController@batch_setup_index')->name('mentor.batch-setup.index');
                Route::get('/mentor/{mid}/batch/setup', 'MentorController@batch_setup')->name('mentor.batch.setup');
                Route::post('/mentor/batch/setup/process', 'MentorController@batch_setup_process')->name('mentor.batch-setup.process');

                Route::get('/mentor/payment/history', 'MentorPaymentController@mentor_payment_history')->name('mentor.payment.history');

                Route::get('/mentor/{mid}/course/{cid}/batches', 'MentorController@mentor_batches_by_course')->name('mentor.course.batches');

                Route::get('/report', 'ReportController@index')->name('report.index');
                Route::post('/report/students/search', 'ReportController@studentsReport')->name('report.students.search');
                Route::get('/report/batch/{bid}/students', 'ReportController@studentsByBatch')->name('report.students.batch');
                Route::get('/report/course/{cid}/students', 'ReportController@studentsByCourse')->name('report.students.course');
                Route::get('/report/type/{ct}/students', 'ReportController@studentByCourseType')->name('report.students.course-type');
                Route::post('/report/payment/status/search', 'ReportController@paymentStatusSearch')->name('report.payment.status.search');
                Route::get('/report/due/{ct}/{yr}/students', 'ReportController@duePaymentStudents')->name('report.due.students');
                Route::get('/report/paid/{ct}/students', 'ReportController@paidPaymentStudents')->name('report.paid.students');
                Route::get('/report/students', 'ReportController@allStudents')->name('report.students.all');
                Route::post('/report/division/institute/find', 'ReportController@divisionInstituteStudents')->name('report.division.institute.find');
                Route::get('/report/institute/{iid}/{yr}/students/{shift?}', 'ReportController@studentsByInstitute')->name('report.institute.students');
                Route::get('/report/institute/{iid}/{yr}/students-due/{shift?}', 'ReportController@studentsByInstituteDue')->name('report.institute.students.due');
                Route::get('/report/division/{division}/{yr}/students', 'ReportController@studentsByDivision')->name('report.division.students');
                
                Route::get('/report/institute', 'ReportController@institute_index')->name('report.institute.index');
                Route::get('/report/division', 'ReportController@division_index')->name('report.division.index');

                Route::get('/transaction', 'ReportController@transaction')->name('transaction');
                Route::post('/transaction/find', 'ReportController@transaction_find')->name('transaction.find');
        //        Route::get('/transaction/{from_date}/{to_date}/found', 'ReportController@transaction_show')->name('transaction.show');
                Route::get('/transaction/{uid}/{from_date}/{to_date}/{type}/show', 'ReportController@user_transaction_show')->name('transaction.user.show');
                
        // Transaction Report Session Wise
                Route::get('/transaction_session_wise', 'ReportController@transaction_session_wise')->name('transaction_session_wise');
                Route::post('/transaction_session_wise/find', 'ReportController@transaction_session_wise_find')->name('transaction_session_wise.find');
                Route::get('/transaction_session_wise/{uid}/{session_id}/show', 'ReportController@session_wise_user_transaction_show')->name('transaction_session_wise.user.show');

        //Reference Wise Admission Report
                Route::get('/reference_wise_admission_report', 'ReportController@reference_wise_report')->name('reference_wise_report');
                Route::post('/reference_wise_admission_report/find', 'ReportController@reference_wise_report_find')->name('reference_wise_report.find');
                Route::get('/reference_wise_admission_report/show/{source_id?}/{referral_id?}/{from_date}/{to_date}', 'ReportController@reference_wise_report_show')->name('reference_wise_report.show');


                Route::get('/student/{sid}/course/{bid}/migration', 'StudentController@student_course_migration')->name('student.course.migration');
                Route::post('/student/course/migrate', 'StudentController@student_course_migrate')->name('student.course.migrate');
                Route::get('/student/{sid}/course/{cid}/previous', 'StudentController@migrated_previous_course')->name('student.course.previous');

                Route::get('/students/installment-dates/today', 'ReportController@today_installment_dates')->name('installment_dates.today');
                Route::post('/students/installment/message', 'AccountController@installment_message_send')->name('student.installment.message');

            });

        //     Route::get('/students/{students_type}/{year?}', 'StudentController@index')->name('students.professional',['students_type'=>'Professional']);
        //     Route::get('/students/{students_type}/{year?}', 'StudentController@index')->name('students.industrial',['students_type'=>'Professional']);
            Route::get('/students/professional/{year?}', 'StudentController@index')->name('students.professional');
            Route::get('/students/industrial/{year?}', 'StudentController@index_2')->name('students.industrial');


            Route::prefix('student')->name('student.')->group(function () {


                Route::get('/create', 'StudentController@create')->name('create');
                Route::post('/store', 'StudentController@store')->name('store');
                Route::get('/{sid}/show', 'StudentController@show')->name('show');
                Route::get('/{sid}/edit', 'StudentController@edit')->name('edit');
                Route::post('/update', 'StudentController@update')->name('update');
                Route::get('/{sid}/delete', 'StudentController@destroy')->name('delete');

                Route::get('/{student_as}/{year}/new-reg-number', 'StudentController@new_reg_number')->name('new.reg.number');

                Route::get('/search', 'StudentController@search_student')->name('search');
                Route::post('/search/process', 'StudentController@student_search_process')->name('search.process');
                Route::get('/{sid}/course/assign', 'StudentController@new_course_assign')->name('course.assign');
                Route::get('/migration/{mid}/payment', 'StudentController@migration_payment')->name('migration.payment');
                Route::post('/course/assign/process', 'StudentController@student_course_add')->name('course.add');

                Route::get('/{sid}/registration-form', 'StudentController@registration_form')->name('registration-form');
                //existing students

                Route::get('/existing_students/create', 'StudentController@existing_create')->name('existing.create');
                Route::post('/existing_students/search', 'StudentController@existing_search')->name('existing.search');
                Route::get('/existing_students/{phone}/assign_new_type', 'StudentController@assign_new_type')->name('existing.assign_new_type');
                Route::post('/existing_students/save', 'StudentController@existing_save')->name('existing.save');
                Route::get('/existing_students/{id}/assign_new_course', 'StudentController@existing_new_course')->name('existing.assign_new_course');

            });

            Route::get('/account', 'AccountController@index')->name('account');
            Route::post('/account/search', 'AccountController@accountSearch')->name('account.search');
            Route::get('/account/student/{sid}/courses', 'AccountController@studentCourses')->name('account.student.courses');
            Route::get('/account/student/{sid}/{cid}/payment', 'PaymentController@payment')->name('account.payment');
            Route::get('/account/{sid}/{cid}/payment/new', 'PaymentController@newPaymentForm')->name('account.payment.new');
            Route::get('/account/{sid}/{cid}/payment/exist', 'PaymentController@existPaymentForm')->name('account.payment.exist');
            Route::post('/account/payment/new/receive', 'PaymentController@newPaymentReceive')->name('payment.new.receive');
            Route::post('/account/payment/installment', 'PaymentController@installmentReceive')->name('payment.installment');

//indivisual payment money receipt
            Route::get('/account/payment/{aid}/{pid?}/receipt', 'PaymentController@paymentReceipt')->name('payment.receipt');

            Route::get('/student/{sid}/payment/history', 'PaymentController@studentPaymentHistory')->name('student.payment.history');
            Route::post('/account/payment/anytime-discount/{aid}', 'PaymentController@anytimeDiscount')->name('anytime.discount');

            Route::get('/daily-report', 'DailyreportController@index')->name('daily.report');
            Route::get('/daily-report/ajax', 'DailyreportController@drajax');

            Route::get('/change-course-batch/{sid}/{cid}/{bid}', 'ChangecoursebatchController@index')->name('change.course.view');
            Route::get('/ajax/change/course', 'ChangecoursebatchController@ajaxCall');
            Route::post('/change-course-batch/{sid}/{cid}/{bid}', 'ChangecoursebatchController@change')->name('change.course');

            Route::get('/birthday', 'DailyreportController@birthday')->name('birthday');
            Route::post('/sms-student-birthday', 'DailyreportController@birthdaySms')->name('sms.student.birthday');


            Route::post('/sms-student-batch/{bid}', 'ReportController@smsStudentBatch')->name('sms.student.batch');

            Route::get('/marketing/default-list', 'MarketingController@index')->name('marketing.list');
            Route::get('/marketing/admitted-list', 'MarketingController@admittedList')->name('marketing.admitted.list');
            Route::get('/marketing/not-interested-list', 'MarketingController@notInterestedList')->name('marketing.not.interested.list');
            Route::get('/marketing/add', 'MarketingController@create')->name('marketing.add');
            Route::get('/marketing/delete/{mid}', 'MarketingController@destroy')->name('marketing.delete');
            Route::get('/marketing/admitted/{mid}', 'MarketingController@admitted')->name('marketing.admitted');
            Route::get('/marketing/not-interested/{mid}', 'MarketingController@notInterested')->name('marketing.notInterested');
            Route::get('/marketing/interested/{mid}', 'MarketingController@interested')->name('marketing.interested');
            Route::post('/marketing/add', 'MarketingController@store')->name('marketing.store');
            Route::post('/marketing-comment/add/{mid}', 'MarketingController@storeComment')->name('marketing.comment.store');
            Route::post('/marketing-default/search', 'MarketingController@defaultSearch')->name('marketing.default.search');
            Route::post('/marketing-not-interested/search', 'MarketingController@notInterestedSearch')->name('marketing.notInterested.search');
            Route::post('/marketing-admitted/search', 'MarketingController@admittedSearch')->name('marketing.admitted.search');
            Route::get('/marketing/today-conversation-list', 'MarketingController@today')->name('marketing.list.today');

            Route::post('/sms-student-institute/{iid}/{yr}', 'ReportController@instituteSms')->name('sms.student.institute');
            Route::post('/sms-student-institute/{iid}/{yr}/due', 'ReportController@instituteSmsDue')->name('sms.student.institute.due');


        });
