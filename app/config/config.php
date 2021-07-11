<?php
session_start();

//check if page is not index, then unset anime
if (strpos($_SERVER['REQUEST_URI'], "pages/index") === false){
unset($_SESSION['anime']);
}

require '../public/mobiledetect/Mobile_Detect.php';

$detect = new Mobile_Detect;
 
// Any mobile device (phones or tablets).
if ( $detect->isMobile() ) {
    header('location: http://mobilereport.dailyhackstore.co.ke');
}
 
// Any tablet device.
if( $detect->isTablet() ){
        header('location: http://mobilereport.dailyhackstore.co.ke');

}
 
// Exclude tablets.
if( $detect->isMobile() && !$detect->isTablet() ){
        header('location: http://mobilereport.dailyhackstore.co.ke');

}
 
// Check for a specific platform with the help of the magic methods:
if( $detect->isiOS() ){
 
}
 
if( $detect->isAndroidOS() ){
 
}
 
// Alternative method is() for checking specific properties.
// WARNING: this method is in BETA, some keyword properties will change in the future.
$detect->is('Chrome');
$detect->is('iOS');
$detect->is('UC Browser');
// [...]
 
// Batch mode using setUserAgent():
$userAgents = array(
'Mozilla/5.0 (Linux; Android 4.0.4; Desire HD Build/IMM76D) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.166 Mobile Safari/535.19',
'BlackBerry7100i/4.1.0 Profile/MIDP-2.0 Configuration/CLDC-1.1 VendorID/103',
// [...]
);
foreach($userAgents as $userAgent){
 
  $detect->setUserAgent($userAgent);
  $isMobile = $detect->isMobile();
  $isTablet = $detect->isTablet();
  // Use the force however you want.
 
}
 
// Get the version() of components.
// WARNING: this method is in BETA, some keyword properties will change in the future.
$detect->version('iPad'); // 4.3 (float)
$detect->version('iPhone'); // 3.1 (float)
$detect->version('Android'); // 2.1 (float)
$detect->version('Opera Mini'); // 5.0 (float)

//db params
DEFINE('DB_HOST', 'localhost');
DEFINE('DB_USER', 'dailyreport');
DEFINE('DB_PASS', 'Gazaslim5');
DEFINE('DB_NAME', 'daily_report');

//mail params
define("MAIL_HOST", "mail.dailyhackstore.co.ke");
define("MAIL_USERNAME", "info@dailyhackstore.co.ke");
define("MAIL_PASS", "Gazaslim5?");
define("MAIL_SMTP", "ssl");
define("MAIL_PORT", "465");

//app route
define('APPROOT', dirname(dirname(__FILE__)));
//url root https://8c761d381b02.ngrok.io/principals-archive
define('URLROOT', 'http://localhost/report-holics');
//site name
define('SITENAME', 'Daily Report');

define('SITE_DESCRIPTION', 'daily report holics');

define('DEFAULT_TITLE', 'Daily Report');

define('OG_URL', 'https://report.dailyhackstore.co.ke');

define('SITE_AUTHOR', 'holics');

define('SITE_TYPE', 'website');

define('THEME_COLOR', '#047aed');

define('PRINCIPAL_MAIL', '');

define('ABOUT_US', '');


        