<?PHP
$require_right = 'read';
require_once('setup.php');
$order_column = (isset($_GET['o'])) ? $_GET['o'] : 'id';
$order_dir = (isset($_GET['d'])) ? $_GET['d'] : 'desc';

/* Save a new Course */
if(isset($_POST['save']))
{
  $Course = new Course();
  $Course->setNumber($_POST['number']);
  $Course->setName($_POST['name']);
  $Course->setInstructor($_POST['instructor']);
  $success = $Course->save();
  if(!$success)
    $tpl->assign(array('success'=>FALSE,
		       'message'=>$Course->errors));
  else
    $tpl->assign(array('success'=>TRUE,
		       'message'=>'Course added'));
}

/* Update an existing Course */
if(isset($_POST['edit']))
{
  $edit_id = $_POST['edit'];
  $Course = new Course($edit_id);
  $Course->setNumber($_POST['number_'.$edit_id]);
  $Course->setName($_POST['name_'.$edit_id]);
  $Course->setInstructor($_POST['instructor_'.$edit_id]);
  $success = $Course->save();
  if(!$success)
    $tpl->assign(array('success'=>FALSE,
		       'message'=>$Course->errors['other']));
  else
    $tpl->assign(array('success'=>TRUE,
		       'message'=>"Course #$edit_id updated"));
}

/* Delete an existinc Course */
if(isset($_POST['delete']))
{
  $delete_id = $_POST['delete'];
  $Course = new Course($delete_id);
  $success = $Course->delete();
  if(!$success)
    $tpl->assign(array('success'=>FALSE,
		       'message'=>$Course->errors['other']));
  else
    $tpl->assign(array('success'=>TRUE,
		       'message'=>"Course #$delete_id deleted"));
}





/* Display the page */
$CourseList = new CourseList($order_column,$order_dir);
$list = $CourseList->getList();
$tpl->assign(array('title'=>'Courses',
		   'query_count'=>DBi::queryCount(),
		   'right_write'=>Auth::rightWrite(),
		   'right_write_unconditional'=>Auth::rightWriteUnconditional(),
		   'list'=>$list,
		   'order_column'=>$order_column,
		   'order_dir'=>$order_dir,
		   'icons'=>array('add'=>'Create new Course',
				  'save'=>'Save Course',
				  'sort'=>'Sort by column',
				  'delete'=>'Delete Course')));
$tpl->display('courses.tpl');
?>