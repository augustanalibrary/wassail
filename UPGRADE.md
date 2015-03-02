WASSAIL Upgrade Instructions

Introduction
======================================
This file provides instructions on how to upgrade an installation of
WASSAILv2.0.1 to WASSAILv3.0


======================================
= System/User Requirements
======================================
No change.  If you can run v2.0.1, you can run v3.0



======================================
= Upgrade Steps
======================================

BACKUP EVERYTHING!!!
Doing an upgrade shouldn't break anything, but it's better to be safe than
sorry.

Backup database:
----------------
Assuming your database username is wassailuser, your password is
wassailpassword, and your database name is wassail, this command will create a
backup of your database:

   mysqldump -u wassailuser -pwassailpassword wassail > backup.sql

Of course, you should be using a different username and password


Backup files:
------------
Navigate to your WASSAIL directory and run this command:

   tar -cvf ~/wassail.backup.tgz *

This will create a wassail.backup.tgz file in your home directory - not in the
directory you're currently in.  This is safer, as it's a little more
protection against deletion.


Now that backing up is done, you can proceed to upgrade your installation of
WASSAIL.



Expand package:
---------------
+ Uncompress the wassail.package.tgz file.  Inside the package will be a
number of text files, SQL files and an 'htdocs' directory that contains the
WASSAIL code.


Update database:
----------------
+ Import upgrade.sql using this command (assumes same username, password, and
database name as above).

   mysql -u wassailuser -pwassailpassword wassail < upgrade.sql

This will alter a couple tables, but won't change any data.

+ If you want to update your help, import help.sql using this command.
IMPORTANT: This will replace any help you currently have written, so if you've
done custom modifications, they will be lost.

   mysql -u wassailuser -pwassailpassword wassail < help.sql

+ If you want to update the categories questions can go into, import
categories.sql using this command.  IMPORTANT: This will replace all the
categories in the `category` table, so if you've added new categories, they
will be lost.

   mysql -u wassailuser -pwassailpassword wassail < categories.sql


Record installation-specific properties
---------------
These include settings in config.inc you may have customized, and the database
credentials in include/classes/dbi.php


Move code:
------------
Move the contents of the newly expanded "htdocs" directory into the directory
from which WASSAIL is run.


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

+ Create a 'responses' directory in the directory specified by UPLOAD_DIR.
Set the ownership to the web server's user.

+ Change the mode of /include/HTMLPurifier/DefinitionSchema to 077



Remove htaccess
---------------
+ The .htaccess file will remain from your previous installation, but the code
archive contains a "htaccess" file that is superfluous & can be removed


Add help files:
---------------
+ The images used in the help pages are available as a separate download.
Expand the archive into include/helpimages/


Finished
--------
That's it.  Your upgrade of WASSAIL should be complete.