<? 
require '../include/db_inc.php';

if ($_GET['delid']) {
	$del = mysql_query('DELETE FROM payments WHERE id='.$_GET['delid'].' LIMIT 1');
	header('Location: purchase_log.php');
}

ini_set('display_errors', 'On');
setlocale(LC_MONETARY, 'en_US');

$Log1 = mysql_query('SELECT * FROM payments ORDER BY id DESC');

$folder = str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['PHP_SELF']);
$url    = sprintf('https://%s%s', $_SERVER['SERVER_NAME'], $folder); /* used for AJAX callback */
?> 
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?=$Company?> - Secure Purchase Log</title>
    <meta name="description" content="<?=$Company?> - Secure Purchase Log">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
    <!--[if lt IE 9]>
      <script src="https://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le styles -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <style type="text/css">
      body {
				background:url(../img/stucco.png);
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
    <div class="container-fluid">
      <div class="row-fluid">
  
         <div class="span9">

      <div class="well">
        <div class="row">
          <div class="span3"> <img src="<?=$Logo?>" /></div>
          <div class="span8">
            <h1><?=$Company?></h1>
            <h2>Secure Payment Log</h2>
          </div>
          <!--/span8-->
        </div>
        <!--/row-->
      </div>
      <!--/well-->



<table class="table table-striped">
<thead>
  <tr>
    <th>Inv#</th>
    <th>Date</th>
    <th>Payee</th>
    <th>$ Amount</th>
    <th>$ Fee</th>
    <th>$ Net</th>
    <th>Client # / Case Name</th>
    <th>Stripe</th>
</thead>
  </tr>
  	          	<!--- BEGIN LOOP --->
							<? while ($l = mysql_fetch_assoc($Log1)) { ?>
  <tr>
    <td><a href="purchase_log.php?delid=<?=$l['id']?>"><i class="icon-remove" rel="a" title="Delete Receipt" data-content="Delete Receipt #<?=$l['id']?>" ></i></a> <?=$l['id']?>
    <i class="icon-flag" rel="a" title="Purchase Details  <?=date('g:iA', strtotime($l['paymentdate']));?>" data-content="
    <?
		if (strlen($l['address1'])) echo '<br>Address1: '.$l['address1']; 
		if (strlen($l['address2'])) echo '<br>Address2: '.$l['address2']; 
		if (strlen($l['city'])) echo '<br>City: '.$l['city'];
		if (strlen($l['state'])) echo ' St: '.$l['state'];
		if (strlen($l['zip'])) echo ' Zip: '.$l['zip'];
		if (strlen($l['phone'])) echo '<br>Phone: '.$l['phone']; 
		if (strlen($l['ipaddress'])) echo '<br>IP: '.$l['ipaddress']; 

		?>"></i>
    
    </td>
    <td><? echo date('n/j/Y', strtotime($l['paymentdate']));?></td>
    <td><? echo '<a href="mailto:'.$l['email'].'">'.$l['name'].'</a>'; ?></td>
    <td><? echo money_format('%(#6.2n',$l['amount'])?></td>
    <td><? echo money_format('%(#6.2n',$l['fee'])?></td>
    <td><? echo money_format('%(#6.2n',((floatval($l['amount'])) - (floatval($l['fee'])))) ?></td>

    <td><? if (strlen($l['clientnum'])) echo $l['clientnum']; ?></td>
    <? $s_url="https://manage.stripe.com/"; if ($l['testmode']) {$s_url .= "#test/";} $s_url .= "payments/".$l['approvalcode']; ?>
    <td><a href="<?=$s_url?>" class="btn btn-small">Details</a></td>

  </tr>
 <? } ?> <!--- END LOOP --->
 </div>
</table>

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>

<script type="text/javascript">
$(document).ready(function() {
  $('a[rel]').popover();
  $('i[rel]').popover();
	$('.dropdown-toggle').dropdown();
});
</script>
</div> <!-- row-fluid -->
</div> <!-- container -->

</body>
</html>
