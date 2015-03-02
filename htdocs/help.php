<?PHP
require_once('setup.php');
$Account = Account::getInstance();

/* Note: Help might seem to be acting funny but it uses magic __get & __set nicely. */
$from = str_replace($subdir,'',$_GET['from']);
$Help = new Help($from);

$Help = new Help($_GET['from']);


if(isset($_POST['submit']))
  $Help->content = $_POST['help-content'];

$tpl->assign(array('title'=>'Help',
		   'content'=>$Help->content,
		   'hide_iconbar'=>TRUE,
		   'can_write'=>$Account->right_help,
		   'error'=>$Help->error));
$tpl->display('help.tpl');
?>