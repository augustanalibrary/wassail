<?PHP
  /* If this file outputs '1', it means the passed $_GET['username'] was a valid string & was not found in the database.
   * -1 means the username was already found in the database
   */

$require_right = 'account';
require_once('setup.php');

$passed_username = $_GET['username'];
if(strlen($passed_username) == 0)
{
  echo -1;
  exit();
}

$UserAdmin = new UserAdmin();
if($UserAdmin->checkUsernameExistence($passed_username))
  echo 1;
else
  echo -1;
?>
