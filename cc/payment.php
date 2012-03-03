<? require '../include/db_inc.php'; ?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?=$Company?> - Secure Payments</title>
<meta name="description" content="<?=$Company?> - Secure Payments">
<? //<meta name="viewport" content="width=device-width, initial-scale=1.0">
//<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" />
?>
<meta name = "viewport" content = "width = device-width">
<link href="../css/bootstrap.min.css" rel="stylesheet">
<style type="text/css">
body {
	background:url(../img/white_texture.png);
	padding-top: 60px;
	padding-bottom: 40px;
}
.sidebar-nav {
	padding: 9px 0;
}
</style>
<link href="../css/bootstrap-responsive.min.css" rel="stylesheet"> 
<!-- Le fav and touch icons -->
<? /*
<link rel="shortcut icon" href="/favicon.ico">
<link rel="apple-touch-icon" href="images/apple-touch-icon.png">
<link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-72x72.png">
<link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-114x114.png">
*/ ?>
<script type="text/javascript" src="https://js.stripe.com/v1/"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javascript" src="../js/bootstrap.min.js"></script>
<!--[if IE 6]>
<script type="text/javascript">var IE6UPDATE_OPTIONS = { icons_path: "../img/" }</script>
<link rel="stylesheet" type="text/css" href="ie6.css" />
<script type="text/javascript" src="ie6.js"></script>
<script type="text/javascript" src="ie6update.js"></script>
<![endif]-->

<!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
<!--[if lt IE 9]>
      <script src="https://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
<!-- Le styles -->
<script type="text/javascript">Stripe.setPublishableKey('<? echo $PublishableKey ?>');</script>
<script type="text/javascript" src="../js/payment.js"></script>
</head>
<body>
<div class="container">
    <div class="span9">
      <!-- Show JavaScript Error. Hide with JavaScript to prove JavaScript is available -->
      <noscript>
      <div class="alert alert-error fade in" id="nojs">
      	<a class="close" id="alert-message" data-dismiss="alert" href="#">&times;</a>
        <h2>Browser Error - JavaScript Required</h2>
        <p>JavaScript must be enabled in order for you to use this page. However, it seems JavaScript is either disabled or not supported by your browser. To use this page, enable JavaScript by changing your browser <a href="https://support.google.com/bin/answer.py?hl=en&answer=23852" target="_blank">options</a> or Allow <span class="label label-info"><?=$_SERVER['SERVER_NAME']?></span>, <span class="label label-info"><?=$_SERVER['HTTP_X_FORWARDED_SERVER']?></span> (our servers) and <span class="label label-info">stripe.com</span> (our cc processor) in your browser add-on <a href="http://noscript.net">No Script</a>, <a href="http://code.google.com/p/scriptno/">ScriptNo</a>, etc. then try again.</p>
      </div><!--/class alert-error-->
      </noscript>
			<? if ($testmode) { ?>
      <? /* <!-- IF TEST MODE Enabled in db_inc.php this message is displayed and Test Stripe Key is used. --> */ ?>
      <div class="alert alert-info fade in">
	      <a class="close" id="alert-message" data-dismiss="alert" href="#">&times;</a>
        <h2>Test Mode Enabled</h2><p>Testing mode is enabled. No Live credit cards will be processed. Please use the test mode sample Credit Card number, CVC and date to perform a test sale. Don't forget to purge the test sales from the Purchase Log.</p><p>Test CC# <span class="label label-info">4242424242424242</span> - CVC: <span class="label label-info">111</span> - Date: <span class="label label-info"><?=Date("m / Y",mktime(0,0,0,date("m")+1,date("d"),date("Y")))?></span></p><p>IP Address <span class="label label-info"><?=$_SERVER['REMOTE_ADDR']?></span> - Proxy Address <span class="label label-info"><?=$_ENV['HTTP_X_FORWARDED_FOR']?></span></p>
       </div><!--/class alert-info-->
       <? } ?>
     
    <div class="page-header">
    	<div class="well">
        <div class="row">
          <div class="span8">
            <img src="<?=$Logo?>" style="float:left;margin:0 15px 0 0;" />
            <h1><?=$Company?></h1>
            <h2>Secure Payments</h2>
            <h3>Visa, MasterCard, American&nbsp;Express, Discover, JCB and Diners&nbsp;Club</h3>
            <p>You will receive a receipt via email for your payment. <strong>We do not store any credit card information.</strong> You must re-enter your information for each payment.</p>
            </div>
      </div><!--/row-->
		</div><!--/well-->
	</div><!--/page-header-->


      <div class="row">
        <div class="span10">
          <form class="form-horizontal" action="process_payment.php" method="POST" id="payment-form">

            <fieldset>

            <legend>If you have questions, please call the office <?=$Phone?></legend>
            
            <div class="control-group">
              <label class="control-label" for="input01">Client # or Case Name </label>
              <div class="controls">
               <input type="text" id="client-number" name="client-number" class="input-xlarge" placeholder="Which account is this payment for">
              </div>
            </div>

            <div class="control-group">
              <label class="control-label" for="input02">Amount of payment</label>
              <div class="controls">
              <div class="input-prepend">
               <span class="add-on">$</span>
               <input type="text" id="card-amount" name="card-amount" class="input-small">
							</div>
              </div>
            </div>

            <div class="control-group">
              <label class="control-label" for="input03">Full Name on Card</label>
              <div class="controls">
               <input type="text" id="card-name" name="card-name" class="input-xlarge">
              </div>
            </div>

            
            <div class="control-group">
              <label class="control-label" for="input04">Card Number</label>
              <div class="controls">
               <input type="text" id="card-number" name="card-number" class="input-medium" placeholder="Numbers only, no dashes needed">
              </div>
            </div>

            
            <div class="control-group">
              <label class="control-label" for="input05">CVC Number</label>
              <div class="controls">
               <input type="text" id="card-cvc" name="card-cvc" class="input-mini" placeholder="NNN">
              </div>
            </div>

            
            <div class="control-group">
              <label class="control-label" for="input06">Expiration Date (mm/yyyy)</label>
              <div class="controls">
               <input type="text" id="card-expiry-month" class="input-mini" placeholder="MM"> / <input type="text" id="card-expiry-year" name="card-expiry-year" class="input-mini" placeholder="YYYY">
              </div>
            </div>

            
            <div class="control-group">
              <label class="control-label" for="input07">Billing Address</label>
              <div class="controls">
               <input type="text" id="card-address-1" name="card-address-1" class="input-xlarge">
              </div>
            </div>

            
            <div class="control-group">
              <label class="control-label" for="input08">Address Continued</label>
              <div class="controls">
               <input type="text" id="card-address-2" name="card-address-2" class="input-xlarge">
              </div>
            </div>

            
            <div class="control-group">
              <label class="control-label" for="input09">City</label>
              <div class="controls">
               <input type="text" id="card-city" name="card-city" class="input-large">
              </div>
            </div>

            
            <div class="control-group">
              <label class="control-label" for="input10">State</label>
              <div class="controls">
               <input type="text" id="card-address-state" name="card-address-state" class="input-mini">
              </div>
            </div>

            
            <div class="control-group">
              <label class="control-label" for="input11">Zip</label>
              <div class="controls">
               <input type="text" id="card-address-zip" name="card-address-zip" class="input-small">
              </div>
            </div>

            
            <div class="control-group">
              <label class="control-label" for="input12">Phone Number</label>
              <div class="controls">
               <input type="text" id="card-phone" name="card-phone" class="input-medium">
              </div>
            </div>

            
            <div class="control-group">
              <label class="control-label" for="input13">Email Address</label>
              <div class="controls">
               <input type="text" id="card-email" name="card-email" class="input-medium">
              </div>
            </div>

            <div class="control-group">
              <label class="control-label" for="input14">Confirm Email Address</label>
              <div class="controls">
               <input type="text" id="card-email2" name="card-email2" class="input-medium">
              </div>
            </div>

            <div class="control-group">
              <label class="control-label" id="submit-label" for="input15">Unable to submit</label>
              <div class="controls">
		        		<button type="submit" id="submit-button" class="submit-button btn btn-primary" disabled>Javascript Required</button>
              </div>
            </div>
    
            <div class="control-group">
               		<h2><span class="payment-errors"></span></h2>
            </div>

    
            </fieldset>

          </form>
      </div>
      <!--/row-->
	</div>
  <!--/row-fluid-->
</div>
<!--/container-fluid-->

</head>

</body>
</html>
