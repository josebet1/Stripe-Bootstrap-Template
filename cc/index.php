<?
require '../include/db_inc.php';
//$using_old_ie = (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 6.') !== FALSE); 
//$using_old_ie = (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 7.') !== FALSE); 
if ($using_old_ie) {
	$payment = $WebUrl;
	$redirect_text = "Sorry, Interner Explorer 6 is not supported for secure payments. Please <a href='http://microsoft.com/ie'>upgrade</a> your browser to IE8+ (<a href='http://google.com/chrome'>Chrome</a> or <a href='http://getfirefox.com'>Firefox</a> preferred). Redirecting to our home page.";
} else {
	$redirect_text = "Redirecting to ".$Company." secure site";
	header('location: '$payment); 
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="refresh" content="10;URL=<?=$payment?>" />
<title><?=$redirect_text?></title>
</head>

<body>
<p><?=$redirect_text?> <br /><br />Click <a href="<?=$payment?>">here</a> if your browser does not redirect you.</p>
</body>
</html>
