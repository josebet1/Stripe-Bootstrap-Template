<?php

	require '../lib/Stripe.php'; 				/* Stripe Library - Download and place on your server */
	require '../include/db_inc.php'; 	/* Database login info & Company Constants */
	
	/*  Initialize variables */
	Stripe::setApiKey($ApiKey);
  $error	 = '';
  $success = '';
	/* Sanitize all external data first */
	$client_number			= htmlspecialchars(mysql_real_escape_string($_POST['client-number']));
	$card_name 					= htmlspecialchars(mysql_real_escape_string($_POST['card-name']));
	$card_address1 			= htmlspecialchars(mysql_real_escape_string($_POST['card-address-1']));
	$card_address2 			= htmlspecialchars(mysql_real_escape_string($_POST['card-address-2']));
	$card_city 					= htmlspecialchars(mysql_real_escape_string($_POST['card-city']));
	$card_address_state = htmlspecialchars(mysql_real_escape_string($_POST['card-address-state']));
	$card_address_zip 	= htmlspecialchars(mysql_real_escape_string($_POST['card-address-zip']));
	$card_phone 				= htmlspecialchars(mysql_real_escape_string($_POST['card-phone']));
	$card_email 				= htmlspecialchars(mysql_real_escape_string($_POST['card-email']));

	/* Set ipaddr to client ip address */
	/* Some shared SSL servers proxy from website (1and1) */
	if (strlen($_ENV['HTTP_X_FORWARDED_FOR']) > 1) {
		$ipaddr = $_ENV['HTTP_X_FORWARDED_FOR'];  /* Server is proxying for us */
	} else {
		$ipaddr = $_SERVER['REMOTE_ADDR'];				/* No proxy this is the client ip */
	}	
	
	/*======================================*/		
	/*     Try and Process the sale here    */		
	/*======================================*/		
  try {
		if (!isset($_POST['stripeToken']))
      throw new Exception("The Stripe Token was not generated correctly");
    $ch= Stripe_Charge::create(array("amount" => $_POST['stripe-amount'],
				"description" => "Client:".$client_number." - Payee:".$card_name." - Email:".$card_email." - Phone:".$card_phone,
        "currency" => "usd",
        "card" => $_POST['stripeToken']));
	} /* /try - Catch Stripe Process errors here */
  catch (Exception $e) {
		/* Stripe processing error. Tell the user, email the admin, then stop. */
    $error = $e->getMessage();
		echo "Sorry, something went wrong. Your payment was not processed. Please contact ".$company." at Phone: ".$phone. " or email: ".$email." for help with this payment.\r\n Error Message: ". $error;
		mail ($AdminEmail, "Error Processing ".$Company." Stripe Payment", $error); /* Send Error for debug - Problem processing payment */ 
		die(); /* Stop PHP Processing Now */
  } /* /catch */


	/*===========================================================*/
	/* Payment Successfull try and create a receipt and email it */
	/*===========================================================*/
	try {
		/* Write data to your database log here */
		$amount 					= $ch->amount/100; 
		$fee 							= $ch->fee/100;
		$amount_formatted = '$'.money_format('%(#6.2n',$amount);
		
		if (!mysql_connect($hostname,$username, $password)) 
		 throw new Exception("Unable to connect to the database server while creating receipt.");
		if (!mysql_select_db($dbname))
		 throw new Exception("Unable to select the database while creating receipt.");
		
		$query_dblog = "INSERT INTO payments (paymentdate, clientnum, amount, fee, approvalcode, name, 
																					address1, address2, city, state, 
																					zip, phone, email, ipaddress, testmode) 
										VALUES (NOW(), '".$client_number."',".$amount.",".$fee.",'".$ch->id."','".$card_name."',
																				'".$card_address1."','".$card_address2."','".$card_city."','".$card_address_state."',
																				'".$card_address_zip."','".$card_phone."','".$card_email."','".$ipaddr."',".intval($testmode).")";
		
		mail ($AdminEmail, $Company."Stripe Database Debug Log", $query_dblog); //Send Log for debug - DB insert not working in live mode. 
			
		$result_dblog = mysql_query($query_dblog);
		
		/* Fetch the auto generated id as the Invoice Number */
		$query_invnum = "SELECT * FROM payments WHERE approvalcode = '$ch->id'";
		$result_invnum = mysql_query($query_invnum);
		$row_invnum = mysql_fetch_array($result_invnum);
		$rowcount_invnum = mysql_num_rows($result_invnum);

		/* Send E-Mail Receipt */
		ini_set('sendmail_from', $Email); 
		
$receipt_text = <<<END
=======================================================
Receipt for {$card_name}

Receipt Number: {$row_invnum['id']}
Date: {$row_invnum['paymentdate']}

-------------------------------------------------------
Client # / Case Name:
{$client_number}

Payee:
{$card_name}
{$card_address_1}
{$card_address_2}
{$card_city} {$card_address_state} {$card_address_zip}

-------------------------------------------------------
Amount Paid: {$amount_formatted}
-------------------------------------------------------


=======================================================
{$Company}          
{$Phone}				 
{$Email}
{$WebSite}                       
=======================================================
END;
		
		
		/* Email the receipt here */
		mail($card_email, "Receipt for payment to ".$Company, $receipt_text, "From: ".$Email."\r\nReply-To: ".$Email."\r\nBcc: ".$Email);
		
		
		if ($Debug) { //If you are debugging, stay here at the end of the process page.
			echo 'Your payment was successful. Click <a href="approved.php">here</a> to view approved page.';
		} else { //You are not debugging, proceed on to the fancy approved page.
			//Take customer to Approved page with receipt
			header('Location: approved.php');
	  } // end-if ($debug)
	
	} /* /Try Catch receipt and email errors here */
  catch (Exception $e) {
    $error = $e->getMessage();
  } /* /catch */

	/* Dropped though, display an error to the user. */
	if (strlen($error)) {
		echo "Sorry, something went wrong while generating your receipt. Your payment was processed successfully. Do not re-attempt. Please contact ".$company." at Phone: ".$phone. " or email: ".$email." to confirm this payment was successful.";
		echo "Error:" . $error;
		mail ($AdminEmail, "Error Processing ".$Company." Stripe Payment", $error); /* Send Error for debug - Problem processing payment */ 

	}
  
?>
