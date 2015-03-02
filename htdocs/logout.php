<?PHP
require_once('setup.php');
$status = Auth::logout();
if($status != TRUE)
  $tpl->assign('message',$status);
$tpl->assign(array(
	'title'=>'Logout',
	'hide_navigation'=>'TRUE',
	'username'=>'',
	'instance_name'=>''
	)
);
$tpl->display('logout.tpl');
?>