<?php
require_once ("../../config.php");
require_once ("../../library/classes.php");
require_once(dirname(__FILE__).'/../payment/sofortLibSofortueberweisung.inc.php');

// enter your configuration key – you only can create a new configuration key by creating
// a new Gateway project in your account at sofort.com
$configkey = '150445:351897:9f28f1dfe19818045555555555555555';   // change config key

$Sofortueberweisung = new Sofortueberweisung($configkey);
$Sofortueberweisung->setAmount($_REQUEST['amount']);
$Sofortueberweisung->setCurrencyCode('EUR');
//$Sofortueberweisung->setSenderSepaAccount('', '', 'Max Mustermann');
$Sofortueberweisung->setSenderCountryCode('DE');
$Sofortueberweisung->setReason('Testueberweisung', 'Verwendungszweck');
$Sofortueberweisung->setSuccessUrl(SITEURL.'sofort-success.php', true);
$Sofortueberweisung->setAbortUrl(SITEURL.'sofort-cancel.php?order_number='.$_REQUEST['sofort_trans']);
$Sofortueberweisung->setNotificationUrl(SITEURL.'sofort-notification.php');

// $Sofortueberweisung->setNotificationUrl('http://www.google.de', 'loss,pending');
// $Sofortueberweisung->setNotificationUrl('http://www.yahoo.com', 'loss');
// $Sofortueberweisung->setNotificationUrl('http://www.bing.com', 'pending');
 //$Sofortueberweisung->setNotificationUrl(SITEURL.'sofort-success1.php', 'received');
// $Sofortueberweisung->setNotificationUrl('http://www.youtube.com', 'refunded');
// $Sofortueberweisung->setNotificationUrl('http://www.youtube.com', 'untraceable');
//$Sofortueberweisung->setNotificationUrl('http://www.twitter.com');
 
$Sofortueberweisung->setCustomerprotection(true);


$Sofortueberweisung->sendRequest();

if($Sofortueberweisung->isError()) {
	//SOFORT-API didn't accept the data
	echo $Sofortueberweisung->getError();
} else {
	$transactionId=$Sofortueberweisung->getTransactionId();
	$_SESSION['transaction_id']=$transactionId;
	$_SESSION['order_id']=$_REQUEST['sofort_trans'];
	$_SESSION['amount']=$_REQUEST['amount'];

	//buyer must be redirected to $paymentUrl else payment cannot be successfully completed!
	$paymentUrl = $Sofortueberweisung->getPaymentUrl();
	header('Location: '.$paymentUrl);
}

