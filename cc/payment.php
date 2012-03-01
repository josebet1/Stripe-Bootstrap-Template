<? require '../include/db_inc.php'; ?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?=$Company?> - Secure Payments</title>
<meta name="description" content="<?=$Company?> - Secure Payments">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
<!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
<!-- Le styles -->
<link href="../css/bootstrap.min.css" rel="stylesheet">
<style type="text/css">
body {
	padding-top: 60px;
	padding-bottom: 40px;
}
.sidebar-nav {
	padding: 9px 0;
}
</style>
<link href="../css/bootstrap-responsive.min.css" rel="stylesheet">
<!-- Le fav and touch icons -->
<link rel="shortcut icon" href="/favicon.ico">
<link rel="apple-touch-icon" href="images/apple-touch-icon.png">
<link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-72x72.png">
<link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-114x114.png">

</head>
<body>
<div class="container">
  <div class="row-fluid">
    <div class="span8">
      <!-- Show JavaScript Error. Hide with JavaScript to prove JavaScript is available -->
    	<div class="alert alert-error fade in" id="nojs">
      	<a class="close" id="alert-message" data-dismiss="alert" href="#">&times;</a>
        <h2>Browser Error - JavaScript Required</h2>
        <p>JavaScript must be enabled in order for you to use this page. However, it seems JavaScript is either disabled or not supported by your browser. To use this page, enable JavaScript by changing your browser options or Allow <span class="label label-info"><?=$_SERVER['SERVER_NAME']?></span>, <span class="label label-info"><?=$_SERVER['HTTP_X_FORWARDED_SERVER']?></span> (our servers) and <span class="label label-info">stripe.com</span> (our cc processor) in your browser add-on <a href="http://noscript.net">No Script</a>, <a href="http://code.google.com/p/scriptno/">ScriptNo</a>, etc. then try again.</p>
      </div>
			<? if ($testmode) { ?>
      <!-- IF TEST MODE Enabled Line 1 above, this message is displayed and Test Stripe Key is used. -->
      <div class="alert alert-info fade in">
	      <a class="close" id="alert-message" data-dismiss="alert" href="#">&times;</a>
        <h2>Test Mode Enabled</h2><p>Testing mode is enabled. No Live credit cards will be processed. Please use the test mode sample Credit Card number, CVC and date to perform a test sale. Don't forget to purge the test sales from the Purchase Log.</p><p>Test CC# <span class="label label-info">4242424242424242</span> - CVC: <span class="label label-info">111</span> - Date: <span class="label label-info"><?=Date("m / Y",mktime(0,0,0,date("m")+1,date("d"),date("Y")))?></span></p><p>IP Address <span class="label label-info"><?=$_SERVER['REMOTE_ADDR']?></span> - Proxy Address <span class="label label-info"><?=$_ENV['HTTP_X_FORWARDED_FOR']?></span></p>
       </div>
       <? } ?>
     
      <div class="well">
        <div class="row">
          <div class="span3"> <img src="../img/<?=$Logo?>" /></div>
          <div class="span8">
            <h1><?=$Company?></h1>
            <h2>Secure Payments</h2>
            <h3>Visa, MasterCard, American&nbsp;Express, Discover, JCB and Diners&nbsp;Club</h3>
            <p>You will receive a receipt via email for your payment. <strong>We do not store any credit card information.</strong> You must re-enter your information for each payment.</p>
          </div>
          <!--/span8-->
        </div>
        <!--/row-->
      </div>
      <!--/well-->




    </div>
    <!--/span10-->
    <div class="span8">
      <div class="row">
        <div class="span8">
          <form class="form-horizontal" action="process_payment.php" method="POST" id="payment-form">

            <fieldset>

            <legend>If you have questions, please call the office <?=$Phone?></legend>
            
            <div class="control-group">
              <label class="control-label" for="input01">Client # or Case Name </label>
              <div class="controls">
               <input type="text" id="client-number" name="client-number" class="span10">
                <p class="help-block">Please tell us which account this payment is for</p>
              </div>
            </div>

            <div class="control-group">
              <label class="control-label" for="input02">Amount of payment</label>
              <div class="controls">
              <div class="input-prepend">
               <span class="add-on">$</span>
               <input type="text" id="card-amount" name="card-amount" class="span2">
							</div>
              </div>
            </div>

            <div class="control-group">
              <label class="control-label" for="input03">Full Name on Card</label>
              <div class="controls">
               <input type="text" id="card-name" name="card-name" class="span8">
              </div>
            </div>

            
            <div class="control-group">
              <label class="control-label" for="input04">Card Number</label>
              <div class="controls">
               <input type="text" id="card-number" name="card-number" class="span8">
                <p class="help-block">Card numbers only, no hyphens or dashes needed</p>
              </div>
            </div>

            
            <div class="control-group">
              <label class="control-label" for="input05">CVC Number</label>
              <div class="controls">
               <input type="text" id="card-cvc" name="card-cvc" class="span2">
                <p class="help-block">CVC number printed on the back side, 3 digits</p>
              </div>
            </div>

            
            <div class="control-group">
              <label class="control-label" for="input06">Expiration Date</label>
              <div class="controls">
               <input type="text" id="card-expiry-month" id="card-expiry-month" class="span1"> / <input type="text" id="card-expiry-year" name="card-expiry-year" class="span2"/>
                <p class="help-block">MM / YYYY Expiration Date</p>
              </div>
            </div>

            
            <div class="control-group">
              <label class="control-label" for="input07">Billing Address</label>
              <div class="controls">
               <input type="text" id="card-address-1" name="card-address-1" class="span8">
              </div>
            </div>

            
            <div class="control-group">
              <label class="control-label" for="input08">Address Continued</label>
              <div class="controls">
               <input type="text" id="card-address-2" name="card-address-2" class="span8">
              </div>
            </div>

            
            <div class="control-group">
              <label class="control-label" for="input09">City</label>
              <div class="controls">
               <input type="text" id="card-city" name="card-city" class="span8">
              </div>
            </div>

            
            <div class="control-group">
              <label class="control-label" for="input10">State</label>
              <div class="controls">
               <input type="text" id="card-address-state" name="card-address-state" class="span6">
              </div>
            </div>

            
            <div class="control-group">
              <label class="control-label" for="input11">Zip</label>
              <div class="controls">
               <input type="text" id="card-address-zip" name="card-address-zip" class="span3">
              </div>
            </div>

            
            <div class="control-group">
              <label class="control-label" for="input12">Phone Number</label>
              <div class="controls">
               <input type="text" id="card-phone" name="card-phone" class="span8">
              </div>
            </div>

            
            <div class="control-group">
              <label class="control-label" for="input13">Email Address</label>
              <div class="controls">
               <input type="text" id="card-email" name="card-email" class="span8">
              </div>
            </div>

            <div class="control-group">
              <label class="control-label" for="input14">Ready to pay</label>
              <div class="controls">
		        		<button type="submit" class="submit-button btn btn-primary">Submit Payment</button>
              </div>
            </div>
    
            <div class="control-group">
               		<h2><span class="payment-errors"></span></h2>
            </div>

    
            </fieldset>

          </form>
        </div>
        <!--/span8-->
      </div>
      <!--/row-->
	</div>
  <!--/row-fluid-->
</div>
<!--/container-fluid-->
<script type="text/javascript" src="https://js.stripe.com/v1/"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<!--<script src="jquery-1.7.1.js"></script>-->
<script type="text/javascript" src="../js/bootstrap.min.js"></script>
<script type="text/javascript">
		var chargeAmount = 0;  //Create a global var to store the corrected non-decimal amount
            Stripe.setPublishableKey('<? echo $PublishableKey ?>'); 
            function stripeResponseHandler(status, response) {
                if (response.error) {
                    // re-enable the submit button
                    $('.submit-button').removeAttr("disabled");
                    // show the errors on the form
                    $(".payment-errors").html(response.error.message);
                } else {
                    var form$ = $("#payment-form");
                    // token contains id, last4, and card type
                    var token = response['id'];
	                  // insert the stripe non decimal payment amount
										form$.append("<input type='hidden' name='stripe-amount' value='" + chargeAmount + "' />");
                    // insert the token into the form so it gets submitted to the server
                    form$.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
										// and submit
                    form$.get(0).submit();
                }
            }

            $(document).ready(function() {
                document.getElementById('nojs').style.display="none";
								$("#payment-form").submit(function(event) {
 									 	//Clear any prior errors while authorizing
										$(".payment-errors").html('');
										
										//Verify any fields required to be filled (start at the top and work down)
										if ( $('#client-number').val()==null || $('#client-number').val()=="" )	{
                			$(".payment-errors").html("A Client # or Case Name is required");
   										document.getElementById('client-number').select();
 											return false;
  									}
										if ( $('#card-name').val()==null || $('#card-name').val()=="" )	{
                			$(".payment-errors").html("The Full Name from the Card is required");
   										document.getElementById('card-name').select();
											return false;
  									}
                    
										//Verify email address from form id="card-email"
										if ( !validateEmail( $('#card-email').val() ) ) {
   										document.getElementById('card-email').select();
											return false;
										}

										// disable the submit button to prevent repeated clicks
                    $('.submit-button').attr("disabled", "disabled");
                    //amount you want to charge, in cents. 1000 = $10.00, 2000 = $20.00 ...
										chargeAmount = (parseFloat($('#card-amount').val())*100).toFixed(); 
										// createToken returns immediately - the supplied callback submits the form if there are no errors
										Stripe.createToken({
                        name: $('#card-name').val(),
                        address_line1: $('#card-address-1').val(),
                        address_line2: $('#card-address-2').val(),
                        address_zip: $('#card-address-zip').val(),
                        address_state: $('#card-address-state').val(),
                        number: $('#card-number').val(),
                        cvc: $('#card-cvc').val(),
                        exp_month: $('#card-expiry-month').val(),
                        exp_year: $('#card-expiry-year').val()
                    }, chargeAmount, stripeResponseHandler);
                    return false; // submit from callback
                });
            });


						function validateEmail(email) {
							if (email==null || email=="")	{
                $(".payment-errors").html("An email address is required");
  							return false;
  						}

							emailRegex = /^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.(([a-z]{2}|AERO|ARPA|ASIA|BIZ|CAT|COM|COOP|EDU|GOV|INFO|INT|JOBS|MIL|MOBI|MUSEUM|NAME|NET|ORG|PRO|TEL|TRAVEL|XN--0ZWM56D|XN--11B5BS3A9AJ6G|XN--3E0B707E|XN--45BRJ9C|XN--80AKHBYKNJ4F|XN--90A3AC|XN--9T4B11YI5A|XN--CLCHC0EA0B2G2A9GCD|XN--DEBA0AD|XN--FIQS8S|XN--FIQZ9S|XN--FPCRJ9C3D|XN--FZC2C9E2C|XN--G6W251D|XN--GECRJ9C|XN--H2BRJ9C|XN--HGBK6AJ7F53BBA|XN--HLCJ6AYA9ESC7A|XN--J6W193G|XN--JXALPDLP|XN--KGBECHTV|XN--KPRW13D|XN--KPRY57D|XN--LGBBAT1AD8J|XN--MGBAAM7A8H|XN--MGBAYH7GPA|XN--MGBBH1A71E|XN--MGBC0A9AZCG|XN--MGBERP4A5D4AR|XN--O3CW4H|XN--OGBPF8FL|XN--P1AI|XN--PGBS0DH|XN--S9BRJ9C|XN--WGBH1C|XN--WGBL6A|XN--XKC2AL3HYE2A|XN--XKC2DL3A5EE0H|XN--YFRO4I67O|XN--YGBI2AMMX|XN--ZCKZAH|XXX)(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)|(^$)/i;

							if (!emailRegex.test(email)) {
                $(".payment-errors").html("The email address ("+email+") is invalid");
								return false;
							}
						return true;
						}
        </script>

</body>
</html>
