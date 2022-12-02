# Easypaisa Payment Gateway custom code PHP
Easypaisa is Local Pakistani online payment Gateway, Working smoothly and best servises for Online Business like E-commerce etc.
I will here Guide you how you can Use  this Gateway.
#Step 1
Open config.php 
open config.php and provide your store information 

<?php
define("storeId", ""); //Store ID
define("daysToExpire", "2");  // Token Expiry Day
define("live", "no"); // yes if live
define("hashKey", ""); //hash key provided by Easypay
define("methods", ""); 
//MA_PAYMENT_METHOD
//OTC_PAYMENT_METHOD
//MA_PAYMENT_METHOD
//CC_PAYMENT_METHOD
//empty To use all
define("UrlBack", "http://localhost:8090/payfund/statusEasypay.php"); // URL where response returned 
?>

#step 2
run index.php for Good experience with Easypay

#Thanks
M.Younis Panwar
unis.panwar@gmail.com
