<?php 
include 'config.php';
    $storeId = storeId;
    $daysToExpire = daysToExpire;

	$liveVal = live;
	$easypayIndexPage = '';
	if ($liveVal == 'no') {
		$easypayIndexPage = 'https://easypaystg.easypaisa.com.pk/tpg/';
	} else {
		$easypayIndexPage = 'https://easypay.easypaisa.com.pk/tpg/';
	}

    $merchantConfirmPage = UrlBack;

    $orderId = $_GET['orderId'];
	if (strpos($_GET['amount'], '.') !== false) {
		$amount = $_GET['amount'];
	} else {
		$amount = sprintf("%0.1f",$_GET['amount']);
	}
	
	@$custEmail = $_GET['custEmail'];
	@$custCell = $_GET['custCell'];
	$hashKey = hashKey;
	date_default_timezone_set('Asia/Karachi');
	$expiryDate = '';
	$currentDate = new DateTime();
	if($daysToExpire != null) {
		$currentDate->modify('+'.$daysToExpire.'day');
		$expiryDate = $currentDate->format('Ymd His');
	}
	
	
	$paymentMethodVal = methods;
	
	$hashRequest = '';
	if(strlen($hashKey) > 0 && (strlen($hashKey) == 16 || strlen($hashKey) == 24 || strlen($hashKey) == 32 )) {
		// Create Parameter map
		$paramMap = array();
		$paramMap['amount']  = $amount ;
		if($custEmail != null && $custEmail != '') {
			$paramMap['emailAddress']  = $custEmail ;
		}
		if($expiryDate != null && $expiryDate != '') {
			$paramMap['expiryDate'] = $expiryDate;
		}
		if($paymentMethodVal != null && $paymentMethodVal != '') {
			$paramMap['merchantPaymentMethod']  = $paymentMethodVal ;
		}
		if($custCell != null && $custCell != '') {
			$paramMap['mobileNum'] = $custCell;
		}
		$paramMap['orderRefNum']  = $orderId ;
		$paramMap['paymentMethod']  = "InitialRequest" ;
		$paramMap['postBackURL'] = $merchantConfirmPage;
		$paramMap['storeId']  = $storeId ;
		$paramMap['timeStamp']  = date("Y-m-d\TH:i:00") ;
		
		//Creating string to be encoded
		$mapString = '';
		foreach ($paramMap as $key => $val) {
			$mapString .=  $key.'='.$val.'&';
		}
		$mapString  = substr($mapString , 0, -1);
		
		// Encrypting mapString
		
		$cipher = "aes-128-ecb";
		$crypttext = openssl_encrypt($mapString, $cipher, $hashKey,OPENSSL_RAW_DATA);
		$hashRequest = base64_encode($crypttext);
	}
	


?>

<form name="easypayform" method="get" action="<?php echo $easypayIndexPage ?>">
    <input name="storeId" value="<?php echo $storeId ?>" hidden = "true"/>
    <input name="orderId" value="<?php echo $orderId ?>" hidden = "true"/>
    <input name="transactionAmount" value="<?php echo $amount ?>" hidden = "true"/>
    <input name="mobileAccountNo" value="<?php echo $custCell ?>" hidden = "true"/>
    <input name="emailAddress" value="<?php echo $custEmail ?>" hidden = "true"/>
    <input name="transactionType" value="InitialRequest" hidden = "true"/>
    <?php if ($expiryDate != '' && $expiryDate != null) { ?>
		<input name="tokenExpiry" value="<?php echo $expiryDate ?>" hidden = "true"/>
	<?php } ?>
    <input name="bankIdentificationNumber" value="" hidden = "true"/>
    <input name="encryptedHashRequest" value="<?php echo $hashRequest ?>" hidden = "true"/>
    <input name="merchantPaymentMethod" value="<?php echo $paymentMethodVal ?>" hidden = "true"/>	
    <input name="postBackURL" value="<?php echo $merchantConfirmPage ?>" hidden = "true"/>
    <input name="signature" value="" hidden = "true"/>

</form>

<script data-cfasync="false" type="text/javascript">
    document.easypayform.submit();
</script>
