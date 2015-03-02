<?PHP
require_once('setup.php');
$username = (isset($_POST['username'])) ? $_POST['username'] : NULL;
$password = (isset($_POST['password'])) ? $_POST['password'] : NULL;


if(isset($_POST['login']))
{
  $Auth = new Auth();
  $result = $Auth->login($username,$password);

  if($result !== TRUE)
    $tpl->assign('error',$result);
  else
  {
    header("Location: https://".$_SERVER['HTTP_HOST'].WEB_PATH."main/");
    exit();
  }
}
$tpl->assign(array('username'=>$username,
		   'hide_navigation'=>TRUE,
		   'title'=>'Login'));
$tpl->display('index.tpl');

?>
