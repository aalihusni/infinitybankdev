<?php
Route::group(['prefix' => 'api','middleware' => 'VerifyAccessKey'], function() {
	//header('Access-Control-Allow-Origin: *');
	//header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
	//header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with');
	Route::get('/OcCart/Passport',['uses'=>'External\PassportApiController@index']);
});

//Route::get('/ecommerce/passport',['uses'=>'External\PassportApiController@index']); FOR TEST

Route::get('/set-locale', ['as' => 'set-locale', 'uses' => 'LanguangeController@set_locale',]);

Route::get('/marketing-plan', ['as' => 'marketing-plan', 'uses' => 'WebsiteViewController@marketing_plan',]);

/*
|--------------------------------------------------------------------------
| Mobile Apss Auth (apps)
|--------------------------------------------------------------------------
*/

Route::get('/storeDeviceID', 'AppsController@storeDeviceID');
Route::get('/loginFromDevice/{id}', 'AppsController@device_login');


/*
|--------------------------------------------------------------------------
| Primary Website (website)
|--------------------------------------------------------------------------
*/

Route::get('/', ['as' => 'index', 'uses' => 'WebsiteViewController@index',]);
Route::get('/infographic', ['as' => 'infographic', 'uses' => 'WebsiteViewController@infographic',]);
Route::get('/bitcoin-wallet', ['as' => 'bitcoinwallet', 'uses' => 'WebsiteViewController@bitcoin_wallet',]);
Route::get('/buy-sell-bitcoin', ['as' => 'buy-sell-bitcoin', 'uses' => 'WebsiteViewController@buy_sell_bitcoin',]);
Route::get('/contact-us', ['as' => 'contact-us', 'uses' => 'WebsiteViewController@contact_us',]);
Route::post('/submit_message', ['as' => 'submit-message', 'uses' => 'WebsiteController@submit_message',]);
Route::get('/leader-form', ['as' => 'leader-request-from', 'uses' => 'WebsiteViewController@leader_request',]);
Route::post('/leadership/post', ['as' => 'post-leader-request-from', 'uses' => 'WebsiteController@postLeadership',]);




/*
|--------------------------------------------------------------------------
| Default Auth Pages (auth)
|--------------------------------------------------------------------------
*/

Route::get('/login', ['as' => 'login', 'uses' => 'UserViewController@login',]);
Route::post('/login', ['as' => 'login', 'uses' => 'UserController@login',]);

Route::get('/login-2fa', ['as' => 'login-2fa', 'uses' => 'UserViewController@login_2fa',]);
Route::post('/login-2fa', ['as' => 'login-2fa', 'uses' => 'UserController@login_2fa',]);

Route::get('/signup', ['as' => 'signup', 'uses' => 'UserViewController@signup',]);
Route::get('/signup/{referral}', ['as' => 'signupref', 'uses' => 'UserViewController@signup',]);
Route::post('/signup', ['as' => 'signup', 'uses' => 'UserController@signup',]);

Route::get('/verify-email', ['as' => 'verify-email', 'uses' => 'UserViewController@verify_email',]);
Route::get('/resend-verify-email', ['as' => 'resend-verify-email', 'uses' => 'UserController@resend_verify_email',]);

Route::get('/verify/{code}', ['as' => 'do-verify-email', 'uses' => 'UserController@do_verify_email',]);

Route::get('/forgot-password', ['as' => 'forgot-password', 'uses' => 'UserViewController@forgot_password',]);
Route::post('/password-reset-request', ['as' => 'password-reset-request', 'uses' => 'UserController@password_reset_request',]);
Route::get('/password-reset', ['as' => 'password-reset', 'uses' => 'UserViewController@password_reset',]);
Route::post('/password-reset', ['as' => 'password-reset', 'uses' => 'UserController@password_reset',]);

Route::get('/logout', ['as' => 'logout', 'uses' => 'UserController@logout',]);


/*
|--------------------------------------------------------------------------
| Referral's Promotional Page
|--------------------------------------------------------------------------
*/

Route::get('/explainer-video', ['as' => 'explainer-video', 'uses' => 'PromoViewController@explainer_video',]);
Route::get('/explainer-video/{referral}', ['as' => 'explainer-video', 'uses' => 'PromoViewController@explainer_video',]);

Route::get('/marketing-plan-video', ['as' => 'marketing-plan-video', 'uses' => 'PromoViewController@marketing_plan',]);
Route::get('/marketing-plan-video/{referral}', ['as' => 'marketing-plan-video', 'uses' => 'PromoViewController@marketing_plan',]);

Route::get('/crowdfunding', ['as' => 'crowdfunding', 'uses' => 'PromoViewController@crowdfunding',]);
Route::get('/crowdfunding/{referral}', ['as' => 'crowdfunding', 'uses' => 'PromoViewController@crowdfunding',]);

Route::post('/subscribe-page', ['as' => 'do-subscribe-page', 'uses' => 'PromoController@subscribe',]);
/*
|--------------------------------------------------------------------------
| Referral's Promotional Banners
|--------------------------------------------------------------------------
*/

Route::get('/promo/{alias}', ['as' => 'promo', 'uses' => 'PromoViewController@promo',]);
Route::get('/promo/{alias}/{referral}', ['as' => 'promo', 'uses' => 'PromoViewController@promo',]);
Route::get('/redirect/promo/{alias}/{id}', ['as' => 'redirect-promo', 'uses' => 'PromoViewController@redirect',]);

/*
|--------------------------------------------------------------------------
| Admin's Page (admin)
|--------------------------------------------------------------------------
*/

Route::get('/admin/home', ['as' => 'admin-home', 'uses' => 'AdminViewController@home',]);
Route::get('/admin/checklogaddress', ['as' => 'admin-check-address', 'uses' => 'AdminViewController@logAddress',]);

Route::get('/admin/personal-info', ['as' => 'admin-personal-info', 'uses' => 'MemberViewController@personal_info',]);
Route::post('/admin/upload-profile-pic', ['as' => 'admin-upload-profile-pic', 'uses' => 'MemberController@upload_profile_pic',]);
Route::post('/admin/personal-info', ['as' => 'admin-personal-info', 'uses' => 'MemberController@personal_info',]);

Route::get('/admin/communication-info', ['as' => 'communication-info', 'uses' => 'MemberViewController@communication_info',]);

/* [ Manage FAQ ] */
Route::get('/admin/manage-faq', ['as' => 'manage-faq', 'uses' => 'FAQViewController@index',]);
Route::post('/admin/add-faq', ['as' => 'add-faq', 'uses' => 'FAQController@add',]);
Route::get('/admin/edit-faq', ['as' => 'edit-faq', 'uses' => 'FAQViewController@edit',]);
Route::post('/admin/edit-faq', ['as' => 'edit-faq', 'uses' => 'FAQController@edit',]);
Route::post('/admin/delete-faq', ['as' => 'delete-faq', 'uses' => 'FAQController@delete',]);

/* [ Emails ] */
Route::get('/admin/emails', ['as' => 'admin-email', 'uses' => 'EmailViewController@admin_email',]);
Route::get('/admin/view-email', ['as' => 'admin-view-email', 'uses' => 'EmailViewController@admin_view_email',]);

/* [ Quick Login ] */
Route::get('/admin/quick-login/{id}', ['as' => 'quick-login', 'uses' => 'AdminController@quick_login',]);

/* [ Member List ] */
Route::get('/admin/users/{user_type}', ['as' => 'admin-member', 'uses' => 'AdminController@users_list',]);
Route::get('/admin/users/{user_type}/{filter_type}/{filter_value}', ['as' => 'admin-member', 'uses' => 'AdminController@users_list',]);
Route::post('/admin/users/{user_type}/{filter_type}/{filter_value}', ['as' => 'admin-member', 'uses' => 'AdminController@users_list',]);
Route::get('/admin/users/unapproved/{user_type}', ['as' => 'unapproved-member', 'uses' => 'AdminController@users_unapproved',]);

/* [ Image Gallery ] */
Route::get('/admin/image-gallery', ['as' => 'image-gallery', 'uses' => 'GalleryViewController@image_gallery',]);
Route::post('/admin/create-gallery', ['as' => 'create-gallery', 'uses' => 'GalleryController@image_create_album',]);
Route::post('/admin/save-gallery', ['as' => 'save-gallery', 'uses' => 'GalleryController@image_save_album',]);
Route::get('/admin/edit-album', ['as' => 'edit-album', 'uses' => 'GalleryViewController@edit_album',]);
Route::post('/admin/upload-images', ['as' => 'upload-images', 'uses' => 'GalleryController@upload_images',]);
Route::post('/admin/delete-album', ['as' => 'delete-album', 'uses' => 'GalleryController@delete_album',]);
Route::post('/admin/delete-image', ['as' => 'delete-image', 'uses' => 'GalleryController@delete_image',]);
Route::get('/admin/set-default-image', ['as' => 'set-default-image', 'uses' => 'GalleryController@set_default_image',]);

Route::get('/members/gallery', ['as' => 'gallery', 'uses' => 'GalleryViewController@index',]);
Route::get('/members/gallery-view', ['as' => 'gallery-view', 'uses' => 'GalleryViewController@view',]);

/* [ News & Announcement ] */
Route::get('/admin/manage-news', ['as' => 'manage-news', 'uses' => 'NewsViewController@manage_news',]);
Route::post('/admin/add-news', ['as' => 'add-news', 'uses' => 'NewsController@add_news',]);
Route::post('/admin/delete-news', ['as' => 'delete-news', 'uses' => 'NewsController@delete_news',]);
Route::get('/admin/edit-news', ['as' => 'edit-news', 'uses' => 'NewsViewController@edit_news',]);
Route::post('/admin/edit-news', ['as' => 'edit-news', 'uses' => 'NewsController@edit_news',]);
Route::get('/admin/publish-news', ['as' => 'publish-news', 'uses' => 'NewsController@publish_news',]);
Route::get('/admin/unpublish-news', ['as' => 'unpublish-news', 'uses' => 'NewsController@unpublish_news',]);
Route::get('/admin/blast-news', ['as' => 'publish-news', 'uses' => 'NewsViewController@blast_news',]);
Route::get('/admin/import-members', ['as' => 'import-members', 'uses' => 'NewsController@generate_members_csv',]);
Route::get('/admin/import-nonmembers', ['as' => 'import-nonmembers', 'uses' => 'NewsController@generate_nonmembers_csv',]);

/* [ Member Log & Analytics $ Reports ] */
Route::get('/admin/analytics/{user_id}', ['as' => 'admin-member', 'uses' => 'AdminViewController@user_analytics',]);
Route::get('/admin/logs/{user_id}', ['as' => 'admin-member', 'uses' => 'AdminViewController@user_logs',]);
Route::get('/admin/payments/{user_id}', ['as' => 'admin-member', 'uses' => 'AdminViewController@user_payments',]);
Route::get('/admin/callbacks/{user_id}', ['as' => 'admin-member', 'uses' => 'AdminViewController@user_callbacks',]);
Route::get('/admin/receivings/{user_id}', ['as' => 'admin-member', 'uses' => 'AdminViewController@user_receivings',]);
Route::post('/admin/changereceivingstatus', ['as' => 'change-receiving-status', 'uses' => 'AdminController@change_receiving_status',]);
Route::post('/admin/pagbfix', ['as' => 'pagb-fix', 'uses' => 'AdminController@pagb_fix',]);
Route::get('/admin/passports/{user_id}', ['as' => 'admin-member', 'uses' => 'AdminViewController@user_passports',]);
Route::get('/admin/shares/{user_id}', ['as' => 'admin-member', 'uses' => 'AdminViewController@user_shares',]);
Route::get('/admin/ph', ['as' => 'admin-ph', 'uses' => 'AdminViewController@ph',]);
Route::get('/admin/gh', ['as' => 'admin-gh', 'uses' => 'AdminViewController@gh',]);
Route::get('/admin/ph/{country}', ['as' => 'admin-ph', 'uses' => 'AdminViewController@ph',]);
Route::get('/admin/gh/{country}', ['as' => 'admin-gh', 'uses' => 'AdminViewController@gh',]);
Route::get('/admin/getphgh/{type}/{id}', ['as' => 'get-phgh', 'uses' => 'AdminViewController@getphgh',]);
Route::get('/admin/phgh', ['as' => 'admin-phgh', 'uses' => 'AdminViewController@phgh',]);
Route::get('/admin/micro-ph', ['as' => 'admin-micro-ph', 'uses' => 'AdminViewController@micro_ph',]);
Route::get('/admin/micro-gh', ['as' => 'admin-micro-gh', 'uses' => 'AdminViewController@micro_gh',]);
Route::get('/admin/micro-ph/{country}', ['as' => 'admin-micro-ph', 'uses' => 'AdminViewController@micro_ph',]);
Route::get('/admin/micro-gh/{country}', ['as' => 'admin-micro-gh', 'uses' => 'AdminViewController@micro_gh',]);
Route::get('/admin/micro-getphgh/{type}/{id}', ['as' => 'get-micro-phgh', 'uses' => 'AdminViewController@micro_getphgh',]);
Route::get('/admin/micro-phgh', ['as' => 'admin-micro-phgh', 'uses' => 'AdminViewController@micro_phgh',]);
Route::get('/admin/user-stats', ['as' => 'user-stats', 'uses' => 'AdminViewController@userstats',]);
Route::get('/admin/pagb-stats', ['as' => 'pagb-stats', 'uses' => 'AdminViewController@pagbstats',]);
Route::get('/admin/user-referrer/{user_id}', ['as' => 'user-referrer', 'uses' => 'AdminViewController@user_referrer',]);
Route::get('/admin/help', ['as' => 'admin-help', 'uses' => 'AdminViewController@help',]);
Route::post('/admin/help', ['as' => 'admin-help-upload', 'uses' => 'AdminController@help_upload',]);
Route::get('/admin/ph-chart', ['as' => 'admin-ph-chart', 'uses' => 'AdminViewController@ph_chart',]);
Route::get('/admin/pledge-chart/{type}', ['as' => 'admin-pledge-chart', 'uses' => 'AdminViewController@pledge_chart',]);
Route::get('/admin/passport-chart', ['as' => 'admin-passport-chart', 'uses' => 'AdminViewController@passport_chart',]);

/* [ AJAX */
Route::post('/admin/assign-upline', ['as' => 'assign-upline', 'uses' => 'AdminController@assign_upline',]);
Route::post('/admin/approve-id', ['as' => 'approve-id', 'uses' => 'AdminController@approve_id',]);
Route::post('/admin/reject-id', ['as' => 'reject-id', 'uses' => 'AdminController@reject_id',]);

/* [ Move Network ] */
Route::post('/admin/move-network', ['as' => 'move-network', 'uses' => 'AdminController@move_network',]);
Route::get('/admin/reassign-referral', ['as' => 'reassign-referral', 'uses' => 'AdminController@reassign_referral',]);

/* [ Transfer Passport ] */
Route::post('/admin/transfer-passport', ['as' => 'transfer-passport', 'uses' => 'AdminController@transfer_passport',]);

/* [ Update Referrer ] */
Route::post('/admin/update-referrer', ['as' => 'update-referrer', 'uses' => 'AdminController@update_referrer',]);

/* [ Reclaim Account ] */
Route::post('/admin/reclaim-account', ['as' => 'reclaim-account', 'uses' => 'AdminController@reclaim_account',]);

/* [ Testimonial ] */
Route::get('/admin/testimonial', ['as' => 'admin-testimonial', 'uses' => 'TestimonialViewController@submission',]);
Route::post('/admin/approve-testi', ['as' => 'approve-testi', 'uses' => 'TestimonialController@approve',]);
Route::post('/admin/reject-testi', ['as' => 'reject-testi', 'uses' => 'TestimonialController@reject',]);

/* [ Duplicates Fix ] */
Route::get('/admin/duplicate-shares', ['as' => 'duplicate-shares', 'uses' => 'AdminFixController@getDuplicateShares',]);
Route::get('/admin/duplicate-shares/secret/{secret}', ['as' => 'duplicate-shares-secret', 'uses' => 'AdminFixController@getDuplicateSharesSecret',]);
Route::get('/admin/duplicate-shares/secret/fix/{secret}', ['as' => 'duplicate-shares-secret-fix', 'uses' => 'AdminFixController@fixDuplicateSharesSecret',]);
Route::get('/admin/duplicate-shares/{user_id}/{shares_type}/{shares_type_id}/{debit_value_in_btc}/{hour}/{minute}', ['as' => 'duplicate-shares-id', 'uses' => 'AdminFixController@getDuplicateSharesID',]);
Route::get('/admin/duplicate-shares/fix/{user_id}/{shares_type}/{shares_type_id}/{debit_value_in_btc}/{hour}/{minute}', ['as' => 'duplicate-shares-id-fix', 'uses' => 'AdminFixController@fixDuplicateSharesID',]);
//Route::get('/admin/duplicate-shares/{user_id}/{shares_type_id}/{debit_value_in_btc}', ['as' => 'duplicate-shares-id', 'uses' => 'AdminFixController@getDuplicateSharesID',]);

/* [ Cron ] */
Route::get('/admin/cron', ['as' => 'cron', 'uses' => 'AdminViewController@cron',]);
Route::get('/admin/cron/{type}', ['as' => 'cron-type', 'uses' => 'AdminViewController@cron',]);

/* [ Settings ] */
Route::get('/admin/settings', ['as' => 'settings', 'uses' => 'AdminViewController@settings',]);
Route::get('/admin/settings/hierarchy/{type}/{set}', ['as' => 'settings-hierarchy', 'uses' => 'AdminController@settings_hierarchy',]);

/*
|--------------------------------------------------------------------------
| Member's Page (members)
|--------------------------------------------------------------------------
*/

Route::get('/complete-profile', ['as' => 'complete-profile', 'uses' => 'MemberViewController@complete_profile',]);
Route::post('/complete-profile', ['as' => 'complete-profile', 'uses' => 'MemberController@complete_profile',]);

/* [ Personal Info ] */
Route::get('/members/home', ['as' => 'home', 'uses' => 'MemberViewController@home',]);
Route::post('/members/home-check-alias',  'MemberViewController@homeAliasCheck');
Route::get('/members/personal-info', ['as' => 'personal-info', 'uses' => 'MemberViewController@personal_info',]);
Route::post('/members/upload-profile-pic', ['as' => 'upload-profile-pic', 'uses' => 'MemberController@upload_profile_pic',]);
Route::post('/members/personal-info', ['as' => 'personal-info', 'uses' => 'MemberController@personal_info',]);

/* [ Communication Info ] */
Route::get('/members/communication-info', ['as' => 'communication-info', 'uses' => 'MemberViewController@communication_info',]);
Route::post('/members/update-mobile', ['as' => 'update-mobile', 'uses' => 'MemberController@update_mobile',]);
Route::post('/members/update-email', ['as' => 'update-email', 'uses' => 'MemberController@update_email',]);

/* [ Marketing Meterial ] */
Route::get('/members/marketing-meterial', ['as' => 'marketing-meterial', 'uses' => 'MemberViewController@marketing_meterial',]);
Route::post('/members/upload-video', ['as' => 'upload-video', 'uses' => 'MemberController@upload_video',]);

/* [ Social Media Info ] */
Route::get('/members/social-media-info', ['as' => 'social-media-info', 'uses' => 'MemberViewController@social_media_info',]);
Route::post('/members/social-media-info', ['as' => 'social-media-info', 'uses' => 'MemberController@social_media_info',]);

/* [ Change Password ] */
Route::get('/members/change-password', ['as' => 'change-password', 'uses' => 'MemberViewController@change_password',]);
Route::post('/members/change-password', ['as' => 'change-password', 'uses' => 'MemberController@change_password',]);

/* [ Google Two-Factor Authentication ] */
Route::get('/members/security', ['as' => 'security', 'uses' => 'MemberViewController@security_google2fa',]);
Route::post('/members/security', ['as' => 'security', 'uses' => 'MemberController@security_google2fa',]);

/* [ Email ] */
Route::get('/members/emails', ['as' => 'emails', 'uses' => 'EmailViewController@inbox',]);
Route::get('/members/view-email/{id}', ['as' => 'view-email', 'uses' => 'EmailViewController@view_email',]);

/* [ Register New Member ] */
Route::get('/members/new-member', ['as' => 'new-member', 'uses' => 'MemberViewController@new_member',]);
Route::post('/members/new-member', ['as' => 'new-member', 'uses' => 'ManageAccountController@signup',]);

/* [ Referral Setting ] */
Route::get('/members/referral-setting', ['as' => 'referral-setting', 'uses' => 'MemberViewController@referral_setting',]);
Route::post('/members/referral-setting', ['as' => 'referral-setting', 'uses' => 'MemberController@referral_setting',]);
Route::get('/check-alias/{alias}', ['as' => 'check-alias', 'uses' => 'UserController@check_alias',]);
Route::post('/check-alias/{alias}', ['as' => 'check-alias', 'uses' => 'UserController@check_alias',]);

Route::get('/members/update-referrer/{alias}', ['as' => 'member-update-referrer', 'uses' => 'MemberController@update_referral',]);

/* [ Verification ] */
Route::post('/members/upload-veriid-type', ['as' => 'upload-veriid-type', 'uses' => 'VerificationController@upload_veriid_type',]);
Route::post('/members/upload-veriid', ['as' => 'upload-veriid', 'uses' => 'VerificationController@upload_veriid',]);
Route::post('/members/upload-veriselfie', ['as' => 'upload-veriselfie', 'uses' => 'VerificationController@upload_veriselfie',]);

/* [ Bitcoin Wallet ] */
Route::get('/members/bitcoin-wallet', ['as' => 'bitcoin-wallet', 'uses' => 'MemberViewController@bitcoin_wallet',]);

/* [ News ] */
Route::get('/members/news', ['as' => 'news', 'uses' => 'NewsViewController@index',]);

/* [ Leaders ] */
Route::get('/members/country-leaders', ['as' => 'country-leaders', 'uses' => 'LeaderViewController@index',]);

/* [ Testimonial ] */
Route::get('/members/testimonial', ['as' => 'testimonial', 'uses' => 'TestimonialViewController@index',]);
Route::post('/members/testimonial', ['as' => 'testimonial', 'uses' => 'TestimonialController@submit',]);

/* [ Wallet Address ] */
Route::post('/members/update-wallet', ['as' => 'update-wallet', 'uses' => 'MemberController@update_wallet',]);

/* [ Payment ] */
Route::get('/members/payment-confirmation', ['as' => 'payment-confirmation', 'uses' => 'PaymentViewController@confirm',]);

/* [ Upgrade ] */
Route::get('/members/assistant', ['as' => 'assistant', 'uses' => 'PAGBViewController@index',]);
Route::get('/members/upgrade-template', ['as' => 'upgrade-template', 'uses' => 'PAGBViewController@upgrade',]);

//Route::get('/members/upgrade', ['as' => 'upgrade', 'uses' => 'MaintenanceViewController@index',]);
Route::get('/members/upgrade', ['as' => 'upgrade', 'uses' => 'PAGBViewController@upgrade',]);

Route::get('/members/upgrade/{upline}/{position}', ['as' => 'upgrade-manual', 'uses' => 'PAGBViewController@upgrade',]);

Route::get('/members/pagb-history', ['as' => 'pagb-history', 'uses' => 'PAGBViewController@history',]);

/* [ BLOCKio ] */
Route::get('/blockio-callback', ['as' => 'blockio-callback', 'uses' => 'CallbackController@blockio_callback',]);
Route::post('/blockio-callback', ['as' => 'blockio-callback', 'uses' => 'CallbackController@blockio_callback',]);
Route::get('/blockio-status/{receiving_address}', ['as' => 'blockio-status', 'uses' => 'CallbackController@blockio_status',]);
Route::get('/blockio-confirmations/{receiving_address}', ['as' => 'blockio-confirmations', 'uses' => 'CallbackController@blockio_confirmations',]);
Route::get('/blockio-single-callback/{receiving_adddress}', ['as' => 'single-callback', 'uses' => 'CallbackController@single_manual_callback',]);

Route::get('/withdraw', ['as' => 'withdraw', 'uses' => 'CallbackController@withdraw',]);

/* [ Purchase Passport ] */
Route::get('/members/passport', ['as' => 'passport', 'uses' => 'PassportViewController@index',]);
Route::get('/members/ajax-passport/{quantity}', ['as' => 'ajax-passport', 'uses' => 'PassportViewController@ajax_passport',]);

/* [ Passport ] */
Route::get('/blockio-passport/{quantity}', ['as' => 'blockio-passport', 'uses' => 'PassportController@blockio_passport',]);
Route::get('/passport-price/{quantity}', ['as' => 'passport-price', 'uses' => 'PassportController@passport_price',]);
Route::get('/generate-qr/{receiving_address}/{value_in_btc}', ['as' => 'generate-qr', 'uses' => 'CallbackController@generate_qr',]);

/* [ Purchase Micro Passport ] */
Route::get('/members/micro-passport', ['as' => 'micro-passport', 'uses' => 'MicroPassportViewController@index',]);
Route::get('/members/ajax-micro-passport/{quantity}', ['as' => 'ajax-micro-passport', 'uses' => 'MicroPassportViewController@ajax_passport',]);

/* [ Micro Passport ] */
Route::get('/blockio-micro-passport/{quantity}', ['as' => 'blockio-micro-passport', 'uses' => 'MicroPassportController@blockio_passport',]);
Route::get('/micro-passport-price/{quantity}', ['as' => 'micro-passport-price', 'uses' => 'MicroPassportController@passport_price',]);

/* [ Change Password ] */
Route::get('/members/verification', ['as' => 'verification', 'uses' => 'VerificationViewController@index',]);

/* [ BR Shares ] */
Route::get('/members/shares', ['as' => 'shares', 'uses' => 'SharesViewController@index',]);

/* [ Micro Shares ] */
Route::get('/members/micro-shares', ['as' => 'micro-shares', 'uses' => 'MicroSharesViewController@index',]);

/* [ Network List ] */
Route::get('/members/network', ['as' => 'network', 'uses' => 'NetworkViewController@index',]);

/* [ Move Placement ] */
Route::get('/members/move_placement/{downline1}/{downline2}/{downline3}', ['as' => 'move-placement', 'uses' => 'UserController@movePlacement',]);

/* [ Region Bank ] */
//Route::get('/members/provide-help', ['as' => 'provide-help', 'uses' => 'MaintenanceViewController@index',]);
Route::get('/members/provide-help', ['as' => 'provide-help', 'uses' => 'BankViewController@provide_help',]);
Route::get('/members/provide-help-ajax/{ph_id}', ['as' => 'provide-help-ajax', 'uses' => 'BankViewController@provide_help_ajax',]);
Route::get('/members/get-help', ['as' => 'get-help', 'uses' => 'BankViewController@get_help',]);
Route::get('/members/get-help-ajax/{gh_id}', ['as' => 'get-help-ajax', 'uses' => 'BankViewController@get_help_ajax',]);
Route::get('/members/pairing', ['as' => 'pairing', 'uses' => 'BankViewController@pairing',]);

//Route::get('/members/ph/{from}/{value_in_btc}', ['as' => 'ph', 'uses' => 'BankController@provide_help',]);
Route::get('/members/ph/{from}/{value_in_btc}/{secret}', ['as' => 'ph', 'uses' => 'BankController@provide_help',]);
//Route::get('/members/gh/{from}/{value_in_btc}', ['as' => 'gh', 'uses' => 'BankController@get_help',]);
Route::get('/members/gh/{from}/{value_in_btc}/{secret}', ['as' => 'gh', 'uses' => 'BankController@get_help',]);
Route::get('/members/gh-cancel/{gh_id}/{secret}', ['as' => 'gh', 'uses' => 'BankController@get_help_cancel',]);
Route::get('/members/ph-cancel/{ph_id}/{secret}', ['as' => 'ph', 'uses' => 'BankController@provide_help_cancel',]);

//Route::get('/members/ph-release/{type}/{ph_id}/{value_in_btc}', ['as' => 'ph-release', 'uses' => 'BankController@ph_release',]);
Route::get('/members/ph-release/{type}/{ph_id}/{value_in_btc}/{secret}', ['as' => 'ph-release', 'uses' => 'BankController@ph_release',]);

Route::get('/members/phgh/{phgh_id}', ['as' => 'phgh', 'uses' => 'BankViewController@ajax_phgh',]);

Route::get('/members/pair_move/{position}', ['as' => 'pair_move', 'uses' => 'BankController@pair_move',]);

Route::get('/members/phgh-status/{id}', ['as' => 'phgh-status', 'uses' => 'BankController@phgh_status',]);

/* [ Micro Bank ] */
Route::get('/members/micro-provide-help', ['as' => 'micro-provide-help', 'uses' => 'MicroBankViewController@provide_help',]);
Route::get('/members/micro-get-help', ['as' => 'micro-get-help', 'uses' => 'MicroBankViewController@get_help',]);

Route::get('/members/micro-ph/{from}/{value_in_btc}', ['as' => 'micro-ph', 'uses' => 'MicroBankController@provide_help',]);
Route::get('/members/micro-gh/{from}/{value_in_btc}', ['as' => 'micro-gh', 'uses' => 'MicroBankController@get_help',]);

Route::get('/members/micro-ph-release/{type}/{ph_id}/{value_in_btc}', ['as' => 'ph-release', 'uses' => 'MicroBankController@ph_release',]);

Route::get('/members/micro-phgh/{phgh_id}', ['as' => 'micro-phgh', 'uses' => 'MicroBankViewController@ajax_phgh',]);

Route::get('/members/micro-phgh-status/{id}', ['as' => 'micro-phgh-status', 'uses' => 'MicroBankController@phgh_status',]);

/* [ Hierarchy ] */
Route::get('/members/hierarchy', ['as' => 'hierarchy', 'uses' => 'HierarchyViewController@network',]);
Route::post('/members/hierarchy', ['as' => 'hierarchy', 'uses' => 'HierarchyViewController@network',]);
Route::get('/members/referral', ['as' => 'referral', 'uses' => 'HierarchyViewController@referral',]);
Route::post('/members/referral', ['as' => 'referral', 'uses' => 'HierarchyViewController@referral',]);

//New Hierarchy TEST
Route::get('/members/hierarchy-new', ['as' => 'hierarchy-new', 'uses' => 'HierarchyViewController@network_new',]);

//PH PLUS
Route::get('/members/provide-help-plus', ['as' => 'ph-plus', 'uses' => 'PhplusViewController@index',]);
Route::get('/members/provide-help-plus-history', ['as' => 'ph-plus-history', 'uses' => 'PhplusViewController@history',]);
Route::get('/members/ph-plus/{value_in_btc}', ['as' => 'ph-submit', 'uses' => 'PhplusController@provide_help',]);

/* [ Manage Account ] */
Route::get('/members/manage-account/{user_id}', ['as' => 'manage-account', 'uses' => 'ManageaccountViewController@index',]);
Route::get('/members/manage-account/{user_id}/{tab}', ['as' => 'manage-account', 'uses' => 'ManageaccountViewController@index',]);
Route::get('/members/ajax-assistant/{user_id}', ['as' => 'ajax-assistant', 'uses' => 'ManageaccountViewController@manage_assistant',]);
Route::get('/members/ajax-provide-help/{user_id}', ['as' => 'ajax-provide-help', 'uses' => 'ManageaccountViewController@manage_ph',]);
Route::get('/members/ajax-pairing/{user_id}', ['as' => 'ajax-pairing', 'uses' => 'ManageaccountViewController@manage_pairing',]);
Route::get('/members/ajax-upgrade/{user_id}', ['as' => 'ajax-upgrade', 'uses' => 'ManageaccountViewController@manage_upgrade',]);
Route::get('/members/ajax-upgrade/{user_id}/{upline}/{position}', ['as' => 'ajax-manual-upgrade', 'uses' => 'ManageaccountViewController@manage_upgrade',]);
Route::get('/members/ajax-confirmation/{user_id}', ['as' => 'ajax-confirmation', 'uses' => 'ManageaccountViewController@manage_confirmation',]);
Route::get('/members/ajax-ph/{user_id}/{from}/{value_in_btc}/{secret}', ['as' => 'ajax-ph', 'uses' => 'ManageAccountController@provide_help',]);
Route::get('/members/ajax-ph/{user_id}/{from}/{value_in_btc}/{secret}/{onbehalf_user_id}', ['as' => 'ajax-ph', 'uses' => 'ManageAccountController@provide_help',]);
Route::get('/members/ajax-passport-insufficient', ['as' => 'ajax-passport-insufficient', 'uses' => 'ManageaccountViewController@passport_insufficient',]);
Route::post('/members/ajax-update-wallet', ['as' => 'ajax-update-wallet', 'uses' => 'ManageAccountController@update_wallet',]);

Route::get('/check-upline/{alias}', ['as' => 'check-upline', 'uses' => 'PAGBController@check_upline',]);
Route::get('/check-upline/{alias}/{upline_user_id}', ['as' => 'check-upline', 'uses' => 'PAGBController@check_upline',]);

/* [ FAQ ] */
Route::get('/members/faq', ['as' => 'faq', 'uses' => 'FAQViewController@view',]);

/* [ Pool Account ] */
Route::get('/poolaccount', ['as' => 'pool-account', 'uses' => 'PoolController@poolaccount',]);
Route::get('/poolaccount/{from}/{to}', ['as' => 'pool-account', 'uses' => 'PoolController@poolaccount',]);

/* [ Error ] */
Route::get('error', ['as' => 'errors.defaultError', 'uses' => 'ErrorController@defaultError' ]);

/* [ Passport Leader ] */
Route::get('/members/leader', ['as' => 'passport-leader', 'uses' => 'LeaderController@passport_leader',]);
Route::get('/members/leader/{end_date}', ['as' => 'passport-leader-end-date', 'uses' => 'LeaderController@passport_leader',]);

/* [ Passport Leader ] */
Route::get('/geoip', ['as' => 'geoip', 'uses' => 'CallbackController@geoip',]);
Route::post('/geoip', ['as' => 'geoip', 'uses' => 'CallbackController@geoip',]);
Route::get('/geoip/{ip}', ['as' => 'geoip', 'uses' => 'CallbackController@geoip',]);
Route::post('/geoip/{ip}', ['as' => 'geoip', 'uses' => 'CallbackController@geoip',]);

/* [ Promotional Tools ] */
Route::get('/members/promo-pages', ['as' => 'promo-pages', 'uses' => 'SubscriberViewController@pages',]);
Route::get('/members/promo-banner', ['as' => 'promo-banner', 'uses' => 'SubscriberViewController@banner',]);
Route::get('/members/prospect-management', ['as' => 'prospect-management', 'uses' => 'SubscriberViewController@manage_subscribers',]);
Route::post('/members/update-prospect', ['as' => 'update-prospect', 'uses' => 'SubscriberController@update_subscribers',]);

#### KAMAL ####
Route::group(['middleware' => 'role.user'], function () {
	#### KNOWLEDGE BASE #####
	Route::get('/Members/CategoryList', ['as'=>'member-category-list' , 'uses'=> 'Member\kb\UserController@getCategoryList']);
	Route::get('category-list/{id}',['as'=>'categorylist' , 'uses'=>'Member\kb\UserController@getCategory']);
	Route::get('/Members/Articlelist',['as'=>'member-article-list' , 'uses'=> 'Member\kb\UserController@getArticle']);
	Route::get('/show/{slug}',['as'=>'show' , 'uses'=> 'Member\kb\UserController@show']);
	Route::post('postcomment/{slug}',['as'=>'postcomment' , 'uses'=>  'Member\kb\UserController@postComment']);
	Route::post('/Members/Article/Language',['as'=>'member-article-selected-lang' , 'uses'=> 'Member\kb\UserController@loadArticleOfSelLang']);
	Route::get('Create/Ticket',['as'=>'create-ticket','uses'=>'Member\helpdesk\FormController@preForm']);
	Route::post('Create/Ticket-confirm',['as'=>'create-ticket-confirm','uses'=>'Member\helpdesk\FormController@getForm']);
	Route::post('Ticket/Post', 'Member\helpdesk\FormController@postedForm');	/* post the form to store the value */
	Route::get('Mytickets', ['as' => 'my-tickets', 'uses' => 'Member\helpdesk\UserTicketController@getMyticket']);
	Route::post('Mytickets/UpdateStatus', ['as'=>'my-tickets-update-status' ,'uses'=>'Member\helpdesk\UserTicketController@updateStatus']);
	Route::get('Ticket/Detail/{id}', ['as' => 'check_ticket', 'uses' => 'Member\helpdesk\UserTicketController@getTicketDetail']);	//detail ticket information
	Route::post('Ticket/Post/Comment/{id}',['as'=>'post-ticket-comment','uses'=>'Member\helpdesk\UserTicketController@postCommentOfTicket']);



	Route::get('/members/language/translation/request', ['as' => 'member-lang-trans-req', 'uses' => 'LanguageTranslationController@index',]);
	Route::get('/members/language/{fileName}/{id}', ['as' => 'member-lang-trans-filedata', 'uses' => 'LanguageTranslationController@getFileData']);
	Route::post('/member/post/language/translated', ['as' => 'member-language-post-translate-data', 'uses' => 'LanguageTranslationController@postFileData']);
	

});
// /* get search values */
$router->get('search',['as'=>'search', 'uses'=> 'Member\kb\UserController@search']);
### TICKETS ####
Route::get('/ticket/close/{id}', ['as' => 'ticket.close', 'uses' => 'Member\helpdesk\TicketController@close']);	/*  Get Ticket Close */
Route::get('/ticket/open/{id}', ['as' => 'ticket.open', 'uses' => 'Member\helpdesk\TicketController@open']);	/*  Get Ticket Open */
Route::get('/ticket/resolve/{id}', ['as' => 'ticket.resolve', 'uses' => 'Member\helpdesk\TicketController@resolve']);	/*  Get ticket Resolve */
Route::get('/Ticket/Assigned/{Status}', ['as' => 'assigned.ticket', 'uses' => 'Member\helpdesk\Leader\TicketController@myticket_ticket_list']);	/*  Get Tickets Assigned to logged user */
Route::get('/Ticket/Thread/{id}', ['as' => 'ticket.thread', 'uses' => 'Member\helpdesk\Leader\TicketController@thread']);	/*  Get Thread by ID */
Route::patch('/Ticket/Thread/Reply/{id}', ['as' => 'ticket.reply', 'uses' => 'Member\helpdesk\Leader\TicketController@reply']);	/*  Patch Thread Reply */
Route::get('image/{id}', ['as'=>'image', 'uses'=>'Member\helpdesk\Leader\MailController@get_data']);	/* get image */
Route::get('/Ticket/Surrender/{id}', ['as' => 'ticket.surrender', 'uses' => 'Member\helpdesk\Leader\TicketController@surrender']);	/*  Get Ticket Surrender */

$router->resource('category', 'Member\Manage\kb\CategoryController');
Route::post('Manage/Category/Delete', ['as'=>'category-delete', 'uses'=>'Member\Manage\kb\CategoryController@destroy']);

$router->resource('article', 'Member\Manage\kb\ArticleController');
Route::get('Manage/Article/Addlanguage/{articleID}', ['as'=>'manage-article-add-lang', 'uses'=>'Member\Manage\kb\ArticleController@addMoreArticleLanguage']);
Route::post('Manage/Article/Addlanguage', ['as'=>'post-article-add-lang', 'uses'=>'Member\Manage\kb\ArticleController@postMoreArticleLanguage']);
Route::get('Manage/Article/Edit/{articleID}/{LanguageID}', ['as'=>'manage-article-edit-lang', 'uses'=>'Member\Manage\kb\ArticleController@editArticle']);

Route::post('Manage/Article/Delete', ['as'=>'article-delete', 'uses'=>'Member\Manage\kb\ArticleController@destroy']);


Route::get('/Manage/Leaders', ['as' => 'Manage-Leader', 'uses' => 'Member\helpdesk\Admin\ManageLeaderController@index']);
Route::post('/Manage/Leaders/Addkeyup', ['as' => 'Manage-Leader-Add-Keyup', 'uses' => 'Member\helpdesk\Admin\ManageLeaderController@getKeyUp']);
Route::post('/Manage/Leaders/Post', ['as' => 'Manage-Leader-Post-Add', 'uses' => 'Member\helpdesk\Admin\ManageLeaderController@postLeaderForm']);
Route::get('/Manage/Leaders/Delete/{LeaderID}', ['as' => 'Manage-Leader-delete', 'uses' => 'Member\helpdesk\Admin\ManageLeaderController@Remove']);


### HELPDESK ADMIN ####
###########ARTICLE#########
$router->resource('Admin/Manage/Article', 'Member\helpdesk\Admin\ArticleController');
Route::get('Admin/Manage/Article/Edit/{articleID}/{LanguageID}', ['as'=>'manage-article-edit-lang', 'uses'=>'Member\helpdesk\Admin\ArticleController@editArticle']);
Route::get('Admin/Manage/Article/Addlanguage/{articleID}', ['as'=>'admin-manage-article-add-lang', 'uses'=>'Member\helpdesk\Admin\ArticleController@addMoreArticleLanguage']);
###########CATEGORY#########
$router->resource('Admin/Manage/Category', 'Member\helpdesk\Admin\CategoryController');
########### TICKETS #########
Route::get('/Admin/Ticket/{Status}', ['as' => 'admin-tickets', 'uses' => 'Member\helpdesk\Admin\TicketController@getAll']);	/*  Get Tickets Assigned to logged user */
Route::post('select_all', ['as'=>'select_all' ,'uses'=>'Member\helpdesk\Leader\TicketController@select_all']);
Route::get('/Admin/Ticket/Detail/{id}', ['as' => 'admin.ticket.thread', 'uses' => 'Member\helpdesk\Admin\TicketController@Detail']);	/*  Get Thread by ID */
Route::patch('/Ticket/Assign/{id}', ['as' => 'admin.assign.ticket', 'uses' => 'Member\helpdesk\Admin\TicketController@assign']);	/*  Patch Ticket assigned to whom */

### HELPDESK ADMIN ####
Route::group(['middleware' => 'admin'], function () {
	Route::get('/admin/system/language', ['as' => 'admin-system-language', 'uses' => 'Admin\LanguageController@index']);
	Route::get('/admin/system/language/{fileName}/{languageCode}', ['as' => 'admin-system-language-filedata', 'uses' => 'Admin\LanguageController@getFileData']);
	Route::post('/admin/system/language/data', ['as' => 'admin-language-post-filedata', 'uses' => 'Admin\LanguageController@postFileData']); ## UPDATE PH OR GH PRIORITY ##
	
	Route::get('/admin/language/transtaion/requests', ['as' => 'admin-language-translation-requests', 'uses' => 'Admin\LanguageController@translationRequest']);
	Route::post('/admin/member/postkeyup/language', ['as' => 'admin-member-postkeyup-language-request', 'uses' => 'Admin\UsersController@getKeyUpForLanguage']);
	
	Route::post('/admin/member/post/language/request', ['as' => 'admin-member-post-language-request', 'uses' => 'Admin\LanguageController@postLangTranslationReq']);
	
	Route::get('/admin/lang/{fileName}/{id}', ['as' => 'admin-lang-trans-filedata', 'uses' => 'Admin\LanguageController@getDetailTransRequest']);
	Route::get('/admin/lang/detail',['as'=>'admin-lang-detail','uses'=>'Admin\LanguageController@getDetail']);
	Route::post('/admin/lang/save', ['as' => 'admin-lang-post-save', 'uses' => 'Admin\LanguageController@postSaveLanguage']);
	
	Route::post('/admin/member/transfer-passport', ['as' => 'admin-member-transfer-passport', 'uses' => 'Admin\UsersController@transfer_passport',]);
	Route::post('/admin/non-member/assign-upline', ['as' => 'admin-member-assign-upline', 'uses' => 'Admin\UsersController@assign_upline',]);
	Route::post('/admin/member/postkeyup/language', ['as' => 'admin-member-postkeyup-language-request', 'uses' => 'Admin\UsersController@getKeyUpForLanguage']);
	Route::post('/admin/translated/update', ['as' => 'admin-update-translate-data', 'uses' => 'Admin\LanguageController@updateTransFile']);
	
	Route::get('/admin/system/dispute/users', ['as' => 'admin-manage-dispute-users', 'uses' => 'Admin\UsersController@getDisputes']);
	Route::post('/admin/user/dispute/post',['as'=>'admin-user-dispute-post','uses'=>'Admin\UsersController@postDispute']);
	
	
	Route::get('/admin/dispute/detail/{id}', ['as' => 'admin-dispute-logs', 'uses' => 'Admin\UsersController@getDisputeLogs']);
	Route::get('/admin/dispute/update/{id}', ['as' => 'admin-dispute-update', 'uses' => 'Admin\UsersController@disputeViewAndUpdate']);
	Route::post('/admin/dispute/update', ['as' => 'admin-dispute-post-update', 'uses' => 'Admin\UsersController@updateUserStatus']);
	
	Route::get('/admin/requests/leadership', ['as' => 'admin-leadership-reqts', 'uses' => 'Admin\ManageRequestsController@getLeadersRequest']);
	Route::post('/admin/requests/leadership/update', ['as' => 'admin-leadership-update', 'uses' => 'Admin\ManageRequestsController@updateLeadership']);
	
	Route::get('/admin/manage/videos', ['as' => 'admin-manage-videos', 'uses' => 'Admin\ManageRequestsController@listVideos']);
	Route::post('/admin/post/video', ['as' => 'admin-post-video', 'uses' => 'Admin\ManageRequestsController@postVideo']);
	Route::get('/admin/manage/video/{id}', ['as' => 'admin-video-edit', 'uses' => 'Admin\ManageRequestsController@getVideoDetail']);
	Route::post('/admin/video/quickupdate', ['as' => 'admin-video-quick-edit', 'uses' => 'Admin\ManageRequestsController@postUpdateVideo']);
	
	Route::get('/admin/ticket/pending/{id}', ['as' => 'admin.ticket.pending', 'uses' => 'Member\helpdesk\Admin\TicketController@temporaryPending']);
	Route::get('/admin/ticket/filter', ['as' => 'admin.ticket.filter', 'uses' => 'Member\helpdesk\Admin\TicketController@Search']);
	
	Route::get('/admin/ticket/filterManager', ['as' => 'admin.ticket.filterManager', 'uses' => 'Member\helpdesk\Admin\TicketController@changeManager']);
	
	Route::get('/admin/ticket/filterByCategory', ['as' => 'admin.ticket.filterByCategory', 'uses' => 'Member\helpdesk\Admin\TicketController@getTicketByCatogryOrAssigned']);
	
	
	Route::post('/admin/member/ghb', ['as' => 'admin-ghb', 'uses' => 'Admin\UsersController@getHelp']);
	
	Route::post('/admin/ticket/update/topic', ['as' => 'admin-update-user-ticket-topic', 'uses' => 'Member\helpdesk\Admin\TicketController@updateUserTicketTopic']);
	### MANAGE TICKET CAT AND ROLES ###
	Route::get('/admin/manage/helptopicroles', ['as' => 'admin.ticket.manage.topicandroles', 'uses' => 'Member\helpdesk\Admin\ManageTicketController@index']);
	Route::post('/admin/manage/helptopic/update', ['as' => 'admin-manage-update-helptopic', 'uses' => 'Member\helpdesk\Admin\ManageTicketController@updateTopic']);
	Route::post('/admin/manage/helptopic/insert', ['as' => 'admin-manage-insert-helptopic', 'uses' => 'Member\helpdesk\Admin\ManageTicketController@insertTopic']);
	Route::post('/admin/manage/helptopic/delete', ['as' => 'admin-manage-delete-helptopic', 'uses' => 'Member\helpdesk\Admin\ManageTicketController@deleteTopic']);
	
	Route::get('/admin/manage/ajax/loadtopics/{code}', ['as' => 'admin.ticket.manage.ajax.loadtopics', 'uses' => 'Member\helpdesk\Admin\ManageTicketController@loadTopics']);
	Route::post('/admin/manage/assign/topic', ['as' => 'admin-manage-assign-helptopic', 'uses' => 'Member\helpdesk\Admin\ManageTicketController@postAssignTopic']);
	
	Route::post('/admin/manage/helptopic/delete/assigned', ['as' => 'admin-manage-delete-assigned-topic', 'uses' => 'Member\helpdesk\Admin\ManageTicketController@deleteAssignedTopic']);
	Route::post('/admin/manage/helptopic/delete/temam/member', ['as' => 'admin-manage-delete-team-manager', 'uses' => 'Member\helpdesk\Admin\ManageTicketController@deleteTeamManager']);
	Route::post('/admin/manage/helptopic/add/temam/member', ['as' => 'admin-manage-add-team-manager', 'uses' => 'Member\helpdesk\Admin\ManageTicketController@addTeamManager']);
	
});
#### KAMAL ####

	Route::get('/members/dispute', ['as' => 'dispute-home', 'uses' => 'Member\DisputeUserController@index',]);
	Route::post('/members/dispute/update',['as'=>'dispute-post-update','uses'=>'Member\DisputeUserController@postUpdate']);
	Route::post('/members/dispute/update/complainBy',['as'=>'dispute-post-update-complainBY','uses'=>'Member\DisputeUserController@postUpdateFromComplainBy']);


/* [ Signup ] */
Route::get('/{referral}', ['as' => 'websiteref', 'uses' => 'WebsiteViewController@index',]);
Route::get('/{referral}/{position}', ['as' => 'websiteref', 'uses' => 'WebsiteViewController@index',]);
//Route::get('/{referral}', ['as' => 'signupref', 'uses' => 'UserViewController@signup',]);
//Route::get('/{referral}/{position}', ['as' => 'signupref', 'uses' => 'UserViewController@signup',]);

/* [ Chat ] */
Route::post('/members/user_is_online', ['as' => 'user-is-online', 'uses' => 'ChatController@set_user_online',]);
Route::post('/members/update_chat_id', ['as' => 'update-chat-id', 'uses' => 'ChatController@update_chat_id',]);
Route::post('/members/user_chat_history', ['as' => 'user-chat-history', 'uses' => 'ChatController@user_chat_history',]);
Route::post('/members/user_chat_history_more', ['as' => 'user-chat-history-more', 'uses' => 'ChatController@user_chat_history_more',]);
Route::post('/members/user_online', ['as' => 'user-online', 'uses' => 'ChatController@user_online',]);
Route::post('/members/save_chat', ['as' => 'save-chat', 'uses' => 'ChatController@save_chat',]);
Route::post('/members/user_info', ['as' => 'user-info', 'uses' => 'ChatController@user_info',]);
Route::post('/members/check_friend', ['as' => 'check-friend', 'uses' => 'ChatController@check_friend',]);
