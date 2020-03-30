<?PHP
ini_set("log_errors", "On");
ini_set("error_log", "errors_all.txt");

session_start();
$ylaa_curr = 'AED';
$urlproto='http://';
//$ylaa_email_URL='http://ylaa.com/';
$ylaa_email_URL='https://ylaa.com/';
$ylaa_email_disclaimer_URL='https://ylaa.com';
// it is used in userconfirmation.php end of file
$url_fwd_link='Location: user-profile';
$fwd_on_logout='Location: https://ylaa.com/';
$fwd_url_login='Location: signin';


function do_url_txt($urltxt) {
	$newurltxt=str_replace(" ","-",$urltxt);
	$newurltxt=str_replace(".","",$newurltxt);
	$newurltxt=str_replace("&-","",$newurltxt);
	$newurltxt=str_replace("<b>","",$newurltxt);
	$newurltxt=str_replace("</b>","",$newurltxt);
	$newurltxt=str_replace("/-","",$newurltxt);
	$newurltxt=str_replace("%","",$newurltxt);
	$newurltxt=str_replace("(","",$newurltxt);
	$newurltxt=str_replace(")","",$newurltxt);
	$newurltxt=strtolower($newurltxt);
	return $newurltxt;
}

function job_txt_en($protxt) {
	$newprotxt=str_replace(" ","-",$protxt);
	$newprotxt=str_replace("&-","and-",$newprotxt);
	$newprotxt=str_replace("/-","or-",$newprotxt);
	return $newprotxt;
}

function job_txt_dc($protxt) {
	$newprotxt=str_replace("-"," ",$protxt);
	$newprotxt=str_replace("and ","& ",$newprotxt);
	$newprotxt=str_replace("or ","/ ",$newprotxt);
	return $newprotxt;
}


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
if(file_exists('PHPMailer/src/PHPMailer.php')) {
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
}
if(file_exists('../PHPMailer/src/PHPMailer.php')) {
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
}



	
function ymaildo($use_ac, $yto, $ysubj, $yattach, $ybody) {
if(strtolower($_SERVER['SERVER_NAME'])=='localhost') {
	
if($use_ac=='noreply') {
	$yreplyto = '';
$mail = new PHPMailer(); // create a new object

$mail->IsSMTP(); // enable SMTP
//$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
$mail->SMTPAuth = true; // authentication enabled
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // secure transfer enabled REQUIRED for Gmail
$mail->Host = 'techinnsolutions.net';
$mail->Port = 465; // or 587
$mail->IsHTML(true);
$mail->Username = 'ceo@techinnsolutions.net';
$mail->Password = 'Godisgreat@134';
$mail->SetFrom('ceo@techinnsolutions.net','ceo@techinnsolutions.net');
if($yreplyto!=''){ $mail->addReplyTo($yreplyto); }
$mail->Subject = $ysubj;
$mail->Body = $ybody;
$mail->AddAddress($yto);
}
 if(!$mail->Send()) {  echo "Mailer Error: " . $mail->ErrorInfo; return true; } else {  /*echo "Message has been sent";*/ return false; }
}
}

function mails($mailSMTPSecure, $mailHost, $mailPort, $mailUsername, $mailPassword, $mailSetFrom1, $mailSetFrom2, $use_ac, $yto, $ysubj, $yattach, $ybody) {
if(strtolower($_SERVER['SERVER_NAME'])=='localhost') {
$mail = new PHPMailer(); // create a new object
$mail->IsSMTP(); // enable SMTP
//$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
$mail->SMTPAuth = true; // authentication enabled
$mail->SMTPSecure = $mailSMTPSecure; // secure transfer enabled REQUIRED for Gmail
$mail->Host = $mailHost;
$mail->Port = $mailPort; // or 587
$mail->Username = $mailUsername;
$mail->Password = $mailPassword;
$mail->SetFrom($mailSetFrom1,$mailSetFrom2);
$mail->IsHTML(true);
if($yreplyto!=''){ $mail->addReplyTo($yreplyto); }
$mail->Subject = $ysubj;
$mail->Body = $ybody;
if($yattach!='') { $mail->addAttachment($yattach, $yattach); }
$mail->AddAddress($yto);
 if(!$mail->Send()) { /*echo "Mailer Error: " . $mail->ErrorInfo;*/ return true; } else { /*echo "Message has been sent";*/ return false; }
}

}


?>