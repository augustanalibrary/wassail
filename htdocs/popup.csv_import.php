<?PHP
$require_right = 'write';
require_once('setup.php');

$tpl->assign(array('title'=>'Importing CSV data',
		   'hide_legend'=>TRUE));


if(isset($_POST['upload']))
{
  $Import = new Import();
  if($Import->upload())
  {
    $tpl->assign(array('file_contents'=>$Import->file_contents,
		       'filename'=>$Import->filename));
    $tpl->display('popup.csv_import.verify.tpl');
  }
  else if(is_array($Import->sanity_errors))
  {
    $tpl->assign('sanity_errors',$Import->sanity_errors);
    $tpl->display('popup.csv_import.upload.tpl');
  }
  else
  {
    $tpl->assign('error',$Import->error);
    $tpl->display('popup.csv_import.verify.tpl');
  }
}
else if (isset($_POST['import']))
{
  $Import = new Import($_POST['filename']);
  if($Import->import(cleanGPC($_POST['filename'])))
  {
    $tpl->assign(array('success'=>TRUE,
		       'message'=>'Data successfully imported.  You may now close this window'));
    $tpl->display('popup.csv_import.finished.tpl');
  }
  else
  {
    $tpl->assign('error',$Import->error);
    $tpl->display('popup.csv_import.upload.tpl');
  }
}
else
  $tpl->display('popup.csv_import.upload.tpl');

?>