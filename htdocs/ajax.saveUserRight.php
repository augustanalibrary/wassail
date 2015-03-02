<?PHP
  /*****
   * This page is called from /accounts/, which is actually accounts.php, which
   * displays /include/templates/useradmin.tpl, which includes /include/templates/js/useradmin.js
   *
   * This handles the right changing
   */
$require_right = 'account';
require_once('setup.php');

$account = $_POST['account'];
$right = $_POST['right'];
$action = $_POST['action'];


$UserAdmin = new UserAdmin();
if(!$UserAdmin->setRight($account,$right,$action))
  echo $UserAdmin->error;
?>