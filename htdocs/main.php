<?PHP
require_once('setup.php');

$tpl->assign(array('title'=>'Main',
			'hide_legend'=>TRUE,	
		   'query_count'=>DBi::queryCount()));
$tpl->display('main.tpl');
?>