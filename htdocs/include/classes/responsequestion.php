<?PHP
  /*****
   * This class represents a single responded question.  $this->answers changes to reflect
   * whichever type of question it represents (single/multiple/qualitative)
   */
class ResponseQuestion
{
  private $instance_id;
  private $response_id;
  private $response_question_id;
  private $number;
  private $question_id;
  private $template_id;
  private $course_id;
  private $term;
  private $questionnaire_type;
  private $type;
  private $year;
  private $answers;
  private $answer_id;
  private $error;  
  private $DB;

  function __construct($response_id,$number,$template_id,$course_id,$term,$type,$questionnaire_type,$year,$question_id)
  {
    $this->response_id = $response_id;
    $this->number = $number;
    $this->template_id = $template_id;
    $this->course_id = $course_id;
    $this->term = $term;
    $this->year = $year;
    $this->questionnaire_type = $questionnaire_type;
    $this->type = $type;
    $this->question_id = $question_id;

    $this->DB = DBi::getInstance();
    
    $this->instance_id = $_SESSION['instance_id'];
    $this->load();
  }

  /*****
   * Function: load()
   * Purpose: to load all the provided answers for this particular question
   */
  function load()
  {
    $query = <<<SQL
SELECT
      *
FROM
      response
WHERE
      response_id = $this->response_id AND
      question_id = $this->question_id
ORDER BY
      id DESC
SQL;

    $result = $this->DB->execute($query,'retrieving response question info');
    if(!$result)
    {
      $this->response_id = FALSE;
      $this->error = 'Unable to load a response question due to a database error: "'.$this->DB->getError().'"';
    }
    else
    {
      if($this->DB->numRows($result) == 1)
      {
	$answer = $this->DB->getData($result);

	if($answer['answer_id'] == 0)
	{
	  $this->response_question_id = $answer['id'];
	  $this->answers = FALSE;
	}
	else if($answer['answer_id'] == -1)
	{
	  $answer_text = $this->_getAnswerText($answer['id']);
	  $this->response_question_id = $answer['id'];
	  if($answer_text === FALSE)
	    $this->answers = $this->error;
	  else
	    $this->answers = $answer_text;
	}
	else if($this->type == 'single')
	{
	  $this->answers = $answer['answer_id'];
	  $this->answer_id = $answer['answer_id'];
	  $this->response_question_id = $answer['id'];
	}
	else if($this->type == 'multiple')
	{
	  $this->answers[$answer['answer_id']] = $answer['answer_id'];
	  $this->response_question_id = $answer['id'];
	}
      }
      else
      {
	while($row = $this->DB->getData($result))
	{
	  $this->answers[$row['answer_id']] = $row['answer_id'];
	  $this->response_question_id = $row['id'];
	}
      }
    }
  }


  /*****
   * Function: setAnswer()
   * Purpose: To mastermind the setting of a response's question.
   * Parameters: $answer: value of the answer to be set.
   *                      - It can be a string (therefore either a qualitative or single answer.
   *                                            which one is determined by $this->type)
   *                      - It can be an array (which holds answer ids, therefore is multiple answer)
   *                      - It can be boolean FALSE (therefore is a 'no answer' question)
   */
  function setAnswer($answer)
  {
    /* If $answer is Boolean FALSE, the student didn't provide an answer */
    if($answer === FALSE)
      $ret_val = $this->_setNoAnswer();
    else if(is_array($answer))
      $ret_val = $this->_setMultipleAnswer($answer);
    else if(is_string($answer) && ($this->type == 'single' || $this->type == 'multiple'))
      $ret_val = $this->_setSingleAnswer($answer);
    else if(is_string($answer) && $this->type == 'qualitative')
      $ret_val = $this->_setQualitativeAnswer($answer);
    else
    {
      $this->error = 'Unknown question type: "'.$this->type.'"';
      return FALSE;
    }

    if($ret_val)
      return($this->setAsked());
    else
      return FALSE;  
  }

  /*****
   * Function: _setNoAnswer()
   * Purpose: To set the answer of this question to the 'no answer' value (0)
   *
   * Since, if a question is set to no answer, there's no need to store multiple answers,
   * or qualitiative text, this function deletes all answers & qualitative answers & inserts a new
   * answer.
   */
  private function _setNoAnswer()
  {
    /* If this response question was answered previously, remove any answers recorded */
    if(!$this->_deleteExistingAnswers())
      return FALSE;
    else if($this->type == 'qualitative' && isset($this->answer_id) && $this->answer_id)
    {
      /* Delete any qualitative answers if necessary */
      $query = <<<SQL
DELETE
FROM
	response_qualitative
WHERE
	question_response_id = $this->answer_id
SQL;
      $result = $this->DB->execute($query,'deleting qualitative answer text');
      if(!$result)
      {
	$this->error = 'Unable to delete qualitative answer text due to a database error: "'.$this->DB->getError().'"';
	return FALSE;
      }
    }

    /*****
     * Add the new answer
     */
    $query = <<<SQL
INSERT
INTO
      response
      (instance_id,
       response_id,
       number,
       template_id,
       course_id,
       term,
       questionnaire_type,
       school_year,
       question_id,
       answer_id)
VALUES
      ($this->instance_id,
       $this->response_id,
       $this->number,
       $this->template_id,
       $this->course_id,
       $this->term,
       '$this->questionnaire_type',
       '$this->year',
       $this->question_id,
       0)
SQL;

    $result = $this->DB->execute($query,'adding no answer');
    if(!$result)
    {
      $this->error = 'Unable to set answer as "no answer" due to a database error: "'.$this->DB->getError().'"';
      return FALSE;
    }
    else
      return TRUE;
  }

  /*****
   * Function: _setSingleAnswer()
   * Purpose: To set a single answer's answer_id
   * Paramters: $answer: the id of the associated row in the `response` table
   */
  private function _setSingleAnswer($answer)
  {
    /* A REPLACE query is lovely for serving a dual purpose of being suitable for both
     * an initial entry of a response, and the overwriting of an existing answer
     */
    $query = <<<SQL
REPLACE
INTO
      response
      (id,
       instance_id,
       response_id,
       number,
       template_id,
       course_id,
       term,
       questionnaire_type,
       school_year,
       question_id,
       answer_id)
VALUES
      ('$this->response_question_id',
       $this->instance_id,
       $this->response_id,
       $this->number,
       $this->template_id,
       $this->course_id,
       $this->term,
       '$this->questionnaire_type',
       '$this->year',
       $this->question_id,
       $answer)
SQL;

    $result = $this->DB->execute($query,'updating/inserting answer id for a responded question');

    
    if(!$result)
    {
      $this->error = 'Unable to set a single answer for a responded question due to a database error: "'.$this->DB->getError().'"';
      return FALSE;
    }
    else
      return TRUE;
  }


  /*****
   * Function: _setQualitativeAnswer()
   * Purpose: To set the qualitative text for an answer
   * Parameters: the text of the answer
   */
  private function _setQualitativeAnswer($answer)
  {
	$text = cleanGPC($answer);
	require_once INSTALL_DIR.'include/HTMLPurifier/HTMLPurifier.standalone.php';
	$config = HTMLPurifier_Config::createDefault();
	$config->set('HTML.Doctype','XHTML 1.0 Strict');
	$config->set('HTML.Allowed','strong,em,blockquote,p,span[style]');
	$purifier = new HTMLPurifier($config);
	$text = $purifier->purify($text);
		  
    $text = $this->DB->escape($text);
    
    /* Call _setSingleAnswer with an answer_id of -1.  This is a special value that means look in
     * the `response_qualitative` table for some text.
     */
    if(!$this->_setSingleAnswer(-1))
    {
      $this->error = 'Unable to set answer as qualitative due to a database error: "'.$this->DB->getError().'"';
      return FALSE;
    }
    else
    {
      /* we need the id of the newly created answer to put into `response_qualitative` */
      $this->answer_id = $this->DB->lastInsertID();
      $query = <<<SQL
REPLACE
INTO
	response_qualitative
	(question_response_id,
	 text)
VALUES
	($this->answer_id,
	 '$text')
SQL;
      $result = $this->DB->execute($query,'REPLACEing qualitative answer text');
      if(!$result)
      {
	$this->error = 'Unable to REPLACE qualitative answer text due to a database error: "'.$this->DB->getError().'"';
	return FALSE;
      }
      else
	return TRUE;
    }
  }

  /*****
   * Function: _setMultipleAnswer()
   * Purpose: To enter multiple answers
   * Parameter: $answer: an array of Answer ids
   */
  private function _setMultipleAnswer($answer)
  {
    /* Delete all existing answers.  It's too much work to only delete those that are changed, so we'll delete
     * 'em all & re-add 'em all
     */
    if(!$this->_deleteExistingAnswers())
      return FALSE;
    else
    {
      $query = <<<SQL
INSERT
INTO
      response
      (instance_id,
       response_id,
       number,
       template_id,
       course_id,
       term,
       questionnaire_type,
       school_year,
       question_id,
       answer_id)
VALUES
SQL;

      foreach($answer as $answer_id)
      {
	$query .= <<<VALUECLAUSE
	($this->instance_id,
	 $this->response_id,
	 $this->number,
	 $this->template_id,
	 $this->course_id,
	 $this->term,
	 '$this->questionnaire_type',
	 '$this->year',
	 $this->question_id,
	 $answer_id),
VALUECLAUSE;
      }

      $query = rtrim($query,',');
      $result = $this->DB->execute($query,'adding multiple responses');
      if(!$result)
      {
	$this->error = 'Unable to add responses due to a database error: "'.$this->DB->getError().'"';
	return FALSE;
      }
      else
	return TRUE;
    }
  }
  
  /*****
   * Function: setAsked()
   * Purpose: To save the question this object is associated with, as asked
   */
  function setAsked()
  {
    /* Note:  $Question will return FALSE if the user doesn't have unconditional rights & if the
     *        question has been asked.  That's fine because the question's asked status will still
     *        be correct.
     */
    $Question = new Question($this->question_id,TRUE);
    $Question->setAsked(TRUE);
    $Question->saveAsked(TRUE);

    return TRUE;
  }
      
    


  /*****
   * Function: _deleteExistingAnswers()
   * Purpose: To delete all answers for the question this object represents
   */
  private function _deleteExistingAnswers()
  {
    $query = <<<SQL
DELETE
FROM
      response
WHERE
      response_id = $this->response_id AND
      question_id = $this->question_id
SQL;
    $result = $this->DB->execute($query,'deleting existing answers to responded question');
    if(!$result)
    {
      $this->error = 'Unable to delete existing answers to responded question due to a database error: "'.$this->DB->getError().'"';
      return FALSE;
    }
    else
      return TRUE;
  }


  /*****
   * Function: _getAnswerText()
   * Purpose: To retrieve the qualitative answer text
   * Parameters: $answer_id: the unique row id of the answer in `response`
   */
  private function _getAnswerText($answer_id)
  {
    $query = <<<SQL
SELECT
      text
FROM
      response_qualitative
WHERE
      question_response_id = $answer_id
SQL;
    $result = $this->DB->execute($query,'retrieving qualitative answer text');
    if(!$result)
    {
      $this->error = 'Unable to load qualitative answer text due to a database error: "'.$this->DB->getError().'"';
      return FALSE;
    }
    else if($this->DB->numRows($result) > 0)
    {
      $row = $this->DB->getData($result);
      return $row['text'];
    }
  }

  /*****
   * Function: __get()
   * Purpose: Act as a magic getX() function for all object variables
   * Parameters: $name: the name of the variable to return
   * 
   * Note: This is a "magic" function.  Look it up by name in the PHP docs to learn how/why it works.
   */
  function __get($name)
  {
    return $this->{$name};
  }
}
?>