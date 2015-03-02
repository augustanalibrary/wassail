<?PHP
  /* If this file outputs '1', it means the passed $_GET['name'] was a valid string & was not found in the database.
   * -1 means the username was already found in the database
   */
$require_right = 'account';
require_once('setup.php');

$passed_name = $_GET['name'];
if(strlen($passed_name) == 0)
{
  echo -1;
  exit();
 }

$UserAdmin = new UserAdmin();
if($UserAdmin->checkInstanceNameExistence($passed_name))
  echo 1;
else
  echo -1;