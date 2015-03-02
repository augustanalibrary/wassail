<?PHP
  /**********
   * Class: Response
   * Purpose: To handle all the work around inserting response data into the database
   * Notes:
   *        If an individual question has an answer_id of 0, the student did not provide a response.
   *        If an individual question has an answer_id of -1, the student provided a qualitiative response.
   *
   *        Yes I realize stuff like the template id, course_id, term, etc should be stored in a separate
   *        table along with the response id.  That's called normalization.  However, with that information
   *        stored all in one table, reporting is going to be MUCH quicker & easier.
   */

class Response
{
  private $instance_id;
  private $response_id;
  private $number;
  private $template_id;
  private $Template;
  private $course_id;
  private $Course;
  private $term;
  private $type;
  private $year;
  public $filenames = array();
  private $error;
  private $questions;
  private $DB;

  function __construct($response_id = FALSE)
  {
    $this->instance_id = $_SESSION['instance_id'];

    $this->DB = DBi::getInstance();

    $this->response_id = $response_id;
    if($this->response_id !== FALSE)
      $this->load();
  }

  /*****
   * Function: setProperties()
   * Purpose: To set all the properties for this response.
   * Parameters: $template_id,$course_id,$term (the term id), $type (the type id), $year, $number (the number
   *             on the questionnaire given to the student)
   * Note: If this function is called and $this->response_id is set, this function updates
   *       all the existing rows in `response` for this Response, to the new $number (if new)
   */
  function setProperties($template_id,$course_id,$term,$type,$year,$number)
  {
    $this->template_id = $template_id;
    $this->course_id = $course_id;
    $this->term = $term;
    $this->type = $type;
    $this->year = $year;

    $this->Template = new Template($this->template_id,TRUE);
    $this->Course = new Course($this->course_id);

	//if the passed number is different than the number $this already knows about, update $this
    $number = (int)$number;
    if(isset($this->number) && $number != $this->number)
	{
		if($this->_updateResponseNumber($number))
			return TRUE;
		else
			return FALSE;
	}
	//otherwise, if the passed number is the same, check it
    else if($number == $this->number)
    {		
      if(!$this->_checkResponseNumber($number,$this->response_id))
      {
		/* _checkResponseNumber will have generated & stored the error text */
		return FALSE;
      }
      else
      {
		$this->number = $number;
		return TRUE;
      }
    }
	
	//otherwise, make sure we've got a unique number because we're adding a new response
    else
    {
		$number_is_ok = FALSE;
		do
		{
			$number_is_ok = $this->_checkResponseNumber($number);
			if(!$number_is_ok)
				$number++;
		}
		while(!$number_is_ok);
		
		//need to undo the error message _checkResponseNumber() would have generated.
		$this->error = FALSE;
		$this->number = $number;
		return TRUE;
      }
  }

  /*****
   * Function: _updateResponseNumber()
   * Purpose: To update all the existing rows in `response` for this Response, to $number
   * Parameters: $number: the new number
   */
  private function _updateResponseNumber($number)
  {
    if(!$this->_checkResponseNumber($number,$response_id))
      return FALSE;

    $query = <<<SQL
UPDATE
      response
SET
      number = $number
WHERE
      response_id = $this->response_id
SQL;

    $result = $this->DB->execute($query,'updating response number');
    if(!$result)
    {
      $this->error = 'Unable to update response number due to a database error: "'.$this->DB->getError().'"';
      return FALSE;
    }
    else
      return TRUE;
  }


  /*****
   * Function: _checkResponseNumber()
   * Purpose: To check the response number & see if it's already been used
   * Parameters: The number to check.  Also refers to a bunch of object parameters
   *             $existing_response_number: the id of a response that is known to have the number being checked for.
   *                                        this parameter is used when calling this function from _updateResponseNumber
   *                                        when you don't want it to fail because a response is numbered the same as itself
   */
  private function _checkResponseNumber($number,$existing_response_id=FALSE)
  {
    $existing_clause = ($existing_response_id !== FALSE) ? " AND response_id != $existing_response_id " : '';
    $query = <<<SQL
SELECT
      count(*) as 'count'
FROM
      response
WHERE
      instance_id = $this->instance_id AND
      template_id = $this->template_id AND
      course_id = $this->course_id AND
      term = $this->term AND
      school_year = '$this->year' AND
      number = $number
      $existing_clause
SQL;

    $result = $this->DB->execute($query,'checking response number');
    if(!$result)
    {
      $this->error = 'Unable to check response number due to a database error: '.$this->DB->getError();
      return FALSE;
    }
    else
    {
      $row = $this->DB->getData($result);
      if($row['count'] > 0)
      {
    		$this->error = "Cannot create response because response #$number has already been entered";
    		return FALSE;
      }
      else
	return TRUE;
    }
  }

  /*****
   * Function: load()
   * Purpose: To load all the properties, questions & answers for this response
   * Parameters: None - loads based on $this->response_id
   */
  	function load()
  	{
		$query = <<<SQL
			SELECT
				*
			FROM
				response
			WHERE
				response_id = $this->response_id
SQL;
		$result = $this->DB->execute($query,'retrieving response data');
		if(!$result)
		{
			$this->error = 'Unable to load response due to a database error: "'.$this->DB->getError().'"';
			$this->response_id = FALSE;
			return FALSE;
		}
		else
		{
			/* $this->load shouldn't be called unless it's loading an already entered Response, which necessarily
			 * must have some rows in `response`.  If not, this function was called wrongly somehow
			*/
			if($this->DB->numRows($result) == 0)
			{
				$this->error = "Unable to load response because no response with response id $this->response_id was found";
				$this->response_id = FALSE;
				return FALSE;
			}
			else
			{
				while($row = $this->DB->getData($result))
				{
					/* I know, I know - it's really inefficient to be setting the same variables to the same
					* values over & over in a loop, but I figure it's more efficient than a) putting in a condition
					* to decide whether to set the value or not and b) doing a separate query to get those values
					*/
					$this->instance_id = $row['instance_id'];
					$this->template_id = $row['template_id'];
					$this->course_id = $row['course_id'];
					$this->term = $row['term'];
					$this->type = $row['questionnaire_type'];
					$this->year = $row['school_year'];
					$this->number = $row['number'];
					$Question = new Question($row['question_id']);
					$this->questions[$row['question_id']] = new ResponseQuestion($this->response_id,
										   $this->number,
										   $this->template_id,
										   $this->course_id,
										   $this->term,
										   $Question->type,
										   $this->type,
										   $this->year,
										   $row['question_id']);
				}
			}
		}
			
		//load file if necessary
		$query = 'SELECT * FROM `response_id` WHERE `id` = '.$this->response_id;
		$result = $this->DB->execute($query,'potentially loading file');
		if(!$result)
		{
			$this->error = 'Unable to determine if a file was uploaded for this response';
			return FALSE;
		}
		else
		{
			$row = $this->DB->getData($result);
			if(strlen($row['filenames'])){
			   $this->filenames = explode(',', $row['filenames']);
      }
		}
	}


  /*****
   * Function: setAnswer()
   * Purpose: To set an answer value
   * Parameters: $Question (by reference) - pretty much just for the id
   *             $answer: The answer id to set the question value to.  Note that
   *                      this function doesn't alter it's behaviour depending on
   *                      which type of quesion (no answer, single answer, multiple
   *                      answer, qualitative) - that logic is performed by ResponseQuestion::setAnswer
   */
  function setAnswer(&$Question,$answer)
  {
    if($this->response_id === FALSE)
      $this->_getNextResponseID();

    /* Only add answers if the id has been found/generated */
    if($this->response_id !== FALSE)
    {
      if(!$this->Template->asked)
      {
		$this->Template->setAsked(TRUE);
		$this->Template->save();
      }
      if(!$this->Course->asked)
      {
		$this->Course->setAsked(TRUE);
		$this->Course->save();
      }

      $ResponseQuestion = new ResponseQuestion($this->response_id,
					       $this->number,
					       $this->template_id,
					       $this->course_id,
					       $this->term,
					       $Question->type,
					       $this->type,
					       $this->year,
					       $Question->id);

      if($ResponseQuestion->setAnswer($answer))
		return TRUE;
      else
      {
		$this->error = $ResponseQuestion->error;
		return FALSE;
      }
    }
    else
      return FALSE;
  }



  /*****
   * Function: _getNextResponseID()
   * Purpose: To get the ID that should be assigned to the next response
   *
   * Note: So, this function inserts a row into the special `response_id` table & retrieves
   *       the id of the newly created row.  MySQL worries about making the ids unique.
   *       This may seem a bit weird, but it's neccesary to prevent response_id collisions &
   *       must be done this way because the response data isn't 100% normalized.
   */
  function _getNextResponseID()
  {
    $query = <<<SQL
INSERT
INTO
      response_id
      (id)
VALUES
      ('')
SQL;
    $result = $this->DB->execute($query,'inserting row to generate next id');
    if(!$result)
    {
      $this->error = 'Unable to insert row to generate next id due to a database error: "'.$this->DB->getError().'"';
      return FALSE;
    }
    $this->response_id = $this->DB->lastInsertId();
  }

	/*****
	 * Function: checkFile()
	 * Purpose: To check a file upload
	 * Parameters: $file - an array as provided by PHP when a file is uploaded ('tmp_name','error,etc)
	 */
	function checkFile($file)
	{
    if(isset($file['error'])){
  		switch($file['error']){
        case UPLOAD_ERR_OK:
          return TRUE;
  			case UPLOAD_ERR_INI_SIZE:
  				$this->error = 'The uploaded file is larger than the server allows.';
  				return FALSE;
  			case UPLOAD_ERR_FORM_SIZE:
  				$this->error = 'The uploaded file is larger than the form allows.';
  				return FALSE;
  			case UPLOAD_ERR_PARTIAL:
  				$this->error = 'The file was only partially uploaded.';
  				return FALSE;
  			case UPLOAD_ERR_NO_TMP_DIR:
  				$this->error = 'File could not be uploaded: Temporary folder not found.';
  				return FALSE;
  			case UPLOAD_ERR_CANT_WRITE:
  				$this->error = 'File could not be uploaded: Unable to save the file on the server.';
  				return FALSE;
  			case UPLOAD_ERR_NO_FILE:
            $this->error = 'Please ensure you have selected a file to upload';
            return FALSE;
        default:
          $this->error = 'An unknown error occurred when uploading the file: #'.$file['error'];
          return FALSE;
  		}
    }
    else{
      $this->error = 'No file was uploaded';
      return FALSE;
    }

    return TRUE;		
	}

  /*****
   * Function: moveFile()
   * Purpose: To save the file information to the response record
   */
  public function moveFile($file,$index){
    $filename = $this->response_id.'-'.$index.'-'.$file['name'];

    $path = UPLOAD_DIR.'responses/'.$filename;
    if(!move_uploaded_file($file['tmp_name'],$path)){
      $this->error = 'File could not be moved to permanent location on the server.';
      return FALSE;
    }

    return $filename;
  }

  /*****
   * Function: deleteFile()
   * Purpose: To delete an associated file
   */
  public function deleteFile($filename){
    if($this->legitimateFile($filename)){
      if($this->ownFile($filename)){
        if(unlink(realpath(UPLOAD_DIR.'responses/'.$filename))){
          $index = array_search($filename, $this->filenames);
          if($index !== FALSE){
            unset($this->filenames[$index]);
            return $this->saveFiles($this->filenames);
          }
        }
        else{
          $this->error = 'The file was not deleted due to an unknown filesystem error';
          return FALSE;
        }
      }
      else{
        $this->error = 'The submitted filename does not belong to this response';
        return FALSE;
      }
    }
    else{
      $this->error = 'The submitted filename is not considered an actual uploaded response file';
      return FALSE;
    }
  }

  private function legitimateFile($filename){
    $file_path = UPLOAD_DIR.'responses/'.$filename;
    return (realpath($file_path) == $file_path);
  }

  private function ownFile($filename){
    return in_array($filename, $this->filenames);
  }

  public function saveFiles($filenames){
    $filenames = implode(',',$filenames);
    $query = 'UPDATE `response_id` SET `filenames` = "'.$filenames.'" WHERE `id` = '.$this->response_id;
    $result = $this->DB->execute($query,'updating response record to show the uploaded file name');
    if(!$result)
    {
      $this->error = 'Unable to store the filenames in the database due to a database error: "'.$this->DB->getError().'"';
      return FALSE;
    }

    $this->filenames = $filenames;
    return TRUE;
  }



																										 



  /*****
   * Function: delete()
   * Purpose: To delete this response
   * Note: This function resets the 'asked' flag on any Templates & Questions that are no longer
   *       asked, once this response is removed from `response`
   */
  function delete()
  {
    $query = <<<SQL
DELETE
FROM
      response
WHERE
      response_id = $this->response_id
SQL;
    $result = $this->DB->execute($query,'deleting response');
    if(!$result)
    {
      $this->error = 'Error deleting response from database, due to a database error: "'.$this->DB->getError().'"';
      return FALSE;
    }
    else
    {
		
		// delete any file possibly associated with this response
		if($this->filename != FALSE)
		{
			$filepath = UPLOAD_DIR.'responses/'.$this->filename;
			
			if(realpath($filepath) == $filepath)
				unlink($filepath);
		}
		
      /* Now need to check each template & question that was contained in this response, to possibly reset
       * the "asked" flag
       */
      $question_ids = implode(',',array_keys($this->questions));
      $query = <<<SQL
SELECT
	template_id,
	question_id,
	course_id
FROM
	response
WHERE
	template_id = $this->template_id OR
	question_id in ($question_ids)
SQL;

      $result = $this->DB->execute($query,'checking if template & questions are still asked');
      if(!$result)
      {
	$this->error = 'Unable to check if template and/or questions and/or courses  are still asked, due to a database error: "'.$this->DB->getError().'"';
	return FALSE;
      }
      else
      {
	$template_still_asked = FALSE;
	$course_still_asked = FALSE;
	$questions_still_asked = array();

	/* loop through & find all still-asked question ids & template id */
	while($row = $this->DB->getData($result))
	{
	  if($row['template_id'] == $this->template_id)
	    $template_still_asked = TRUE;
	  if($row['course_id'] == $this->course_id)
	    $course_still_asked = TRUE;
	  if(array_key_exists($row['question_id'],$this->questions))
	    $questions_still_asked[] = $row['question_id'];
	}

	if(!$template_still_asked)
	{
	  $Template = new Template($this->template_id);
	  $Template->setAsked(FALSE);
	  if(!$Template->save())
	  {
	    $this->error = $Template->error;
	    return FALSE;
	  }
	}
	if(!$course_still_asked)
	{
	  $Course = new Course($this->course_id);
	  $Course->setAsked(FALSE);
	  if(!$Course->save())
	  {
	    $this->error = $Template->error;
	    return FALSE;
	  }
	}

	foreach($this->questions as $question_id=>$properties)
	{
	  if(!in_array($question_id,$questions_still_asked))
	  {
	    $Question = new Question($question_id,TRUE);
	    if(!$Question->saveAsked(FALSE))
	    {
	      $this->error = $Question->error;
	      return FALSE;
	    }
	  }
	}
	return TRUE;
      }
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
    if(isset($this->{$name}))
      return($this->{$name});
    else
      return NULL;
  }
}
?>