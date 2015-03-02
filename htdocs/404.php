<?PHP
require_once('setup.php');
$tpl->assign(array('title'=>'Page not found',
		   'hide_navigation'=>'TRUE'));
$tpl->display('404.tpl');
?>