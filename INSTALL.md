WASSAIL Installation Instructions

WASSAIL uses some icons by Yusuke Kamiyamane [http://p.yusukekamiyamane.com/]

Introduction
======================================
WASSAIL is not simply a drop-in program.  There is no package compiling or 
OS configuration necessary, but there are a couple steps necessary to ensure 
WASSAIL can operate properly.  Before starting, please ensure your system has 
met the system requirements.

======================================
= System Requirements
======================================

==========
= Server
==========
- Linux OS
  - Tested on SuSE 10, Ubuntu 8.10
- PHP 5.1.2
  - Will likely work on PHP 5.0 - 5.11
  - Will NOT work on PHP4
- Apache
  - Or compatible web server
  - mod_rewrite enabled
- MySQL 5+
  - May work on 4.x, but hasn't been tested


===========
= Browser
===========
Firefox 10+ (Has been extensively tested)
Chrome (Has not been tested, but many users report WASSAIL works as expected)
Internet Explorer is not supported 


======================================
= User Requirements
======================================
Installing WASSAIL requires a certain level of technical expertise and system
access.

- Must have root access to change ownership of directories
- Must have access to your database (via command line or phpMyAdmin, etc)
  - Must be comfortable manually running queries
- Be able to modify variables in a PHP file


======================================
= Installation Steps
======================================


Expand package:
---------------
+ Uncompress the wassail.package.tar.gz file.  Where you expand it doesn't
matter a whole lot as you'll be moving stuff around.  The following command
will expand the file:

     tar -xf wassail.package.tar.gz

The file will contain the following files (Note: some of these files may not
be used by you):

    categories.sql
    CHANGELOG.txt
    help.sql
    htaccess
    install.sql
    INSTALL.txt
    populate.sql
    upgrade.sql
    UPGRADE.TXT


Setup database:
---------------
+ Create a database for WASSAIL to use.  The query to create a database named
"wassail" is: 

   CREATE DATABASE 
      `wassail`

+ Create a database user for WASSAIL to use.  The following query will create
the user "wassailuser" with the password "wassailpwd", and allow that user 
access to the"wassail" database on the local host:

   GRANT ALL ON 
      wassail.* 
   TO
      'wassailuser'@'localhost' 
   IDENTIFIED BY
      'wassailpwd'

+ Import the install.sql file into your WASSAIL database. The install.sql file 
will be found in the directory you expanded wassail.package.tar.gz into. From the
command line, this command will import the file:

	mysql -u wassailuser -pwassailpwd wassail < install.sql

+ Import the populate.sql file.  This will create the default user, default
instance, help, and question categories. From the command line, this command
will import the file:

        mysql -u wassailuser -pwassailpwd wassail < populate.sql

Of course, substitute your database user, password, and database name 
as appropriate.


Move code
--------------------
Move the contents of the newly expanded "htdocs" directory into the directory
in which you want WASSAIL to run.


Update configuration
--------------------
+ Open include/classes/dbi.php and change the $db, $username, $password, and 
$host variables in the __construct() method to allow WASSAIL to connect to 
your database.  The variables are defined starting on line 49

+ Open include/config.inc
  - Update $subdir if necessary.  config.inc includes a description of what
    $subdir is for.
  - Update SYSADMIN_EMAIL if necessary
  - Find the line for UPLOAD_DIR.  By default it's set to /srv/www/uploads/ -
    which may not necessarily exist.  This is the directory used to store
    uploaded CSV files that contain response data.  Update this value to the
    server path of the directory you will use.


Update filesystem
-----------------
All filesystem updates must be done as a server administrator, typically this
user is 'root'

+ Change the ownership of the include/templates/compiled/ directory to
whichever user the webserver runs as.  This will allow WASSAIL to display
properly.

[ To determine the user the webserver runs as, load up "webserveruser.php" in 
  your browser. ]

+ Change the ownership of include/helpimages to whichever user the webserver
runs as. This will allow you to upload images for the help screens.

+ Create the directory specified by UPLOAD_DIR in
include/config.inc and set the ownership to whichever user the webserver runs
as.

+ Create a "responses" directory inside the directory specified by
UPLOAD_DIR.  set the owner ship to the webserver's user.


Rename htaccess
---------------
+ Rename the 'htaccess' file to '.htaccess'.  This will provide the URL
rewriting to allow internal linking to function properly.
+ Move the .htaccess file into the htdocs directory


Finished
--------
That's it.  You should be able to login with the default user of "admin" 
(no quotes) and the password "infolit".  IT IS HIGHLY RECOMMENDED that you 
change that password once you login.  You can do so by clicking on the 
"Accounts" tab, then clicking the keys icon beside the "wassail" user.