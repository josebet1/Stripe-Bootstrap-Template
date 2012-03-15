<?php
//Set Test mode 
$testmode = TRUE; //TRUE=Use Test Mode Stripe Keys, FALSE=Use LIVE Stripe Keys
$Debug = TRUE; //TRUE=Stay on process_payment.php page after completion, FALSE=Redirect to approved.php page after processing
//Additional Public IP address testmode overrides for development ip addresses
if ($_SERVER['REMOTE_ADDR'] == '0.1.2.3') $testmode = TRUE;
if ($_SERVER['REMOTE_ADDR'] == '0.1.2.4') $testmode = TRUE;
//Check the X_FORWARDED_FOR if server is using a proxy
if ($_ENV['HTTP_X_FORWARDED_FOR'] == '0.1.2.3') $testmode = TRUE;
if ($_ENV['HTTP_X_FORWARDED_FOR'] == '0.1.2.4') $testmode = TRUE;
//Connect To Database
$hostname       = "mysqldb.myserver.com";
$username       = "dbusername";
$password       = "verystrongpw";
$dbname         = "databasename";
$usertable      = "payments";
//Define your company
$Company        = "Sample Company, Inc"; 
$WebSite        = "www.mycompany.com";
$WebUrl         = "http://mycompany.com";
$Phone          = "(800) 555-1212";
$Email          = "sales@mycompany.com";
$Logo           = "logo.jpg";
//Secure payment.php link normally "https://mycompany.com/cc/payment.php";
$payment="https://mycompany.com/cc/payment.php";
//Where to send debug messages
$AdminEmail = "webmaster@mycompany.com";
//Stripe Keys
if ($testmode) { 
	/* Test Mode Key */
	$PublishableKey = 'pk_xzxzxzxzxzxzxzxzxzxzxzxzxzxzx';
	$ApiKey         = 'xzxzxzxzxzxzxzxzxzxzxzxzxzxzxzxz';
	} else { 
	/* Live Key */
	$PublishableKey = 'pk_xqxqxqxqxqxqxqxqxqxqxqxqxqxqx';
	$ApiKey         = 'xqxqxqxqxqxqxqxqxqxqxqxqxqxqxqxq';
} 

//MySQL Database Structure - Paste into SQL tab in phpmyadmin
/* Copy Below Here

DROP TABLE IF EXISTS `payments`;
CREATE TABLE `payments` (
  `id` int(11) NOT NULL auto_increment,
  `paymentdate` datetime NOT NULL,
  `clientnum` varchar(100) collate latin1_general_ci NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `fee` decimal(10,2) NOT NULL,
  `approvalcode` varchar(20) collate latin1_general_ci NOT NULL,
  `name` varchar(100) collate latin1_general_ci NOT NULL,
  `address1` varchar(100) collate latin1_general_ci NOT NULL,
  `address2` varchar(100) collate latin1_general_ci NOT NULL,
  `city` varchar(100) collate latin1_general_ci NOT NULL,
  `state` varchar(20) collate latin1_general_ci NOT NULL,
  `zip` varchar(10) collate latin1_general_ci NOT NULL,
  `phone` varchar(20) collate latin1_general_ci NOT NULL,
  `email` varchar(40) collate latin1_general_ci NOT NULL,
  `ipaddress` varchar(40) collate latin1_general_ci NOT NULL,
  `testmode` tinyint(1) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;
 
 Copy Above here  */

/* No Changes Below this line needed */

$conn = mysql_connect($hostname,$username, $password) ;

if (!$conn) {
    echo "Unable to connect to DB: " . mysql_error();
    exit;
}
  
if (!mysql_select_db($dbname)) {
    echo "Unable to select " .$dbname. " : " . mysql_error();
    exit;
}

if(!function_exists('createRandomPassword')) {
	function createRandomPassword($l) {
    $chars = "ABCDEFHIJJKLMNOPQRSTUVWXYZ*$-+?_&=!%{}/abcdefghijkmnopqrstuvwxyz023456789";
    srand((double)microtime()*1000000);
    $i=0;
		$pass='';
		while ($i++ < $l) {
        $pass .= substr($chars, rand() % strlen($chars), 1);
    }
    return $pass;
	}	
}

?>
