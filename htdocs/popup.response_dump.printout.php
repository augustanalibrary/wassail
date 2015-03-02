<?PHP
require('setup.php');
/*****
 * Import the variables for this response 
 */
$template = @$_GET['template'];
$course = @$_GET['course'];
$term = @$_GET['term'];
$type = @$_GET['type'];
$year = @$_GET['school_year'];
$load = (isset($_GET['load'])) ? $_GET['load'] : FALSE;
$files = '';

/*****
 * If $load is set, create a Reponse object & glean the rest of the necessary variables from that
 */
if($load)
{
  $Response = new Response($load);
  $template = $Response->template_id;
  $course = $Response->course_id;
  $term = $Response->term;
  $type = $Response->type;
  $year = $Response->year;
  $files = ($Response->files) ? $Response->files : '';
}


/***
 * Create relevant objects necessary for proper error checking, data entry & display
 * Note that PHP is not case sensitive when it comes to variables, so these objects overwrite
 * $template & $course
 */
$Template = new Template($template);
$Course = new Course($course);

$error = FALSE;

/* Note: All functions that have $tpl passed, accept it by reference.  This means any errors they generate will have already
 *       been stored in the $tpl object in this scope (which is actually the same object), by the time they return()
 */
if(checkURLData($tpl,$Template,$Course,$term,$type,$year))
{
	loadData($tpl,$Template,$Course,$term,$type,$year);
	$tpl->display('popup.response_dump.printout.tpl');
}





/*****
 * Function: checkURLData
 * Purpose: To make sure all the data passed in the URL ($_GET) is valid & not the result
 *          of some jerk trying to break the system.
 * Parameters: $tpl: the template object
 *             $Template: the Template (as in, WASSAIL questionnaire template) object
 *             $Course: the Course object
 *             $term: the term id
 *             $type: the type id
 *             $year: the year (not currently tested)
 *
 * Note: All parameters are passed by reference - most notably $tpl.  This function
 *       sets its on errors in the template & just returns a success/fail
 */
function checkURLData(&$tpl,&$Template,&$Course,&$term,&$type,&$year)
{
  /* defined in config.php */
  global $QUESTIONNAIRE_TERMS,$QUESTIONNAIRE_TYPES;

  $error = FALSE;

  /* Make sure all the passed parameters are valid */
  if(!$Template->id)
    $error = $Template->error;
  else if(!$Course->id)
    $error = $Course->error;
  else if(!isset($QUESTIONNAIRE_TERMS[$term]))
    $error = "The term provided ($term) does not exist.";
  else if(!isset($QUESTIONNAIRE_TYPES[$type]))
    $error = "The type provided ($type) does not exist.";

  if($error)
  {
    $tpl->assign(array('success'=>FALSE,
		       'message'=>$error));
    return FALSE;
  }
  return TRUE;
}


 
/*****
 * Function: loadData()
 * Purpose: To load the questions, their answers, their status (checked/unchecked, text to put in textareas),
 *          & the response number from various objects & sources ($_GET or $_POST) & store it in the template 
 *          in a format it can use
 * Parameters: $tpl: The TemplateLite object
 *             $Template: The Template object that knows which questions to display & in what order
 *             $Course: The Course object that knows the name & id of the course
 *             $term: the term id (corresponding to spring, summer, etc) of the questionnaire
 *             $type: the type id (corresponding to pre-test, post-test, etc) of the questionnaire
 *             $year: um...the school year.
 *             $load: the id to load.  Will be blank if we're not loading anything
 *             $load_source: the source of status data.  If 'DB', the data will be loaded from the databaes & 
 *                           whether a checkbox/radio is checked or not will depend on the data from the database.
 *                           If 'POST', the data will be loaded from POST.
 *                           If nothing, all boxes will remain unchecked & all textareas will remain blank.
 */
function loadData($tpl,$Template,$Course,$term,$type,$year)
{
  $questions = FALSE;
  /* Import questions if they exist */
  if(count($Template->questions > 0))
  {	  
    $questions = array();
    /* Import each question */
    foreach($Template->questions as $Question)
    {
      /* Set question-specific properties */
      /* $loop_question will hold all the properties for this question for the duration of the loop */
      $loop_question = array();
      $loop_question['id'] = $Question->id;
      $loop_question['text'] = $Question->text;
      $loop_question['type'] = $Question->type;
	  $loop_question['qualitative_type'] = $Question->qualitative_type;
	  $loop_question['opt_out'] = $Question->opt_out;

      $answers = FALSE;
      /* If there are answers to this question */
      if(is_array($Question->answers))
      {
		$answers = array();
		/* Loop through the answers */
		foreach($Question->answers as $Answer)
		{
		  $loop_question['answers'][$Answer->id]['text'] = $Answer->text;
		}
      }

      _loadQuestionStatusFromDB($loop_question,$load_id);
      $questions[] = $loop_question;
    }
  }

  $tpl->assign('questions',$questions);
}



/*****
 * Function: _loadQuestionStatusFromDB
 * Purpose: To determine which answers are checked & what text goes into textareas, depending on
 *          data in the DB
 * Parameters: $question: an array generated in loadData
 *             $id: the id of the response to load
 * Note: This function iterates through the 'answers' element of the passed $question array, and adds
 *       a new element of 'checked' to those answers that are present in the DB, adds a new element named 'no_answer_checked'
 *       to the $question if the question answer id is 0, and populates $answers to a string if the question is qualitative
 *       A lot of the logic that determines the type of question & the answer values, is done in the Response & ResponseQualitative classes
 */
function _loadQuestionStatusFromDB(&$question,$id)
{
  $Response = new Response($id);

  if($Response->response_id)
  {
    if(isset($Response->questions[$question['id']]))
    {
      if($Response->questions[$question['id']]->answers == FALSE)
		$question['no_answer_checked'] = TRUE;
		  else
		switch($question['type'])
		{
		  case 'single':
			foreach($question['answers'] as $answer_id=>$properties)
			{
			  if($answer_id == $Response->questions[$question['id']]->answers)
			$question['answers'][$answer_id]['checked'] = TRUE;
			}
			break;
		  case 'multiple':
			foreach($question['answers'] as $answer_id=>$properties)
			{
			  $existing_answer_ids = array_keys($Response->questions[$question['id']]->answers);
			  if(in_array($answer_id,$existing_answer_ids))
			$question['answers'][$answer_id]['checked'] = TRUE;
			}
		   break;
		  case 'qualitative':
			$question['answers'] = $Response->questions[$question['id']]->answers;
			break;
		}
    }
  }
}


?>