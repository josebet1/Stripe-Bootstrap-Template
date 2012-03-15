<?php

	/* Use this script to process a token into a payment. */
	/*  Situation on a live transaction with an error on the process_payment.php page, we already had the token so it was simple to use this to finish the payment. */

	require 'lib/Stripe.php'; 				/* Stripe Library - Download and place on your server */
	require '../include/db_inc.php'; 	/* Database login info & Company Constants */
	
	/*  Initialize variables */
	Stripe::setApiKey($ApiKey);
  $error	 = '';
  $success = '';
	
	$stripe_amount = "1299";
	$stripe_token = "tok_xxxxxxxxxxxxxxx";
	
	
	/*======================================*/		
	/*     Try and Process the sale here    */		
	/*======================================*/		
  try {
		if (!isset($stripe_token))
      throw new Exception("The Stripe Token was not generated correctly");
    $ch= Stripe_Charge::create(array("amount" => $stripe_amount,
				"description" => "Manually Processed",
        "currency" => "usd",
        "card" => $stripe_token));
	} /* /try - Catch Stripe Process errors here */
  catch (Exception $e) {
		/* Stripe processing error. Tell the user, email the admin, then stop. */
    $error = $e->getMessage();
		echo "Sorry, something went wrong. Your payment was not processed. Please contact ".$company." at Phone: ".$phone. " or email: ".$email." for help with this payment.\r\n Error Message: ". $error;
		mail ($AdminEmail, "Error Processing ".$Company." Stripe Payment", $error); /* Send Error for debug - Problem processing payment */ 
		die(); /* Stop PHP Processing Now */
  } /* /catch */
echo "Done."
?>
