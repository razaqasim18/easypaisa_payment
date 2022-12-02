<?php 
    @$status = $_GET['status'];
    @$orderRefNumber = $_GET ['orderRefNumber'];
	@$paymentMethod = $_GET ['paymentMethod'];

    
   

	if (!(is_null($status))) {
		if ($status == '0000') {       
			echo "Payment  Received";
			if($paymentMethod == 'OTC'){
				echo "Payment  Received but pending";
			} else {
				echo "Payment  Received succeddfully";			
			}      
		
		} else {
			echo "Payment Not Received";
		}
	}
   
