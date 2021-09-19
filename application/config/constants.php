<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

if( $_SERVER['HTTP_HOST'] == '192.168.43.9' ) {
	$base_url = 'http://192.168.43.9/2xstatus/';
}elseif ($_SERVER['HTTP_HOST'] == 'localhost') {
	$base_url = 'http://localhost/2xstatus/';
} else {
	$base_url = 'https://2xstatus.online/gv_status/';
}

define('ADMIN_NAME','admin'); 
define('APP_NAME','GV status');
define('ADMIN_ASSETS',$base_url.'assets/admin/');

// Home Page Base URL
define('BASE_URL',$base_url); 

// Admin Page Base URL
define('BASE_URL_ADMIN',$base_url.'admin/'); 
define('ADMIN_VIEW','admin/');


define('BANNER_UPLOADS','uploads/banner/');

define('CATEGORY_UPLOADS','uploads/category/');
define('POST_UPLOADS','uploads/post/');
define('POST_IMAGE_GALLERY_UPLOADS','uploads/post_image_gallery/');
define('USER_UPLOADS','uploads/user/');



define('IMAGE_FULLSCREEN_UPLOADS','uploads/fullscreen/image/');
define('IMAGE_LANDSCAP_UPLOADS','uploads/landscape/image/');

define('VIDEO_FULLSCREEN_UPLOADS','uploads/fullscreen/video/');
define('VIDEO_LANDSCAP_UPLOADS','uploads/landscape/video/');

// 

define('IMAGE_UPLOADS','uploads/image/');
define('VIDEO_UPLOADS','uploads/video/');

// Video Item Count

define('FULLSCREEN_COUNNT',40);
define('FULLSCREEN_CATEGORY_COUNNT',20);
define('FULLSCREEN_RELATED_COUNNT',20);

define('LANDSCAP_COUNNT',4);
define('LANDSCAP_CATEGORY_COUNNT',4);
define('LANDSCAP_RELATED_COUNNT',4);



// Setting Constant

define('APP_UPDATE','update');
define('FACEBOOK_ADS','facebook_ads');
define('FACEBOOK_APP_ID','facebook_app_id');
define('FACEBOOK_BANNER_ID','facebook_banner_id');
define('FACEBOOK_INTERSTITIAL_ID','facebook_interstitial_id');
define('FACEBOOK_NATIVE_ID','facebook_native_id');
define('FACEBOOK_NATIVE_ADS_ITEM','facebook_native_ads_item');


// Onesignal

define('ONESIGNAL_APP_ID','526dda30-db20-47b8-bc9c-ae32ac01101f');
define('ONESIGNAL_REST_KEY','ZjdkNzFlNTYtZTg3OC00Zjk4LWI0MzItNTc2YjY0NjVjNzA4');

// 258160789102857_267200118198924


//-------------------------------------------------------
//===============  VERSION 1.6 ==========================
//-------------------------------------------------------


define('IMAGE_THUMBNAIL','uploads/image/');
define('VIDEO_THUMBNAIL','uploads/video/');
define('COMEDY_VIDEO','uploads/comedyvideo/');

define('HOME_VIDEO_COUNT',40); // Home Video Count
define('CATEGORY_VIDEO_COUNT',20); // Category Video Count
define('RELATED_VIDEO_COUNT',20); // Related Video Count
define('COMEDY_VIDEO_COUNT',10); // Comedy Video
define('VERSION_CODE',13);


define('MODULES', json_encode([
	'App_update',
	'Category',
	'Custome_banner',
	'Dialog_banner',
	'Comedy_video',
	'Comedy_video_Mobileupload',
	'Firebaseupload',
	'Mobileupload',
	'Videofirebase',
	'Videolink',
	'Videoupload',
]));


define('MODULES_ACTIONS', json_encode([
	'App_update' => ['view','update','change_status'],
	'Category' => ['view','add','delete','edit','update','preference'],
	'Custome_banner' => ['view','update','change_status'],
	'Dialog_banner' => ['view','update','change_status'],
	'Comedy_video' => ['view','add','edit','update','change_status'],
	'Comedy_video_Mobileupload' => ['view'],
	'Firebaseupload' => ['view','add'],
	'Mobileupload' => ['view','add'],
	'Videofirebase' => ['view','add','delete','edit_link','updateLink','change_status'],
	'Videolink' => ['view','add','delete','edit_link','updateLink','change_status'],
	'Videoupload' => ['view','add','delete','edit','change_status'],
]));



//////////////////////////////////////////////////////
//-------------- 2x status ---------------------------
//////////////////////////////////////////////////////


define('STATUS_ASSETS',$base_url.'assets/status/');
define('BASE_URL_2XSTATUS',$base_url.'status/'); 
define('STATUS_VIEW','status/');

// Offer

define('OFFER_ASSETS',$base_url.'assets/offer/');
define('BASE_URL_OFFER',$base_url.'offer/');
define('OFFER_VIEW','offer/');
define('OFFER_UPLOADS','uploads/offer/'); 