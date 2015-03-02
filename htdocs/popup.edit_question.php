<?PHP
require_once('setup.php');
$id = $_GET['id'];

$Question = ($id) ? new Question($id) : new Question();

if(isset($_POST['save_again']) || isset($_POST['save_close']))
{	
	$Question->setType($_POST['type']);
	$Question->setText($_POST['content']);
	$Question->setCategories($_POST['categories']);
	$Question->setTags($_POST['tags']);
	if($_POST['type'] != 'qualitative_long' && $_POST['type'] != 'qualitative_short')
	{
		if(strlen($_POST['correct']))
			$Question->setCorrectAnswer($_POST['correct']);
		
		if(isset($_POST['answer_ids']))
		{
			foreach($_POST['answer_ids'] as $index=>$id)
			{
				$answers[$id] = $_POST['answers'][$index];
			}
			$Question->setNewAnswers($answers);
		}
	}

	$text = (get_magic_quotes_gpc()) ? $_POST['qualitative_opt_out'] : $_POST['qualitative_opt_out'];
	$Question->setOptOut($text);

  if(!$Question->save())
  {
    $tpl->assign('error',$Question->error);
  }
  else if(isset($_POST['save_close']))
  {
    $tpl->assign('reload_parent',TRUE);
	$tpl->assign('alert','Question saved');
    $tpl->display('popup.close.html');
    exit();
  }
  else if (isset($_POST['save_again']))
  {
    header('Location: http://'.$_SERVER['HTTP_HOST'].WEB_PATH.'popup.edit_question.php?id=0');
  }
}

/***
 * Copy answer text & ids into an array for the template
 */
$answers = array();
if(count($Question->answers))
{
  foreach($Question->answers as $answer_id=>$Answer)
  {
    $answers[$answer_id] = array('text'=>$Answer->text,
				 'correct'=>$Answer->correct);
  }
}

/*** 
 * Retrieve question categories for the template 
 */
$DB = DBi::getInstance();
$query = <<<SQL
SELECT
 *
FROM
 category
ORDER BY
 text + 0 ASC
SQL;
//the "+ 0" in the above query causes the sorting to be "natural" (ie: 1 < 2 < 10, not 1 < 10 < 2)
$result = $DB->execute($query,'retrieving all categories');
if($result)
{
  while($row = $DB->getData($result))
  {
    $categories[$row['id']]['text'] = $row['text'];
    $categories[$row['id']]['selected'] = (isset($Question->categories[$row['id']])) ? TRUE : FALSE;
  }

  /* If there are no categories, automatically select 'NONE' which has an ID of 1 */
  if(count($Question->categories) == 0)
    $categories[1]['selected'] = TRUE;

  # Categories that should have a few spaces put in front of them, to signify they are "reference/see also" categories
  $indent_categories = array(14,15,16,17,18,20,21,22,24,25,26,27);

}



/***
 * import $LIKERT answer defaults from the config 
 */
global $LIKERT;


/***
 * import $COMMON_ANSWER defaults from the config
 */
global $COMMON_ANSWERS;

/***
 * Import active account
 */
$Account = Account::getInstance();


/***
 * Display template
 */


$window_title = ($id) ? 'Edit question' : 'Add a new question';

$tpl->assign(array('asked'=>$Question->asked,
		   'unconditional_write'=>$Account->right_write_unconditional,
		   'title'=>$window_title,
		   'id'=>$Question->id,
		   'load_editor'=>"TRUE",
		   'text'=>$Question->text,
		   'answers'=>$answers,
		   'opt_out'=>$Question->opt_out,
		   'likert'=>$LIKERT,
		   'common_answers'=>$COMMON_ANSWERS,
		   'categories'=>$categories,
		   'indent_categories'=>$indent_categories,
		   'tags'=>$Question->tags,
		   'question_type'=>$Question->type,
		   'question_qualitative_type'=>$Question->qualitative_type,
		   'icons'=>array('reorder'=>'Reorder answers',
						  'delete'=>'Delete answer',
						  'correct'=>'Mark as correct answer',
						  'correct_bar'=>'Correct answer')));
$tpl->display('popup.edit_question.tpl');
  