<?PHP
session_start();
require 'include/config.php';
require 'include/funclib.php';
require 'include/classes/auth.php';

require_once('include/template_lite/class.template.php');
$tpl = new Template_Lite;
$tpl->template_dir = INSTALL_DIR.'include/templates/';
$tpl->compile_dir = $tpl->template_dir.'compiled/';
$tpl->assign(array('date_format_long'=>DATE_FORMAT_LONG,
		   'date_format_short'=>DATE_FORMAT_SHORT));
$tpl->assign('feedback_enabled',FEEDBACK_ENABLED);
$tpl->assign('feedback_url',FEEDBACK_URL);

$Auth = new Auth;
$tpl->assign('right_account',$Auth->rightAccount());
if(isset($_SESSION['username'])){
	$tpl->assign(array(
		'username'      =>$_SESSION['username'],
		'instance_name' =>$_SESSION['instance_name']
		)
	);
}

/* Stop the user from seeing the page unless it's the login page */
if(!isset($require_login) || $require_login === TRUE)
{	
  $require_right = (isset($require_right)) ? $require_right : FALSE;
  if($_SERVER['REQUEST_URI'] != $subdir.'index.php' && $_SERVER['REQUEST_URI'] != $subdir && !$Auth->isAuthed($require_right))
  {
    $tpl->assign(array('hide_navigation'=>TRUE,
		       'title'=>'Not authorized'));
    $tpl->display('unauth.tpl');
    exit();
  }
}


?>