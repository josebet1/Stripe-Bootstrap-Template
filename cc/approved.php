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
      <div class="well">
        <div class="row">
          <div class="span3"> <img src="../img/<?=$Logo?>" /></div>
          <div class="span8">
            <h1><?=$Company?></h1>
            <h2>Secure Payments</h2>
            <h3>Payment Successful</h3>
            <h3>Thank You</h3>
            <p>Your receipt has been emailed. Click <a href="<?=$WebUrl?>">here</a> to return to the home page</p>
            
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
        </div>
        <!--/span8-->
      </div>
      <!--/row-->
	</div>
  <!--/row-fluid-->
</div>
<!--/container-fluid-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
</body>
</html>
