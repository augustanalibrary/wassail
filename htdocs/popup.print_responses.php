<?PHP
require('setup.php');
/*****
 * Import the variables for this response 
 */
$template = @$_GET['template_id'];
$course   = @$_GET['course_id'];
$term     = @$_GET['term_id'];
$type     = @$_GET['questionnaire_type_id'];
$year     = @$_GET['school_year'];


$responses = getResponses($template,$course,$term,$type,$year);
$Template = new Template($template);
$Course = new Course($course);

$tpl->assign(array( 'template_name'=>$Template->name,
                    'course_name'=>$Course->name,
                    'term'=>$QUESTIONNAIRE_TERMS[$term],
                    'type'=>$QUESTIONNAIRE_TYPES[$type],
                    'year'=>$year,
                    'read_only'=>TRUE,
                    'inline'=>TRUE,
                    'show_print_icon'=>TRUE,
                    'title'=>'Printing responses',
                    'hide_legend'=>TRUE));



$tpl->display('popup.print_responses.head.tpl');
foreach($responses as $id){
  loadData($tpl,$Template,$id);
  $tpl->display('popup.edit_response.tpl');
}




function getResponses($template,$course,$term,$type,$year){
  $DB          = DBi::getInstance();
  $responses   = array();
  $instance_id = Account::getInstance()->instance_id;
  
  $template    = $DB->escape($template);
  $course      = $DB->escape($course);
  $term        = $DB->escape($term);
  $type        = $DB->escape($type);
  $year        = $DB->escape($year);

  $query = <<<SQL
    SELECT
      distinct(response_id) as 'response_id'
    FROM
      `response`
    WHERE
      `instance_id` = '$instance_id' AND
      `template_id` = '$template' AND
      `course_id` = '$course' AND
      `term` = '$term' AND
      `questionnaire_type` = '$type' AND
      `school_year` = '$year'

SQL;

  $result = $DB->execute($query,'retrieving all qualifying responses');
  while($row = $DB->getData($result)){
    $responses[] = $row['response_id'];
  }

  return $responses;
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
 */
function loadData($tpl,$Template,$load_id)
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

      _loadQuestionStatusFromDB($loop_question,$load_id);
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

  $Response = new Response($load_id);
  $tpl->assign('number',$Response->number);
  
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