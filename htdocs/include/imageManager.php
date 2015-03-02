<?PHP
 /*****
  * This file handles the display of the list of images available for help pages, and the managing thereof
  */

$require_right = 'help';
require '../setup.inc';
require 'classes/imagemanager.php';

$Manager = new ImageManager();

/* Upload the image if necessary */
if(isset($_POST['upload']))
{
  /* Due to lazy evaluation, PHP will stop evaluating
   * as soon as one of these functions returns false, 
   * so no functions will get executed after an error
   */
  if($Manager->uploadOK() &&
     $Manager->fileOK() &&
     $Manager->moveFile() &&
     $Manager->makeThumb())
    $tpl->assign(array('success'=>TRUE,
		       'message'=>'Image uploaded'));
  else
    $tpl->assign(array('success'=>FALSE,
		       'message'=>$Manager->error));
}
if(isset($_POST['delete']))
{
  $filename = cleanGPC($_POST['delete']);
  if($Manager->delete($filename))
    $tpl->assign(array('success'=>TRUE,
		       'message'=>'Image deleted'));
  else
    $tpl->assign(array('success'=>FALSE,
		       'message'=>$Manager->error));
}


$tpl->assign(array('title'=>'Image Manager',
		   'hide_iconbar'=>TRUE,
		   'web_help_image_dir'=>WEB_HELP_IMAGE_DIR,
		   'images'=>$Manager->getList()));
$tpl->display('help.imagemanager.tpl');
?>