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
  $files = ($Response->filenames) ? $Response->filenames : '';
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
  if(isset($_POST['add_close']) || isset($_POST['add_again']) || isset($_POST['edit']) || isset($_POST['upload']) || isset($_POST['delete_file']))
  {
    if(checkForm($tpl))
    {
      if(processForm($tpl,$Template,$Course,$term,$type,$year,$load))
      {
        /* If we're doing file stuff, we don't want to redirect, we just want to show the form again */
        if(isset($_POST['upload']) || isset($_POST['delete_file'])){
          loadData($tpl,$Template,$load,'POST');
          /* Reload the Response object so we get a new file list */
          $Response = new Response($load);
          $files = ($Response->filenames) ? $Response->filenames : '';
        }
        else{
      		/* if redirect() doesn't exit, we're loading a new, clean form */
          redirect($tpl);
      		loadData($tpl,$Template,$load);
        }
      }
      else{
	     loadData($tpl,$Template,$load,'POST');
      }
    }
    else
      loadData($tpl,$Template,$load,'POST');
  }
  else if(isset($_GET['load']))
    loadData($tpl,$Template,$load,'DB');
  else
    loadData($tpl,$Template,$load);
}

$tpl->assign(array('title'=>'Adding response',
		   'template_name'=>$Template->name,
		   'course_name'=>$Course->name,
		   'term'=>$QUESTIONNAIRE_TERMS[$term],
		   'type'=>$QUESTIONNAIRE_TYPES[$type],
		   'year'=>$year,
		   'files'=>$files,
		   'show_print_icon'=>TRUE,
		   'hide_legend'=>TRUE));

$tpl->display('popup.edit_response.tpl');



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
  /* defined in config.inc */
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
 * Function: checkForm
 * Purpose: To check the content of the form & make sure all the required info is entered
 * Parameters: $tpl (by reference)
 */
function checkForm(&$tpl)
{
  /* Check response number */
  if(strlen($_POST['number']) == 0)
  {
    $tpl->assign(array('success'=>FALSE,
		       'message'=>'Response number must be entered'));
    return FALSE;
  }
  else if(!preg_match('/\d+/',$_POST['number']))
  {
    $tpl->assign(array('success'=>FALSE,
		       'message'=>'Response must be an integer (1,2,3,etc)'));
    return FALSE;
  }

  $error_fields = array();
  foreach($_POST['question_order'] as $question_id)
  {
    $Question = new Question($question_id);
    $answer_field = 'answer_'.$question_id;
    $no_answer_field = 'no_answer_'.$question_id;
    switch($Question->type)
    {
      /* For both single & multiple questions (represented as radio & checkboxes)
       * the form element won't be posted unless populated, so they can both be handled
       * in one condition
       */
      case "single":
      case "multiple":
	if(!isset($_POST[$answer_field]) && !isset($_POST[$no_answer_field]))
	  $error_fields[] = $answer_field;
	break;
      /* Qualitative questions (represented as textareas) get submitted regardless of content
       * so their values need to be checked
       */
      case "qualitative":
	if(strlen($_POST[$answer_field]) == 0 && !isset($_POST[$no_answer_field]))
	  $error_fields[] = $answer_field;
	break;
    }
  }

  if(count($error_fields) > 0)
  {
    $tpl->assign('error_fields',$error_fields);
    return FALSE;
  }
  else
    return TRUE;
}
	

/*****
 * Function: processForm
 * Purpose: to handle any form that was submitted.  Response & ResponseQuestion objects handle how to act
 *          differently depending on whether a Response is being created or added, so the logic here is simpler
 * Parameters: $tpl: the TemplateLite object
 *             $Template: the WASSAIL Template object
 *             $Course: the Course object
 *             $term: the term id
 *             $type: the type id
 *             $year: the year
 *             $load: if set, this is the ID of the Response being edited
 * Note the passing by reference - especially the $tpl object (the rest are just to save memory)
 */
function processForm(&$tpl,&$Template,&$Course,&$term,&$type,&$year,&$load = FALSE)
{
  $Response = new Response($load);

  /* setProperties will fail if the course number could be updated (only if $Response loaded an actual
   *  response.)
   */
  if(!$Response->setProperties($Template->id,$Course->id,$term,$type,$year,$_POST['number']))
  {
    $tpl->assign(array('success'=>FALSE,
		       'message'=>$Response->error));
    return;
  }


  /*
   * Handle file upload form submission
   */
  if(isset($_POST['upload'])){
    $file = isset($_FILES['new_response_file']) ? $_FILES['new_response_file'] : array();
    if(!$Response->checkFile($file)){
      $tpl->assign(array('success'=>FALSE,'message'=>$Response->error));
      return FALSE;
    }
    else{
      $index = count($Response->filenames);
      $filename = $Response->moveFile($file,$index);
      $filenames = $Response->filenames;
      $filenames[] = $filename;
      $Response->saveFiles($filenames);
    }

    $tpl->assign(array('success'=>TRUE,'message'=>'File uploaded'));
    return TRUE;
  }

  /*
   * Handle file delete form submission
   */
  if(isset($_POST['delete_file'])){
    if($Response->deleteFile($_POST['delete_file'])){
      $tpl->assign(array('success'=>TRUE,'message'=>'File deleted'));
      return TRUE;
    }
    else{
      $tpl->assign(array('success'=>FALSE,'message'=>$Response->error));
      return FALSE;
    }
  
  }


  /* Loop through each question & set its answer.  Answers are overwritten
   * by ResponseQuestion whether they changed or not.
   */
  foreach($_POST['question_order'] as $question_id)
  {
    $Question = new Question($question_id);
    if(isset($_POST['no_answer_'.$question_id]))
	{
      $success = $Response->setAnswer($Question,'0');
	}
    else
    {
      $success = $Response->setAnswer($Question,$_POST['answer_'.$question_id]);
    }
  }

  /* If the whole process worked out - tell the template that */
  if($success)
    $tpl->assign(array('success'=>TRUE,
		       'message'=>'Question added/updated'));

  /* If it crapped out, tell the template that too */
  else
    $tpl->assign(array('success'=>FALSE,
		       'message'=>$Response->error));

  return $success;
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
function loadData($tpl,$Template,$load_id,$load_source = '')
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
          if($Answer->correct)
            $loop_question['correct'] = $Answer->id;
    		}
      }

      /* Whether a question is checked (or populated if qualitative) or not is determined by what the load source says */
      /* Both of these helper functions accept $tpl & $loop_question by reference */
      switch($load_source)
      {
        case 'POST':
		  _loadQuestionStatusFromPost($loop_question);
		  break;
        case 'DB':
		  _loadQuestionStatusFromDB($loop_question,$load_id);
		  break;
        default:
	  //nothing to set as we don't have a data source
	  break;
      }
      $questions[] = $loop_question;
    }


    /* Determine how many questions were correct */
    $possible_correct = 0;
    $actual_correct   = 0;
    foreach($questions as $question){
      if(isset($question['correct'])){
        $possible_correct++;
        $correct_answer_id = $question['correct'];
        
        if(isset($question['answers'][$correct_answer_id]['checked'])){
          $actual_correct++;
        }
      }
    }
    $tpl->assign('possible_correct',$possible_correct);
    $tpl->assign('actual_correct',$actual_correct);
    if($possible_correct)
      $tpl->assign('correct_percent',number_format($actual_correct/$possible_correct*100),0);
  }


  /* Set the response number */
  switch($load_source)
  {
    case 'POST':
      $tpl->assign('number',$_POST['number']);
      break;
    case 'DB':
      $Response = new Response($load_id);
      $tpl->assign('number',$Response->number);
      break;
    default:
      $tpl->assign('number','');
      break;
  }

  $tpl->assign('questions',$questions);
}

/*****
 * Function: _loadQuestionStatusFromPost
 * Purpose: To determine which answers are checked & what text goes into textareas, depending on
 *          POST data.  Also populates the response number (separate from the ID)
 *
 * Note: This function iterates through the 'answers' element of the passed $question array, and adds
 *       a new element of 'checked' to those answers that are present in POST, adds a new element named 'no_answer_checked'
 *       to the $question if that's the case, and populates $answers to a string if the question is qualitative
 */
function _loadQuestionStatusFromPost(&$question)
{ 
  $answer_element_name = 'answer_'.$question['id'];
  $no_answer_element_name = 'no_'.$answer_element_name;

  /* if this question has been flagged as having no student answer */
  if(isset($_POST[$no_answer_element_name]))
    $question['no_answer_checked'] = TRUE;
  /* Otherwise, load the POST data */
  else if(isset($question['answers']))
  {
    switch($question['type'])
    {
      case 'single':
	foreach($question['answers'] as $answer_id => $properties)
	{
	  if(isset($_POST[$answer_element_name]))
	    if($_POST[$answer_element_name] == $answer_id)
	      $question['answers'][$answer_id]['checked'] = TRUE;
	}
      break;
    case 'multiple':
      foreach($question['answers'] as $answer_id => $properties)
      {
	if(isset($_POST[$answer_element_name]))
	  if(in_array($answer_id,$_POST[$answer_element_name]))
	    $question['answers'][$answer_id]['checked'] = TRUE;
      }
      break;
    } 
  }
  else if($question['type'] == 'qualitative')
  {
    $question['answers'] = strip_tags(cleanGPC($_POST[$answer_element_name]));
  }
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

/*****
 * Function: redirect()
 * Purpose: To handle any redirecting that happens after a successful form submission
 *          Users have the option to close the window or be shown a clean form, when they're adding
 *          a new response, and the window will always close after a successful edit.
 *          This function assumes everything went well if it's been called.
 * Parameters: $tpl (by reference) so it can display the simple pages that show the alert & redirect/close
 */
function redirect(&$tpl)
{
  if(isset($_POST['add_again']))
  {
    $tpl->assign(array('action'=>'added',
		       'do'=>'reload',
		       'url'=>$_SERVER['REQUEST_URI']));
    $tpl->display('popup.edit_response.success.tpl');
    exit();
  }
  else if(isset($_POST['add_close']))
  {
    $tpl->assign(array('action'=>'added',
		       'do'=>'close'));
    $tpl->display('popup.edit_response.success.tpl');
    exit();
  }
  else if(isset($_POST['edit']))
  {
    $tpl->assign(array('action'=>'edited',
		       'do'=>'close'));
    $tpl->display('popup.edit_response.success.tpl');
    exit();
  }    
}
?>