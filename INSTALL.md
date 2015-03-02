#WASSAIL Installation Instructions

WASSAIL uses some icons by [Yusuke Kamiyamane](http://p.yusukekamiyamane.com/)

##Introduction

WASSAIL is not simply a drop-in program.  There is no package compiling or 
OS configuration necessary, but there are a couple steps necessary to ensure 
WASSAIL can operate properly.  Before starting, please ensure your system has 
met the system requirements.

##System Requirements

###Server
* Linux OS
  * Tested on Debian
* PHP 5.4.36
  * Will likely work on any 5.4.* branch
* Apache
  * Or compatible web server
  * mod_rewrite enabled
* MySQL 5.5.41
  * Will probably work on any MySQL 5.*
  - May work on 4.*, but hasn't been tested


###Browser
* Latest versions of
  * Firefox
  * Chrome (Has not been extensively tested, but many users report WASSAIL works as expected)
* Internet Explorer is not supported 


##User Requirements
Installing WASSAIL requires a certain level of technical expertise and system access.
* Must have root access to change ownership of directories
* Must have access to your database (via command line or phpMyAdmin, etc)
  * Must be comfortable manually running queries
* Be able to modify variables in a PHP file

##Installation Steps

###Download and expand package:
Download the ZIP file from Github and upload it to your server. Where you expand it doesn't matter a whole lot as you'll be moving stuff around.  The following command will expand the file:

    gunzip wassail-master.zip

The file will contain the following files (Note: some of these files may not be used by you):

    categories.sql
    CHANGELOG.md
    help.sql
    htaccess
    install.sql
    INSTALL.md
    populate.sql
    upgrade.sql
    UPGRADE.md
    UPGRADE_v2_v3.txt


###Set up database
Create a database for WASSAIL to use.  The query to create a database named
"wassail" is: 

    CREATE DATABASE `wassail`

Create a database user for WASSAIL to use.  The following query will create the user "wassailuser" with the password "wassailpwd", and allow that user access to the"wassail" database on the local host.  You should modify the username and password (and database if you're so inclined) to something of your choosing:

```sql
   GRANT ALL ON 
      wassail.* 
   TO
      'wassailuser'@'localhost' 
   IDENTIFIED BY
      'wassailpwd'
```

Import the `install.sql` file into your WASSAIL database. The install.sql file will be found in the directory you expanded `wassail-master.zip` into. From the
command line, this command will import the file:

    mysql -u wassailuser -pwassailpwd wassail < install.sql
_If you changed the username, password and/or database names, update this query accordingly._

Import the populate.sql file.  This will create the default user, default instance, help, and question categories. From the command line, this command
will import the file:

    mysql -u wassailuser -pwassailpwd wassail < populate.sql

_Again, substitute your database user, password, and database name as appropriate._


###Move code
Move the contents of the newly expanded `htdocs` directory into the directory in which you want WASSAIL to run.


###Update configuration
Open `include/config.db.sample.php` and change the `$db`, `$username`, `$password`, and `$host` properties to allow WASSAIL to connect to your database.  Rename the file to `config.db.php`

Open `include/config.php`
* Update `$subdir` if necessary.  config.php includes a description of what `$subdir` is for.
* Update `SYSADMIN_EMAIL` if necessary
* Find the line for `UPLOAD_DIR`.  By default it's set to be in the same directory as the directory into which you installed WASSAIL. For example, if WASSAIL is running in the `/var/www/htdocs/` directory, WASSAIL assumes the upload directory will be `/var/www/uploads`.
  * This is the directory used to store uploaded CSV files that contain response data, as well as any files uploaded by users in their response  Update this value to the server path of the directory you will use.


###Update filesystem

All filesystem updates must be done as a server administrator, typically this user is 'root'

Change the ownership of the include/templates/compiled/ directory to whichever user the webserver runs as.  This will allow WASSAIL to display properly._ To determine the user the webserver runs as, load up "webserveruser.php" in your browser._

Change the ownership of `include/helpimages` to whichever user the webserver runs as. This will allow you to upload images for the help screens.

Create the directory specified by `UPLOAD_DIR` in include/config.php and set the ownership to whichever user the webserver runs as.

Create a `responses` directory inside the directory specified by `UPLOAD_DIR`.  Set the owner ship to the webserver's user.


#Finished

That's it.  You should be able to login with the default user of `admin` and the password `infolit`.  **IT IS HIGHLY RECOMMENDED** that you change that password once you login.  You can do so by clicking on the `Accounts` tab, then clicking the keys icon beside the `wassail` user.