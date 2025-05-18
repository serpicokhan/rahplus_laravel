<?php

use Illuminate\Support\Facades\Route;

Route::namespace('Auth')->group(function () {
    Route::middleware('admin.guest')->group(function () {
        Route::controller('LoginController')->group(function () {
            Route::get('/', 'showLoginForm')->name('login');
            Route::post('/', 'login')->name('login');
            Route::get('logout', 'logout')->middleware('admin')->withoutMiddleware('admin.guest')->name('logout');
        });
        // Admin Password Reset
        Route::controller('ForgotPasswordController')->prefix('password')->name('password.')->group(function () {
            Route::get('reset', 'showLinkRequestForm')->name('reset');
            Route::post('reset', 'sendResetCodeEmail');
            Route::get('code-verify', 'codeVerify')->name('code.verify');
            Route::post('verify-code', 'verifyCode')->name('verify.code');
        });

        Route::controller('ResetPasswordController')->group(function () {
            Route::get('password/reset/{token}', 'showResetForm')->name('password.reset.form');
            Route::post('password/reset/change', 'reset')->name('password.change');
        });
    });
});


Route::middleware('admin')->group(function () {

    //zone
    Route::controller('ZoneController')->prefix('zone')->name('zone.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('save/{id}', 'save')->name('save');
        Route::post('change-status/{id}', 'changeStatus')->name('status');
    });

    //Service
    Route::controller('ServiceController')->prefix('services')->name('service.')->group(function () {
        Route::get('index', 'index')->name('index');
        Route::post('store/{id?}', 'store')->name('store');
        Route::post('status/{id}', 'status')->name('status');
    });

    //Brands
    Route::controller('BrandController')->prefix('brands')->name('brand.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('status/{id}', 'status')->name('status');
        Route::post('store/{id?}', 'store')->name('store');
    });
    //model
    Route::controller('VehicleModelController')->prefix('vehicle-model')->name('model.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('status/{id}', 'status')->name('status');
        Route::post('store/{id?}', 'store')->name('store');
    });
    //color
    Route::controller('VehicleColorController')->prefix('vehicle-color')->name('color.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('status/{id}', 'status')->name('status');
        Route::post('store/{id?}', 'store')->name('store');
    });

    //year
    Route::controller('VehicleYearController')->prefix('vehicle-year')->name('year.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('status/{id}', 'status')->name('status');
        Route::post('store/{id?}', 'store')->name('store');
    });

    //Coupons
    Route::controller('CouponController')->prefix('coupon')->name('coupon.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('store/{id?}', 'store')->name('store');
        Route::get('detail/{id}', 'detail')->name('detail');
        Route::post('change-status/{id}', 'changeStatus')->name('status.change');
    });

    Route::controller('ManageReviewController')->name('reviews.')->prefix('reviews')->group(function () {
        Route::get('/', 'reviews')->name('all');
    });

    Route::controller('ManageRideController')->name('rides.')->prefix('rides')->group(function () {
        Route::get('/', 'allRides')->name('all');
        Route::get('new', 'new')->name('new');
        Route::get('running', 'running')->name('running');
        Route::get('completed', 'completed')->name('completed');
        Route::get('canceled', 'canceled')->name('canceled');
        Route::get('detail/{id}', 'detail')->name('detail');
        Route::get('bids/{id}', 'bid')->name('bids');
    });




    // Users Manager
    Route::controller('ManageRiderController')->name('rider.')->prefix('rider')->group(function () {
        Route::get('/', 'allUsers')->name('all');
        Route::get('active', 'activeUsers')->name('active');
        Route::get('banned', 'bannedUsers')->name('banned');
        Route::get('email-verified', 'emailVerifiedUsers')->name('email.verified');
        Route::get('email-unverified', 'emailUnverifiedUsers')->name('email.unverified');
        Route::get('mobile-unverified', 'mobileUnverifiedUsers')->name('mobile.unverified');
        Route::get('mobile-verified', 'mobileVerifiedUsers')->name('mobile.verified');

        Route::get('detail/{id}', 'detail')->name('detail');
        Route::post('update/{id}', 'update')->name('update');
        Route::post('add-sub-balance/{id}', 'addSubBalance')->name('add.sub.balance');
        Route::get('send-notification/{id}', 'showNotificationSingleForm')->name('notification.single');
        Route::post('send-notification/{id}', 'sendNotificationSingle')->name('notification.single');
        Route::post('status/{id}', 'status')->name('status');

        Route::get('send-notification', 'showNotificationAllForm')->name('notification.all');
        Route::post('send-notification', 'sendNotificationAll')->name('notification.all.send');
        Route::get('list', 'list')->name('list');
        Route::get('count-by-segment/{methodName}', 'countBySegment')->name('segment.count');
        Route::get('notification-log/{id}', 'notificationLog')->name('notification.log');
    });

    //Rider Rules
    Route::controller('RiderRuleController')->prefix('rider/rules')->name('rider.rule.')->group(function () {
        Route::get('index', 'index')->name('index');
        Route::post('store/{id?}', 'store')->name('store');
        Route::post('status/{id}', 'status')->name('status');
    });

    // Driver Manager
    Route::controller('ManageDriversController')->name('driver.')->prefix('drivers')->group(function () {
        Route::get('/', 'allDrivers')->name('all');
        Route::get('active', 'activeDrivers')->name('active');
        Route::get('banned', 'bannedDrivers')->name('banned');
        Route::get('email-verified', 'emailVerifiedDrivers')->name('email.verified');
        Route::get('email-unverified', 'emailUnverifiedDrivers')->name('email.unverified');
        Route::get('mobile-unverified', 'mobileUnverifiedDrivers')->name('mobile.unverified');
        Route::get('unverified', 'unverifiedDrivers')->name('unverified');
        Route::get('verify-pending', 'verifyPendingDrivers')->name('verify.pending');


        Route::get('vehicle-unverified', 'vehicleUnverifiedDrivers')->name('vehicle.unverified');
        Route::get('vehicle-verify-pending', 'vehiclePendingDrivers')->name('vehicle.verify.pending');

        Route::get('mobile-verified', 'mobileVerifiedDrivers')->name('mobile.verified');

        Route::get('detail/{id}', 'detail')->name('detail');
        Route::get('verification/details/{id}', 'verificationDetails')->name('verification.details');
        Route::post('verification-approve/{id}', 'verificationApprove')->name('verification.approve');
        Route::post('verification-reject/{id}', 'verificationReject')->name('verification.reject');
        Route::post('vehicle-approve/{id}', 'vehicleApprove')->name('vehicle.approve');
        Route::post('vehicle-reject/{id}', 'vehicleReject')->name('vehicle.reject');
        Route::get('rides/rules/{id}', 'rideRules')->name('rides.rules');

        Route::post('update/{id}', 'update')->name('update');
        Route::post('add-sub-balance/{id}', 'addSubBalance')->name('add.sub.balance');
        Route::get('send-notification/{id}', 'showNotificationSingleForm')->name('notification.single');
        Route::post('send-notification/{id}', 'sendNotificationSingle')->name('notification.single');
        Route::post('status/{id}', 'status')->name('status');
        Route::post('account/delete/{id}', 'deleteAccount')->name('delete.account');

        Route::get('send-notification', 'showNotificationAllForm')->name('notification.all');
        Route::post('send-notification', 'sendNotificationAll')->name('notification.all.send');
        Route::get('list', 'list')->name('list');
        Route::get('count-by-segment/{methodName}', 'countBySegment')->name('segment.count');
        Route::get('notification-log/{id}', 'notificationLog')->name('notification.log');
    });

    // Subscriber
    Route::controller('SubscriberController')->prefix('subscriber')->name('subscriber.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('send-email', 'sendEmailForm')->name('send.email');
        Route::post('remove/{id}', 'remove')->name('remove');
        Route::post('send-email', 'sendEmail')->name('send.email');
    });

    // Report
    Route::controller('ReportController')->name('report.')->prefix('report')->group(function () {
        Route::prefix('rider')->name('rider.')->group(function () {
            Route::get('rider-payment', 'riderPayment')->name('payment');
            Route::get('login/history', 'loginHistory')->name('login.history');
            Route::get('login/ipHistory/{ip}', 'loginIpHistory')->name('login.ipHistory');
            Route::get('notification/history', 'notificationHistory')->name('notification.history');
            Route::get('email/detail/{id}', 'emailDetails')->name('email.details');
        });
        Route::prefix('driver')->name('driver.')->group(function () {
            Route::get('transaction', 'transaction')->name('transaction');
            Route::get('commission', 'commission')->name('commission');
            Route::get('login/history', 'loginHistoryDriver')->name('login.history');
            Route::get('login/ipHistory/{ip}', 'loginIpHistory')->name('login.ipHistory');
            Route::get('notification/history', 'notificationHistoryDriver')->name('notification.history');
            Route::get('email/detail/{id}', 'emailDetails')->name('email.details');
        });
    });

    // Admin Support
    Route::controller('SupportTicketController')->prefix('ticket')->name('ticket.')->group(function () {
        Route::get('/', 'tickets')->name('index');
        Route::get('pending', 'pendingTicket')->name('pending');
        Route::get('closed', 'closedTicket')->name('closed');
        Route::get('answered', 'answeredTicket')->name('answered');
        Route::get('view/{id}', 'ticketReply')->name('view');
        Route::post('reply/{id}', 'replyTicket')->name('reply');
        Route::post('close/{id}', 'closeTicket')->name('close');
        Route::get('download/{attachment_id}', 'ticketDownload')->name('download');
        Route::post('delete/{id}', 'ticketDelete')->name('delete');
    });


    Route::controller('AdminController')->group(function () {
        Route::get('dashboard', 'dashboard')->name('dashboard');
        Route::get('chart/deposit-withdraw', 'depositAndWithdrawReport')->name('chart.deposit.withdraw');
        Route::get('chart/transaction', 'transactionReport')->name('chart.transaction');
        Route::get('profile', 'profile')->name('profile');
        Route::post('profile', 'profileUpdate')->name('profile.update');
        Route::get('password', 'password')->name('password');
        Route::post('password', 'passwordUpdate')->name('password.update');

        //Notification
        Route::get('notifications', 'notifications')->name('notifications');
        Route::get('notification/read/{id}', 'notificationRead')->name('notification.read');
        Route::get('notifications/read-all', 'readAllNotification')->name('notifications.read.all');
        Route::post('notifications/delete-all', 'deleteAllNotification')->name('notifications.delete.all');
        Route::post('notifications/delete-single/{id}', 'deleteSingleNotification')->name('notifications.delete.single');

        //Report Bugs

        Route::get('download-attachments/{file_hash}', 'downloadAttachment')->name('download.attachment');
        Route::get('send/promotional-notification', 'showPromotionalNotificationForm')->name('promotional.notification.all');
        Route::post('send-promotional-notification', 'sendPromotionalNotificationAll')->name('promotional.notification.all.send');
    });

    // extensions
    Route::controller('ExtensionController')->prefix('extensions')->name('extensions.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('update/{id}', 'update')->name('update');
        Route::post('status/{id}', 'status')->name('status');
    });

    // Language Manager
    Route::controller('LanguageController')->prefix('language')->name('language.')->group(function () {
        Route::get('/', 'langManage')->name('manage');
        Route::post('/', 'langStore')->name('manage.store');
        Route::post('delete/{id}', 'langDelete')->name('manage.delete');
        Route::post('update/{id}', 'langUpdate')->name('manage.update');
        Route::get('edit/{id}', 'langEdit')->name('key');
        Route::post('import', 'langImport')->name('import.lang');
        Route::post('store/key/{id}', 'storeLanguageJson')->name('store.key');
        Route::post('delete/key/{id}/{key}', 'deleteLanguageJson')->name('delete.key');
        Route::post('update/key/{id}', 'updateLanguageJson')->name('update.key');
        Route::get('get-keys', 'getKeys')->name('get.key');
    });


    //Notification Setting
    Route::name('setting.notification.')->controller('NotificationController')->prefix('notification')->group(function () {
        //Template Setting
        Route::get('global/email', 'globalEmail')->name('global.email');
        Route::post('global/email/update', 'globalEmailUpdate')->name('global.email.update');

        Route::get('global/sms', 'globalSms')->name('global.sms');
        Route::post('global/sms/update', 'globalSmsUpdate')->name('global.sms.update');

        Route::get('global/push', 'globalPush')->name('global.push');
        Route::post('global/push/update', 'globalPushUpdate')->name('global.push.update');

        Route::get('templates', 'templates')->name('templates');
        Route::get('template/edit/{type}/{id}', 'templateEdit')->name('template.edit');
        Route::post('template/update/{type}/{id}', 'templateUpdate')->name('template.update');

        //Email Setting
        Route::get('email/setting', 'emailSetting')->name('email');
        Route::post('email/setting', 'emailSettingUpdate');
        Route::post('email/test', 'emailTest')->name('email.test');

        //SMS Setting
        Route::get('sms/setting', 'smsSetting')->name('sms');
        Route::post('sms/setting', 'smsSettingUpdate');
        Route::post('sms/test', 'smsTest')->name('sms.test');

        Route::get('notification/push/setting', 'pushSetting')->name('push');
        Route::post('notification/push/setting', 'pushSettingUpdate');
        Route::post('notification/push/setting/upload', 'pushSettingUpload')->name('push.upload');
        Route::get('notification/push/setting/download', 'pushSettingDownload')->name('push.download');
    });

    //KYC setting
    Route::controller('KycController')->group(function () {
        Route::get('driver-verification', 'driverVerification')->name('verification.driver.form');
        Route::post('driver-verification', 'driverVerificationUpdate')->name('verification.driver.update');

        Route::get('vehicle-verification', 'vehicleVerification')->name('vehicle.verification.form');
        Route::post('vehicle-verification', 'vehicleVerificationUpdate')->name('vehicle.verification.update');
    });

    // DEPOSIT SYSTEM
    Route::controller('DepositController')->prefix('deposit')->name('deposit.')->group(function () {
        Route::get('all', 'deposit')->name('list');
        Route::get('pending', 'pending')->name('pending');
        Route::get('rejected', 'rejected')->name('rejected');
        Route::get('approved', 'approved')->name('approved');
        Route::get('successful', 'successful')->name('successful');
        Route::get('initiated', 'initiated')->name('initiated');
        Route::get('details/{id}', 'details')->name('details');
        Route::post('reject', 'reject')->name('reject');
        Route::post('approve/{id}', 'approve')->name('approve');
    });


    // WITHDRAW SYSTEM
    Route::name('withdraw.')->prefix('withdraw')->group(function () {

        Route::controller('WithdrawalController')->name('data.')->group(function () {
            Route::get('pending/{user_id?}', 'pending')->name('pending');
            Route::get('approved/{user_id?}', 'approved')->name('approved');
            Route::get('rejected/{user_id?}', 'rejected')->name('rejected');
            Route::get('all/{user_id?}', 'all')->name('all');
            Route::get('details/{id}', 'details')->name('details');
            Route::post('approve', 'approve')->name('approve');
            Route::post('reject', 'reject')->name('reject');
        });


        // Withdraw Method
        Route::controller('WithdrawMethodController')->prefix('method')->name('method.')->group(function () {
            Route::get('/', 'methods')->name('index');
            Route::get('create', 'create')->name('create');
            Route::post('create', 'store')->name('store');
            Route::get('edit/{id}', 'edit')->name('edit');
            Route::post('edit/{id}', 'update')->name('update');
            Route::post('status/{id}', 'status')->name('status');
        });
    });

    // SEO
    Route::get('seo', 'FrontendController@seoEdit')->name('seo');

    // Frontend
    Route::name('frontend.')->prefix('frontend')->group(function () {

        Route::controller('FrontendController')->group(function () {
            Route::get('index', 'index')->name('index');
            Route::get('templates', 'templates')->name('templates');
            Route::post('templates', 'templatesActive')->name('templates.active');
            Route::get('frontend-sections/{key?}', 'frontendSections')->name('sections');
            Route::post('frontend-content/{key}', 'frontendContent')->name('sections.content');
            Route::get('frontend-element/{key}/{id?}', 'frontendElement')->name('sections.element');
            Route::get('frontend-slug-check/{key}/{id?}', 'frontendElementSlugCheck')->name('sections.element.slug.check');
            Route::get('frontend-element-seo/{key}/{id}', 'frontendSeo')->name('sections.element.seo');
            Route::post('frontend-element-seo/{key}/{id}', 'frontendSeoUpdate');
            Route::post('remove/{id}', 'remove')->name('remove');
        });

        // Page Builder
        Route::controller('PageBuilderController')->group(function () {
            Route::get('manage-pages', 'managePages')->name('manage.pages');
            Route::get('manage-pages/check-slug/{id?}', 'checkSlug')->name('manage.pages.check.slug');
            Route::post('manage-pages', 'managePagesSave')->name('manage.pages.save');
            Route::post('manage-pages/update', 'managePagesUpdate')->name('manage.pages.update');
            Route::post('manage-pages/delete/{id}', 'managePagesDelete')->name('manage.pages.delete');
            Route::get('manage-section/{id}', 'manageSection')->name('manage.section');
            Route::post('manage-section/{id}', 'manageSectionUpdate')->name('manage.section.update');

            Route::get('manage-seo/{id}', 'manageSeo')->name('manage.pages.seo');
            Route::post('manage-seo/{id}', 'manageSeoStore');
        });
    });

    //System Information
    Route::controller('SystemController')->name('system.')->prefix('system')->group(function () {
        Route::get('info', 'systemInfo')->name('info');
        Route::get('optimize-clear', 'optimizeClear')->name('optimize.clear');
    });


    Route::controller('GeneralSettingController')->group(function () {


        // General Setting
        Route::get('general-setting', 'general')->name('setting.general');
        Route::post('general-setting', 'generalUpdate');


        //configuration
        Route::get('setting/system-configuration', 'systemConfiguration')->name('setting.system.configuration');
        Route::get('setting/system-configuration/{key}', 'systemConfigurationUpdate')->name("setting.system.configuration.update");

        // Logo-Icon
        Route::get('setting/brand', 'logoIcon')->name('setting.brand');
        Route::post('setting/brand', 'logoIconUpdate')->name('setting.brand');

        //Custom CSS
        Route::get('custom-css', 'customCss')->name('setting.custom.css');
        Route::post('custom-css', 'customCssSubmit');

        Route::get('sitemap', 'sitemap')->name('setting.sitemap');
        Route::post('sitemap', 'sitemapSubmit');

        Route::get('robot', 'robot')->name('setting.robot');
        Route::post('robot', 'robotSubmit');

        //Cookie
        Route::get('cookie', 'cookie')->name('setting.cookie');
        Route::post('cookie', 'cookieSubmit');

        //maintenance_mode
        Route::get('maintenance-mode', 'maintenanceMode')->name('maintenance.mode');
        Route::post('maintenance-mode', 'maintenanceModeSubmit');
    });
    // Deposit Gateway
    Route::name('gateway.')->prefix('gateway')->group(function () {

        // Manual Methods
        Route::controller('ManualGatewayController')->prefix('manual')->name('manual.')->group(function () {
            Route::get('new', 'create')->name('create');
            Route::post('new', 'store')->name('store');
            Route::get('edit/{alias}', 'edit')->name('edit');
            Route::post('update/{id}', 'update')->name('update');
            Route::post('status/{id}', 'status')->name('status');
        });

        // Automatic Gateway
        Route::controller('AutomaticGatewayController')->name('automatic.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('edit/{alias}', 'edit')->name('edit');
            Route::post('update/{code}', 'update')->name('update');
            Route::post('remove/{id}', 'remove')->name('remove');
            Route::post('status/{id}', 'status')->name('status');
        });
    });



    //cron
    Route::controller('CronConfigurationController')->name('cron.')->prefix('cron')->group(function () {
        Route::get('index', 'cronJobs')->name('index');
        Route::post('store', 'cronJobStore')->name('store');
        Route::post('update/{id}', 'cronJobUpdate')->name('update');
        Route::post('delete/{id}', 'cronJobDelete')->name('delete');
        Route::get('schedule', 'schedule')->name('schedule');
        Route::post('schedule/store/{id?}', 'scheduleStore')->name('schedule.store');
        Route::post('schedule/status/{id}', 'scheduleStatus')->name('schedule.status');
        Route::get('schedule/pause/{id}', 'schedulePause')->name('schedule.pause');
        Route::get('schedule/logs/{id}', 'scheduleLogs')->name('schedule.logs');
        Route::post('schedule/log/resolved/{id}', 'scheduleLogResolved')->name('schedule.log.resolved');
        Route::post('schedule/log/flush/{id}', 'logFlush')->name('log.flush');
    });
});
