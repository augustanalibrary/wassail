<?PHP
require_once('setup.php');

$id = $_GET['id'];
$ResponseList = new ResponseList();
$entries = $ResponseList->loadEntriesForTemplate($id);

$tpl->assign(array('id'=>$id,
		   'entries'=>$entries,
		   'right_write'=>Auth::rightWrite(),
		   'right_write_unconditional'=>Auth::rightWriteUnconditional()));
$tpl->display('ajax.response_template_entries.tpl');
?>