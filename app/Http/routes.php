<?php

/**
 * Authentication
*/

Route::get('login', 'Auth\AuthController@getLogin');
Route::post('login', 'Auth\AuthController@postLogin');

Route::get('logout', [
		'as' => 'auth.logout',
		'uses' => 'Auth\AuthController@getLogout'
]);

// Allow registration routes only if registration is enabled.
if (settings('reg_enabled')) {
	Route::get('register', 'Auth\AuthController@getRegister');
	Route::post('register', 'Auth\AuthController@postRegister');
	Route::get('register/confirmation/{token}', [
			'as' => 'register.confirm-email',
			'uses' => 'Auth\AuthController@confirmEmail'
	]);
}

// Register password reset routes only if it is enabled inside website settings.
if (settings('forgot_password')) {
	Route::get('password/remind', 'Auth\PasswordController@forgotPassword');
	Route::post('password/remind', 'Auth\PasswordController@sendPasswordReminder');
	Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
	Route::post('password/reset', 'Auth\PasswordController@postReset');
}

/**
 * Two-Factor Authentication
 */
if (settings('2fa.enabled')) {
	Route::get('auth/two-factor-authentication', [
			'as' => 'auth.token',
			'uses' => 'Auth\AuthController@getToken'
	]);

	Route::post('auth/two-factor-authentication', [
			'as' => 'auth.token.validate',
			'uses' => 'Auth\AuthController@postToken'
	]);
}

/**
 * Social Login
 */
//Route::get('auth/{provider}/login', [
//    'as' => 'social.login',
//    'uses' => 'Auth\SocialAuthController@redirectToProvider',
//   'middleware' => 'social.login'
//]);

//Route::get('auth/{provider}/callback', 'Auth\SocialAuthController@handleProviderCallback');

//Route::get('auth/twitter/email', 'Auth\SocialAuthController@getTwitterEmail');
//Route::post('auth/twitter/email', 'Auth\SocialAuthController@postTwitterEmail');

/**
 * Other
 */

Route::get('/', [
		'as' => 'dashboard',
		'uses' => 'DashboardController@index'
]);

/**
 * User Profile
 */

Route::get('profile', [
		'as' => 'profile',
		'uses' => 'ProfileController@index'
]);

Route::get('profile/activity', [
		'as' => 'profile.activity',
		'uses' => 'ProfileController@activity'
]);

Route::put('profile/details/update', [
		'as' => 'profile.update.details',
		'uses' => 'ProfileController@updateDetails'
]);

Route::post('profile/avatar/update', [
		'as' => 'profile.update.avatar',
		'uses' => 'ProfileController@updateAvatar'
]);

Route::post('profile/avatar/update/external', [
		'as' => 'profile.update.avatar-external',
		'uses' => 'ProfileController@updateAvatarExternal'
]);

Route::put('profile/login-details/update', [
		'as' => 'profile.update.login-details',
		'uses' => 'ProfileController@updateLoginDetails'
]);

Route::put('profile/social-networks/update', [
		'as' => 'profile.update.social-networks',
		'uses' => 'ProfileController@updateSocialNetworks'
]);

Route::post('profile/two-factor/enable', [
		'as' => 'profile.two-factor.enable',
		'uses' => 'ProfileController@enableTwoFactorAuth'
]);

Route::post('profile/two-factor/disable', [
		'as' => 'profile.two-factor.disable',
		'uses' => 'ProfileController@disableTwoFactorAuth'
]);

Route::get('profile/sessions', [
		'as' => 'profile.sessions',
		'uses' => 'ProfileController@sessions'
]);

Route::delete('profile/sessions/{session}/invalidate', [
		'as' => 'profile.sessions.invalidate',
		'uses' => 'ProfileController@invalidateSession'
]);

/**
 * User Management
 */
Route::get('user', [
		'as' => 'user.list',
		'uses' => 'UsersController@index'
]);

Route::get('user/create', [
		'as' => 'user.create',
		'uses' => 'UsersController@create'
]);

Route::post('user/create', [
		'as' => 'user.store',
		'uses' => 'UsersController@store'
]);

Route::get('user/{user}/show', [
		'as' => 'user.show',
		'uses' => 'UsersController@view'
]);

Route::get('user/{user}/edit', [
		'as' => 'user.edit',
		'uses' => 'UsersController@edit'
]);

Route::put('user/{user}/update/details', [
		'as' => 'user.update.details',
		'uses' => 'UsersController@updateDetails'
]);

Route::put('user/{user}/update/login-details', [
		'as' => 'user.update.login-details',
		'uses' => 'UsersController@updateLoginDetails'
]);

Route::delete('user/{user}/delete', [
		'as' => 'user.delete',
		'uses' => 'UsersController@delete'
]);

Route::post('user/{user}/update/avatar', [
		'as' => 'user.update.avatar',
		'uses' => 'UsersController@updateAvatar'
]);

Route::post('user/{user}/update/avatar/external', [
		'as' => 'user.update.avatar.external',
		'uses' => 'UsersController@updateAvatarExternal'
]);

Route::post('user/{user}/update/social-networks', [
		'as' => 'user.update.socials',
		'uses' => 'UsersController@updateSocialNetworks'
]);

Route::get('user/{user}/sessions', [
		'as' => 'user.sessions',
		'uses' => 'UsersController@sessions'
]);

Route::delete('user/{user}/sessions/{session}/invalidate', [
		'as' => 'user.sessions.invalidate',
		'uses' => 'UsersController@invalidateSession'
]);

Route::post('user/{user}/two-factor/enable', [
		'as' => 'user.two-factor.enable',
		'uses' => 'UsersController@enableTwoFactorAuth'
]);

Route::post('user/{user}/two-factor/disable', [
		'as' => 'user.two-factor.disable',
		'uses' => 'UsersController@disableTwoFactorAuth'
]);

/**
 * Roles & Permissions
 */

Route::get('role', [
		'as' => 'role.index',
		'uses' => 'RolesController@index'
]);

Route::get('role/create', [
		'as' => 'role.create',
		'uses' => 'RolesController@create'
]);

Route::post('role/store', [
		'as' => 'role.store',
		'uses' => 'RolesController@store'
]);

Route::get('role/{role}/edit', [
		'as' => 'role.edit',
		'uses' => 'RolesController@edit'
]);

Route::put('role/{role}/update', [
		'as' => 'role.update',
		'uses' => 'RolesController@update'
]);

Route::delete('role/{role}/delete', [
		'as' => 'role.delete',
		'uses' => 'RolesController@delete'
]);


Route::post('permission/save', [
		'as' => 'permission.save',
		'uses' => 'PermissionsController@saveRolePermissions'
]);

Route::resource('permission', 'PermissionsController');

/**
 * Settings
 */

Route::get('settings', [
		'as' => 'settings.general',
		'uses' => 'SettingsController@general',
		'middleware' => 'permission:settings.general'
]);

Route::post('settings/general', [
		'as' => 'settings.general.update',
		'uses' => 'SettingsController@update',
		'middleware' => 'permission:settings.general'
]);

Route::get('settings/auth', [
		'as' => 'settings.auth',
		'uses' => 'SettingsController@auth',
		'middleware' => 'permission:settings.auth'
]);

Route::post('settings/auth', [
		'as' => 'settings.auth.update',
		'uses' => 'SettingsController@update',
		'middleware' => 'permission:settings.auth'
]);

// Only allow managing 2FA if AUTHY_KEY is defined inside .env file
if (env('AUTHY_KEY')) {
	Route::post('settings/auth/2fa/enable', [
			'as' => 'settings.auth.2fa.enable',
			'uses' => 'SettingsController@enableTwoFactor',
			'middleware' => 'permission:settings.auth'
	]);

	Route::post('settings/auth/2fa/disable', [
			'as' => 'settings.auth.2fa.disable',
			'uses' => 'SettingsController@disableTwoFactor',
			'middleware' => 'permission:settings.auth'
	]);
}

Route::post('settings/auth/registration/captcha/enable', [
		'as' => 'settings.registration.captcha.enable',
		'uses' => 'SettingsController@enableCaptcha',
		'middleware' => 'permission:settings.auth'
]);

Route::post('settings/auth/registration/captcha/disable', [
		'as' => 'settings.registration.captcha.disable',
		'uses' => 'SettingsController@disableCaptcha',
		'middleware' => 'permission:settings.auth'
]);

Route::get('settings/notifications', [
		'as' => 'settings.notifications',
		'uses' => 'SettingsController@notifications',
		'middleware' => 'permission:settings.notifications'
]);

Route::post('settings/notifications', [
		'as' => 'settings.notifications.update',
		'uses' => 'SettingsController@update',
		'middleware' => 'permission:settings.notifications'
]);

/**
 * Activity Log
 */

Route::get('activity', [
		'as' => 'activity.index',
		'uses' => 'ActivityController@index'
]);

Route::get('activity/user/{user}/log', [
		'as' => 'activity.user',
		'uses' => 'ActivityController@userActivity'
]);

/**
 * Installation
 */

$router->get('install', [
		'as' => 'install.start',
		'uses' => 'InstallController@index'
]);

$router->get('install/requirements', [
		'as' => 'install.requirements',
		'uses' => 'InstallController@requirements'
]);

$router->get('install/permissions', [
		'as' => 'install.permissions',
		'uses' => 'InstallController@permissions'
]);

$router->get('install/database', [
		'as' => 'install.database',
		'uses' => 'InstallController@databaseInfo'
]);

$router->get('install/start-installation', [
		'as' => 'install.installation',
		'uses' => 'InstallController@installation'
]);

$router->post('install/start-installation', [
		'as' => 'install.installation',
		'uses' => 'InstallController@installation'
]);

$router->post('install/install-app', [
		'as' => 'install.install',
		'uses' => 'InstallController@install'
]);

$router->get('install/complete', [
		'as' => 'install.complete',
		'uses' => 'InstallController@complete'
]);

$router->get('install/error', [
		'as' => 'install.error',
		'uses' => 'InstallController@error'
]);

/**
 * Manage Projects
 */

Route::get('project', [
		'as' => 'project.list',
		'uses' => 'ProjectsController@index'
]);

Route::get('project/create', [
		'as' => 'project.create',
		'uses' => 'ProjectsController@create'
]);

Route::post('project/store', [
		'as' => 'project.store',
		'uses' => 'ProjectsController@store'
]);

Route::get('project/{project}/edit', [
		'as' => 'project.edit',
		'uses' => 'ProjectsController@edit'
]);

 Route::get('project/download/{filename}', function($filename)
 {
 	// Check if file exists in app/storage/file folder
 	$file_path = public_path() .'/upload/'. $filename;
 	if (file_exists($file_path))
 	{
 		// Send Download
 		return Response::download($file_path, $filename, [
 				'Content-Length: '. filesize($file_path)
 		]);
 	}
 	else
 	{
 		// Error
 		exit('Requested file does not exist on our server!');
 	}
 });

Route::put('project/{project}/update', [
		'as' => 'project.update',
		'uses' => 'ProjectsController@update'
]);

Route::delete('project/{project}/delete', [
		'as' => 'project.delete',
		'uses' => 'ProjectsController@delete'
]);


/**
 * Manage Vendors
 */

Route::get('vendors', [
		'as' => 'vendor.list',
		'uses' => 'VendorsController@index'
]);

Route::get('vendors/create', [
		'as' => 'vendor.create',
		'uses' => 'VendorsController@create'
]);

Route::post('vendors/store', [
		'as' => 'vendor.store',
		'uses' => 'VendorsController@store'
]);

Route::get('vendors/{vendor}/edit', [
		'as' => 'vendor.edit',
		'uses' => 'VendorsController@edit'
]);

Route::put('vendors/{vendor}/update', [
		'as' => 'vendor.update',
		'uses' => 'VendorsController@update'
]);

Route::delete('vendors/{vendor}/delete', [
		'as' => 'vendor.delete',
		'uses' => 'VendorsController@delete'
]);


/**
 * Manage Batches
 */

Route::get('batch', [
		'as' => 'batch.list',
		'uses' => 'BatchesController@index'
]);

Route::get('batch/create', [
		'as' => 'batch.create',
		'uses' => 'BatchesController@create'
]);

Route::post('batch/store', [
		'as' => 'batch.store',
		'uses' => 'BatchesController@store'
]);

Route::get('batch/{batch}/edit', [
		'as' => 'batch.edit',
		'uses' => 'BatchesController@edit'
]);

Route::put('batch/{batch}/update', [
		'as' => 'batch.update',
		'uses' => 'BatchesController@update'
]);

Route::delete('batch/{batch}/delete', [
		'as' => 'batch.delete',
		'uses' => 'BatchesController@delete'
]);

Route::get('batch/{batch}/download',[
		'as'=>'batch.download',
		'uses'=>'BatchesController@download'
]);

Route::get('batch/getbatchName',[
		'as'=>'batch.getbatchName',
		'uses'=>'BatchesController@getbatchName'
]);



/**
 * Manage SubBatches
 */

Route::get('subBatch', [
		'as' => 'subBatch.list',
		'uses' => 'SubBatchesController@index'
]);

Route::get('subBatch/getCompanyCount', [
		'as' => 'subBatch.getCompanyCount',
		'uses' => 'SubBatchesController@getCompanyCount'
]);

Route::get('subBatch/create', [
		'as' => 'subBatch.create',
		'uses' => 'SubBatchesController@create'
]);

Route::post('subBatch/store', [
		'as' => 'subBatch.store',
		'uses' => 'SubBatchesController@store'
]);

Route::get('subBatch/{subBatch}/edit', [
		'as' => 'subBatch.edit',
		'uses' => 'SubBatchesController@edit'
]);

Route::put('subBatch/{subBatch}/update', [
		'as' => 'subBatch.update',
		'uses' => 'SubBatchesController@update'
]);

Route::delete('subBatch/{subBatch}/delete', [
		'as' => 'subBatch.delete',
		'uses' => 'SubBatchesController@delete'
]);
/**
 * Manage Companys
 */

Route::get('companys', [
		'as' => 'company.list',
		'uses' => 'CompanysController@index'
]);

Route::get('companys/create', [
		'as' => 'company.create',
		'uses' => 'CompanysController@create'
]);

Route::post('companys/store', [
		'as' => 'company.store',
		'uses' => 'CompanysController@store'
]);

Route::get('companys/{company}/edit', [
		'as' => 'company.edit',
		'uses' => 'CompanysController@edit'
]);

Route::put('companys/{company}/update', [
		'as' => 'company.update',
		'uses' => 'CompanysController@update'
]);

Route::delete('companys/{company}/delete', [
		'as' => 'company.delete',
		'uses' => 'CompanysController@delete'
]);

Route::get('dataCapture', [
		'as' => 'dataCapture.list',
		'uses' => 'DataCaptureController@subBatchList'
]);

Route::get('dataCapture/{subBatchId}/capture', [
		'as' => 'dataCapture.capture',
		'uses' => 'DataCaptureController@capture'
]);

Route::put('dataCapture/{company}/updateCompany', [
		'as' => 'dataCapture.updateCompany',
		'uses' => 'DataCaptureController@updateCompany'
]);

Route::put('dataCapture/{company}/storeCompany', [
		'as' => 'dataCapture.storeCompany',
		'uses' => 'DataCaptureController@storeCompany'
]);

Route::put('dataCapture/{company}/storeStaff', [
		'as' => 'dataCapture.storeStaff',
		'uses' => 'DataCaptureController@storeStaff'
]);


Route::get('dataCapture/{company}/submitCompany', [
		'as' => 'dataCapture.submitCompany',
		'uses' => 'DataCaptureController@submitCompany'
]);

Route::post('dataCapture/{contact}/updateStaff', [
		'as' => 'dataCapture.updateStaff',
		'uses' => 'DataCaptureController@updateStaff'
]);

Route::get('dataCapture/create', [
		'as' => 'dataCapture.create',
		'uses' => 'DataCaptureController@create'
]);
//----------------------------------------------------------
Route::get('dataCapture/getContact', [
		'as' => 'dataCapture.getContact',
		'uses' => 'DataCaptureController@getContact'
]);

Route::get('dataCapture/{companyId}/createContact', [
		'as' => 'dataCapture.createContact',
		'uses' => 'DataCaptureController@createContact'
]);

Route::put('dataCapture/{companyId}/addCompany', [
		'as' => 'dataCapture.addCompany',
		'uses' => 'DataCaptureController@addCompany'
]);
Route::get('dataCapture/{country}/getcountryCode',[
		'as'=>'dataCapture.getcountryCode',
		'uses'=>'DataCaptureController@getcountryCode'
]);
Route::get('dataCapture/getcountryCode',[
		'as'=>'dataCapture.getcountryCode',
		'uses'=>'DataCaptureController@getcountryCode'
]);
Route::get('dataCapture/{country}/getcountryCode',[
		'as'=>'dataCapture.getcountryCode',
		'uses'=>'DataCaptureController@getcountryCode'
]);

Route::get('dataCapture/{company}/getChildren',[
		'as' => 'dataCapture.getChildren',
		'uses' => 'DataCaptureController@getChildren'
]);

Route::get('dataCapture/{company}/currentCompany', [
		'as' => 'dataCapture.currentCompany',
		'uses' => 'DataCaptureController@currentCompany'
]);

Route::get('dataCapture/{company}/cancelCompany', [
		'as' => 'dataCapture.cancelCompany',
		'uses' => 'DataCaptureController@cancelCompany'
]);

Route::get('dataCapture/getduplicateRecord',[
		'as'=>'dataCapture.getduplicateRecord',
		'uses'=>'DataCaptureController@getduplicateRecord'
]);

Route::get('report',[
		'as'=>'report.list',
		'uses'=>'ReportsController@index'
]);

Route::post('report/getData',[
		'as'=>'report.getData',
		'uses'=>'ReportsController@getData'
]);

Route::get('productivity',[
		'as'=>'productivity',
		'uses'=>'ReportsController@productivityList'
]);

Route::get('report/getProductivityReport',[
		'as'=>'report.getProductivityReport',
		'uses'=>'ReportsController@getProductivityReport'
]);

Route::get('report/myProductivity',[
		'as'=>'report.myProductivity',
		'uses'=>'MyReportController@myProductivityList'
]);

Route::post('report/searchReportList',[
		'as'=>'report.searchReportList',
		'uses'=>'MyReportController@searchReportList'
]);

Route::get('dataCapture/{subBatchId}/starttimecapture',[
		'as' =>'dataCapture.starttimecapture',
		'uses'=>'DataCaptureController@starttimecapture'
]);

Route::get('dataCapture/{subBatchId}/stoptimecapture',[
		'as' =>'dataCapture.stoptimecapture',
		'uses'=>'DataCaptureController@stoptimecapture'
]);

Route::delete('dataCapture/{contact}/delete', [
		'as' => 'dataCapture.delete',
		'uses' => 'DataCaptureController@delete'
]);

Route::delete('dataCapture/{company}/subsidiaryCompany', [
		'as' => 'dataCapture.subsidiaryCompany',
		'uses' => 'DataCaptureController@subsidiaryCompany'
]);

Route::get('quality/create',[
		'as' => 'quality.create',
		'uses' => 'QualityController@create'
]);

Route::post('quality/store',[
		'as' => 'quality.store',
		'uses' => 'QualityController@store'
]);

Route::get('quality/list',[
		'as' => 'quality.list',
		'uses' => 'QualityController@list'
]);

Route::get('quality/optionlist',[
		'as' => 'quality.optionlist',
		'uses' => 'QualityController@optionlist'
]);

Route::post('quality/download',[
		'as' => 'quality.download',
		'uses'=> 'QualityController@download'
]);

Route::get('reallocation',[
		'as' => 'reallocation',
		'uses' => 'ReallocationController@reallocation',
]);

Route::post('batches/reassign',[
		'as' => 'batches.reassign',
		'uses' => 'ReallocationController@reassign'
]);

Route::get('record',[
		'as' => 'index',
		'uses' => 'RecordController@index'
]);

Route::post('record/data',[
		'as' => 'record.data',
		'uses' => 'RecordController@info'
]);

Route::get('dataCapture/getSubsidaryCompany', [
		'as' => 'dataCapture.getSubsidaryCompany',
		'uses' => 'DataCaptureController@getSubsidaryCompany'
]);

Route::get('dataCapture/moveContact',[
		'as' => 'dataCapture.moveContact',
		'uses' => 'DataCaptureController@moveContact'
]);

Route::get('dataCapture/{contact}/delete',[
		'as' => 'dataCapture.moveContactToParent',
		'uses' => 'DataCaptureController@moveContactToParent'
]);

Route::post('batch/reassigntouser',[
		'as' => 'batches.reassigntouser',
		'uses' => 'ReallocationController@reassigntouser'
]);