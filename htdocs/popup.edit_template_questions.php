<?PHP
require_once('setup.php');
$id = $_GET['id'];
$Template = new Template($id);

/* Don't show the form if the template has been asked and they don't have the appropriate rights */
if($Template->asked && !Auth::rightWriteUnconditional())
{
  $tpl->assign('unauthed',TRUE);
  $tpl->display('popup.edit_template_questions.tpl');
  exit();
}

$Template->loadQuestions();

/***
 * Save the question positions
 */
if(isset($_POST['save']))
{
  /* Only act if there are questions */
  if(is_array($_POST['questions']))
  {
    /* These variables will be overwritten by a failed update in the below loop.  
     * If no problems below, these values will persist */
    $tpl->assign(array('success'=>TRUE,
		       'message'=>'Questions saved'));

    /* This will be set true if at least 1 question gets repositioned */
    $reloadQuestions = FALSE;
    $position = 1;

    foreach($_POST['questions'] as $question_id)
    {
      /* Loop through each question & only re-save it if it's position has changed */
      $Question = new Question($question_id);
      $Question->loadPositions();
      if($Question->positions[$id] != $position)
      {
	if(!$Template->saveQuestion($question_id,$position))
	{
	  $tpl->assign(array('success'=>FALSE,
			     'message'=>$Template->error.'"'));
	  break;
	}
	else
	  $reloadQuestions = TRUE;
      }
      $position++;
    }
    if($reloadQuestions)
      $Template->loadQuestions();
  }
}

/***
 * Add a new question
 */
if(isset($_POST['add']))
{
  $question_id = $_POST['add'];
  if(!$Template->saveQuestion($question_id))
    $tpl->assign(array('success'=>FALSE,
		       'message'=>$Template->error));
  else
    $tpl->assign(array('success'=>TRUE,
		       'message'=>'Question added.  It has been placed at the bottom of the template.'));
}

/***
 * Delete a question
 */
if(isset($_POST['delete']))
{
  $question_id = $_POST['delete'];
  if(!$Template->deleteQuestion($question_id))
    $tpl->assign(array('success'=>FALSE,
		       'message'=>$Template->error));
  else
    $tpl->assign(array('success'=>TRUE,
		       'message'=>'Question successfully removed from template.'));
}


/***
 * Array-ify the questions list for the template
 */
if(count($Template->questions) > 0)
{
  foreach($Template->questions as $Question)
  {
    $questions[] = array('id'=>$Question->id,
			 'text'=>$Question->text);
  }
  $tpl->assign('questions',$questions);
}

$tpl->assign(array('title'=>'Editing Template questions',
		   'load_editor'=>"FALSE",
		   'id'=>$id,
		   'icons'=>array('add'=>'Add new question',
				  'delete'=>'Delete question from template',
				  'reorder'=>'Change question order')));
$tpl->display('popup.edit_template_questions.tpl');