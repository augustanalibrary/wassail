<?PHP
$require_right = 'read';
require_once('setup.php');
$order_column = (isset($_GET['o'])) ? $_GET['o'] : 'id';
$order_dir = (isset($_GET['d'])) ? $_GET['d'] : 'desc';

/* Save a new Template */
if(isset($_POST['add']))
{
  $Template = new Template();
  $Template->setName($_POST['name']);
  if($Template->save())
    $tpl->assign(array('success'=>TRUE,
		       'message'=>'Template added successfully'));
  else
    $tpl->assign(array('success'=>FALSE,
		       'message'=>$Template->error));
}

/* Update an existing Template */
if(isset($_POST['save']))
{
  $id = $_POST['save'];
  $name = $_POST['name_'.$id];
  $Template = new Template($id);
  $Template->setName($name);
  if($Template->save())
    $tpl->assign(array('success'=>TRUE,
		       'message'=>'Template updated successfully'));
  else
    $tpl->assign(array('success'=>FALSE,
		       'message'=>$Template->error));
}

/* Delete a Template */
if(isset($_POST['delete']))
{
  $id = $_POST['delete'];
  $Template = new Template($id);
  if($Template->delete())
    $tpl->assign(array('success'=>TRUE,
		       'message'=>'Template deleted successfully'));
  else
    $tpl->assign(array('success'=>FALSE,
		       'message'=>$Template->error));
}

/* Copy a Template */
if(isset($_POST['copy']))
{
  $id = $_POST['copy'];
  $Template = new Template($id);
  if($Template->copy())
    $tpl->assign(array('success'=>TRUE,
		       'message'=>'Template copied successfully.  The copy has been named "'.$Template->duplicate_name.'"'));
  else
    $tpl->assign(array('success'=>FALSE,
		       'message'=>$Template->error));
}


/* Display the page */
$TemplateList = new TemplateList($order_column,$order_dir,TRUE);
$list = $TemplateList->getList();

$tpl->assign(array('title'=>'Templates',
		   'query_count'=>DBi::queryCount(),
		   'right_write'=>Auth::rightWrite(),
		   'right_write_unconditional'=>Auth::rightWriteUnconditional(),
		   'list'=>$TemplateList->getList(),
		   'order_column'=>$order_column,
		   'order_dir'=>$order_dir,
		   'icons'=>array('add'=>'Create new Template',
				  'save'=>'Save Template',
				  'delete'=>'Delete Template',
				  'copy'=>'Copy Template',
				  'print'=>'Print Template',
				  'show'=>'Show Questions',
				  'filter'=>'Filter on Name',
				  'copy'=>'Copy Template',
				  'webify'=>'Make online questionnaire',
				  'webify_edit'=>'Edit existing online questionnaires',
				  'hide'=>'Hide Questions',
				  'sort'=>'Sort by column')));
$tpl->display('templates.tpl');
?>