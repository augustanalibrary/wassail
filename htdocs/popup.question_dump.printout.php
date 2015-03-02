<?PHP
$require_right = 'read';
require_once('setup.php');


$QuestionList = new QuestionList(@$_GET['o'],@$_GET['d']);
$list = $QuestionList->getList();



$tpl->assign(array('title'=>'Question list',
				   'hide_legend'=>TRUE,
				   'hide_help'=>TRUE,
				   'show_print_icon'=>TRUE,
		   			'list'=>$list));

$tpl->display('popup.create_question_printout.tpl');
?>