<?PHP
$require_right = 'read';
require_once('setup.php');

/* Handle question deletion */
if(isset($_POST['delete_x']))
{
  $Question = new Question($_POST['delete_id']);
  if($Question->delete())
    $tpl->assign('message',array('type'=>'success',
				 'message'=>'Question succesfully deleted'));
  else
    $tpl->assign('message',array('type'=>'error',
				 'message'=>$Question->error));
}

$order_column = (isset($_GET['o'])) ? $_GET['o'] : 'id';
$order_dir = (isset($_GET['d'])) ? $_GET['d'] : 'desc';
$QuestionList = new QuestionList($order_column,$order_dir);
$list = $QuestionList->getList();
$Account = Account::getInstance();
global $QUESTIONNAIRE_TERMS;

$tpl->assign(array('title'=>'Questions',
		   'query_count'=>DBi::queryCount(),
		   'right_write'=>Auth::rightWrite(),
		   'right_write_unconditional'=>Auth::rightWriteUnconditional(),
		   'list'=>$list,
		   'terms'=>$QUESTIONNAIRE_TERMS,
		   'order_column'=>$order_column,
		   'order_dir'=>$order_dir,
		   'icons'=>array('add'=>'Add question',
				  'edit'=>'Edit question &amp;/or answers',
				  'delete'=>'Delete question &amp; answers',
				  'show'=>'Show answers',
				  'hide'=>'Hide answers',
				  'filter'=>'Filter on column',
				  'export_csv'=>'Export data as CSV',
				  'print'=>'Generate question printout',
				  'sort'=>'Sort by column')));
$tpl->display('questions.tpl');


?>