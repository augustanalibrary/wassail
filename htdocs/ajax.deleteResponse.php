<?PHP
$require_right = 'write';
require_once('setup.php');
$id = $_GET['id'];
$Response = new Response($id);
if($Response->delete())
  echo 1;
else
  echo 'nay'.$Response->error;
?>