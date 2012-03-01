==============
   Overview
==============

	A simple template using the Twitter Bootstrap project and Stripe credit card processor.
	
	Everything you need is done, simply put your company information, MySQL database and
	Stripe Keys in the db_inc.php file. You are now ready to start taking credit card 
	payments directly on your web site. This is not meant to be a full featured cc processing
	project. Hopefully you can implement this on your site quickly to receive payments for
	services directly. 

	jeff@micro-ram.com
	
==============					
 Installation
==============

1.) Install the Stripe PHP API from https://stripe.com/docs/libraries
  
  Extract one of these into the /lib/ folder
   https://code.stripe.com/stripe-php-latest.tar.gz
   https://code.stripe.com/stripe-php-latest.zip
  

2.) Edit the index.php file to redirect properly to the SSL secured page. SSL is required on your
    server to use Stripe.
    See Stripe page https://stripe.com/help/ssl 


3.) Setup your MySQL Database. 
  
  Copy the MySQL Database Template from the db_inc.php file and paste it into your phpMyAdmin
  SQL tab in your database. (Future: Create an install.php file to check db and do this.)  


4.) Edit the /include/db_inc.php file

  This include file contains all of the settings for your Stripe account, MySQL database, and
  general company information. There are also booleans and fixed public ip addresses to enable 
  testing and debugging modes. The fixed ip addresses enable you to be in a permanent test mode
  at your development location even after you are live.


=================
 Acknowledgments
=================

http://www.stripe.com  - credit card processing company
http://twitter.github.com/bootstrap  - The awesome Twitter Bootstrap project
http://www.mysql.com  - mysql
http://www.php.net - php
http://jquery.com  - jQuery
http://www.cdnjs.com  - high speed cdn for jQuery file
http://github.com  - Github source code repository
http://git-scm.com  - git version control system
