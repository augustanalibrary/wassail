<?PHP
class Question
{
  private $id;
  private $instance_id;
  private $name;
  private $text;
  private $plaintext;
  private $date_added;
  private $asked;
  //this exists because if(isset($Question->answers)) doesn't return TRUE if $answers is set - __get() isn't called.
  private $answers_exist = FALSE;
  private $answers;
  private $new_answers;
  private $correct_answer;
  private $categories;
  private $tags;
  private $positions;
  private $type;
  private $opt_out;

  /* Long (display as a textarea) or short (display as a textfield) */
  private $qualitative_type;
  private $error;
  private $DB;

  function __construct($id=FALSE,$properties_only=FALSE)
  {
    $this->DB = DBi::getInstance();
    $this->instance_id = $_SESSION['instance_id'];

    if($id !== FALSE)
    {
      $this->id = $id;
      if($this->load($properties_only))
		if(!$properties_only)
		  $this->loadAnswers();
    }
	
  }

  /*****
   * Function: load();
   * Purpose: To load all question data stored in the `question` table
   *          This function also initiates loading of categories
   */
  function load($properties_only=FALSE)
  {
    $query = <<<SQL
SELECT
      *
FROM
      question
WHERE
      id = '$this->id' AND
      instance_id = $this->instance_id
SQL;

    $result = $this->DB->execute($query,'retrieving question info');
    if($result && $this->DB->numRows($result))
    {
      $row = $this->DB->getData($result);
      $this->text = $row['text'];
      $this->plaintext = $row['plaintext'];
      $this->tags = $row['tags'];
      $this->type = $row['type'];
      $this->qualitative_type = (is_null($row['qualitative_type'])) ? 'long' : $row['qualitative_type'];
      $this->date_added = $row['date_added'];
      $this->asked = $row['asked'];
	  $this->opt_out = (strlen($row['opt_out'])) ? $row['opt_out'] : $this->opt_out;

      if(!$properties_only)
		if($this->_loadCategories())
		  return TRUE;
		else
		  return FALSE;
		  else
		return TRUE;
    }
    else
      $this->id = FALSE;
  }

  /*****
   * Function: _loadCategories()
   * Purpose: To load the categories for the current question.  Note that this function
   *          is private, so it cannot be called directly.
   */
  private function _loadCategories()
  {
    $query = <<<SQL
SELECT
      id
FROM
      category,
      question_category
WHERE
      category.id = question_category.category_id AND
      question_id = '$this->id'
SQL;
    $result = $this->DB->execute($query,'retrieving all categories');
    if($result)
    {
      while($row = $this->DB->getData($result))
      {
	$this->categories[$row['id']] = $row['id'];
      }
      return TRUE;
    }
    else
      return FALSE;
  }
      
  /*****
   * Function: loadAnswers()
   * Purpose: To load the answers for the current question.
   * Result: Fills $this->answers with an array with keys=answer ids & values=Answer objects
   */
  function loadAnswers()
  {
    if(isset($this->answers))
      $this->answers = array();

    $query = <<<SQL
SELECT
      id
FROM
      answer
WHERE
      question_id = '$this->id' AND
      instance_id = $this->instance_id
ORDER BY
      position ASC
SQL;
    $result = $this->DB->execute($query,"retrieving answers for question #$this->id");
    if($result && $this->DB->numRows($result))
    {
      while($row = $this->DB->getData($result))
      {
		$this->answers[$row['id']] = new Answer($row['id']);
		$this->answers_exist = TRUE;
      }
      if(count($this->answers) == 0)
      {
		unset($this->answers);
		$this->answers_exist = FALSE;
      }
    }
  }

  /*****
   * Function: loadPositions()
   * Purpose: To load an array of the positions this question holds in different templates
   * Result: Sets $this->positions.  Indices are template ids, keys are positions in that template
   */
  function loadPositions()
  {
    $query = <<<SQL
SELECT
      *
FROM
      question_template
WHERE
      question_id = '$this->id'
SQL;

    $result = $this->DB->execute($query,'retrieving question positions');
    if(!$result)
    {
      $this->error = 'Could not load question positions due to a database error: "'.$this->DB->getError().'"';
      return FALSE;
    }
    else
    {
      if($this->DB->numRows($result))
      {
	while($row = $this->DB->getData($result))
	{
	  $this->positions[$row['template_id']] = $row['position'];
	}
      }
      return TRUE;
    }
  }




  /*****
   * Function: setText()
   * Purpose: Allow the user to set the text for this question.
   * Result: Sets $this->text & $this->plaintext.
   * Parameters: Raw POSTed text
   */
  function setText($text)
  {
    $this->text = strip_tags(cleanGPC($text),ALLOWED_TAGS);
    $this->plaintext = strip_tags($text);
  }

  /*****
   * Function: setAsked()
   * Purpose: Allow the user to set the 'asked' flag
   *          This function ensures $this->asked is set to a boolean value, regardless of user input
   * Parameters: $asked - a value that should evaluate equal to boolean true or false (so could be 1 or 0 as well)
   */
  function setAsked($asked)
  {
    $this->asked = ($asked) ? TRUE : FALSE;
    return TRUE;
  }

  /*****
   * Function: saveAsked()
   * Purpose: Allow the user to just save the 'asked' property without needing
   *          unconditional right privileges.  This does bypass the right check
   *          in save(), so any call to this function should only be done
   *          if the user has adequate (write) privileges
   * Parameters: The asked status
   */
  function saveAsked($asked)
  {
    if($this->setAsked($asked))
      if($this->_saveExisting($this->DB->escape($this->text),$this->DB->escape($this->plaintext),$this->DB->escape($this->tags),$this->type,$this->qualitative_type,$asked,$this->DB->escape($this->opt_out)))
	return TRUE;
    return FALSE;
  }

  /*****
   * Function: setCategories()
   * Purpose: To allow the user to set the categories for the current question
   *          The values of the passed array should be integers, but are cast as integers
   *          to be safe & to prevent buggering up the db.
   * Parameters: an array of category ids.
   */
  function setCategories($categories)
  {
    if(is_array($categories))
    {
      foreach($categories as $id)
      {
	$id = (int)$id;
	$cleaned_categories[$id] = (int)$id;
      }
      $this->categories = $cleaned_categories;
    }
    else
      $this->categories = array();
  }

  /*****
  * Function: setTags()
  * Purpose: To allow the user to set the tags associated with this question.
  *          This is a plaintext field, so all tags are stripped
  * Parameters: Tags - can pretty much be any string
  */
  function setTags($tags)
  {
    $tags = explode(TAG_DELIMITER,strtolower($tags));
    array_walk($tags,create_function('&$v,$k','$v = trim($v);'));
    $tags = implode(', ',$tags);
    $this->tags = strip_tags(cleanGPC($tags));
  }

  /*****
   * Function: setType()
   * Purpose: To allow the user to set which type of question this is - multiple choice, single choice, or qualitative
   *          This function does not put user input directly into the variable.
   *          If the input is not 'multiple', 'qualitative_long' or 'qualitative_short, this->type gets set to 'single'
   * Parameters: The question type.  Should be one of these values: 'multiple','qualitative_long','qualitative_short','single'
   *             The value of the 'Answer format' radio buttons should mirror these values.
   */
  function setType($type)
  {
    switch($type)
    {
      case 'multiple':
	$this->type = 'multiple';
	break;
      case 'qualitative_long':
	$this->type = 'qualitative';
	$this->setQualitativeType('long');
	break;
      case 'qualitative_short';
        $this->type = 'qualitative';
        $this->setQualitativeType('short');
        break;
      default:
	$this->type = 'single';
	break;
    }
  }

  /*****
   * Function: setQualitativeType()
   * Purpose: To set which type of qualitative question this is - a long answer or a short answer
   * Parameters: The qualitiative type: "short" or "long".  If the passed parameter is not one of those
   *             values, the function defaults to "long"
   */
  private function setQualitativeType($type)
  {
    $this->qualitative_type = ($type == 'short') ? 'short' : 'long';
  }




  /*****
   * Function: setNewAnswers()
   * Purpose: To set the answers to be saved to this question.
   * Parameters: $answers - an array indexed by ids, populated with answer text
   *             The order the ids appear is the order the answers will appear in the question
   *             negative ids denote new questions
   */
  function setNewAnswers($answers)
  {
    $this->new_answers = $answers;
  }




  /*****
   * Function: setCorrectAnswer()
   * Purpose: To flag an answer as correct
   * Parameters: $answer_id - an answer id.  Can be a valid id, or a negative value (to match up with an answer that hasn't been created yet)
   * Note: This function will only work if the question type is 'single'
   */
  function setCorrectAnswer($answer_id)
  {
    if($this->type == 'single')
    {
      $this->correct_answer = $answer_id;
      return TRUE;
    }
    else
    {
      $this->error = 'Question cannot have a "correct" answer, as it is not a single-answer question';
      return FALSE;
    }
  }
  
  	/*****
	 * Function: setOptOut()
	 * Parameters: $text - the text to display beside the opt out checkbox
	 */
	function setOptOut($text)
	{
		$this->opt_out = $text;
		return TRUE;
	}


  /*****
   * Function: save()
   * Purpose: To save the properties of a question.
   * Parameters: None - all data necessary for this function is stored
   *             in object variables.
   * If the question hasn't been saved before, a new question is created.
   */

  function save()
  {
    /** 
     * verify that this question can be modified 
     */
    if($this->asked)
    {
      $Account = Account::getInstance();
      if(!$Account->right_write_unconditional)
      {
		$this->error = 'You do not have permissions to edit that question';
		return FALSE;
      }
    }

    /** 
     * If the ID passed was invalid, load() will have reset it to FALSE 
     */
    if($this->id === FALSE)
    {
      $this->error = 'Question does not exist';
      return FALSE;
    }

    /**
     * Set the question type
     */
    if(!isset($this->type) || strlen($this->type) == 0)
      $this->setType('single');

    /**
     * Require there to be question text
     */
    if(!isset($this->text) || strlen($this->text) == 0)
    {
      $this->error = "Question text must be entered.";
      return FALSE;
    }

    /**
     * Escape all the necessary data
     */
    $text = $this->DB->escape($this->text);
    $plaintext = $this->DB->escape($this->plaintext);
    $tags = $this->DB->escape($this->tags);
    $asked = ($this->asked == TRUE) ? 1 : 0;
	$opt_out = $this->DB->escape($this->opt_out);

    /**
     * Check length of text fields to warn the user about truncation
     *
     * 65535 is the max number of characters a MySQL TEXT field will hold
     */
    $text_length = strlen($text);
    if($text_length > 65535)
      $this->error = "Question text is too long.  Including formatting & database correction, it can only be 65535 characters.  The question is $text_length characters long";
    $tag_length = strlen($tags);
    if($tag_length > 65535)
      $this->error = "Tag text is too long.  Including formatting & database correction, it can only be 65535 characters.  The tags are $tag_length characters long";

	$opt_out_length = strlen($opt_out);
	if(strlen($opt_out) > 255)
		$this->error = "Opt out text is too long.  Including database correction it can only be 255 characters.  The text is $opt_out_length characters long.";

    /***
     * Save all data but the categories
     */
    if(!$this->id)
      $success = $this->_saveAsNew($text,$plaintext,$tags,$this->type,$this->qualitative_type,$asked,$opt_out);
    else
      $success = $this->_saveExisting($text,$plaintext,$tags,$this->type,$this->qualitative_type,$asked,$opt_out);

    if($success)
      $success = $this->_saveCategories();

    //delete all answers if this question is newly saved as qualitative.
    //not necessary, but it cleans up irrelevant answers
    if($success && $this->type == 'qualitative' && count($this->answers) > 0)
      $success = $this->_deleteAnswers();
    else if($success && $this->type != 'qualitative')
      $success = $this->_saveNewAnswers();
        

    return ($success) ? TRUE : FALSE;
  }

  /*****
   * Function: _saveAsNew()
   * Purpose: To save a question as new
   * Parameters: Properly escaped & cleaned $text (rich text), $plaintext, $tags,$type,$qualitative_type, $asked, and $opt_out
   *
   * Set as private so only functions within this class can call it
   */
  private function _saveAsNew($text,$plaintext,$tags,$type,$qualitative_type,$asked,$opt_out)
  {
    $query = <<<SQL
INSERT
INTO
      question
      (instance_id,
       text,
       plaintext,
       tags,
       type,
       qualitative_type,
       date_added,
       asked,
	   opt_out)
VALUES
      ('$this->instance_id',
       '$text',
       '$plaintext',
       '$tags',
       '$type',
       '$qualitative_type',
       UNIX_TIMESTAMP(NOW()),
       '$asked',
	   '$opt_out')
SQL;
    if($this->DB->execute($query,'adding a question'))
    {
      $this->id = $this->DB->lastInsertID();
      return TRUE;
    }
    else
    {
      $this->error = 'Question could not be added due to a database error: "'.$this->DB->getError().'"';
      return FALSE;
    }
  }

  /*****
   * Function: _saveExisting
   * Purpose: To save an existing question
   * Parameters: Properly escaped & cleaned $text (rich text, $plaintext, $tags,$type, $qualitative_type, $asked, and $opt_out
   *
   * Set as private so only functions within this class can call it
   */
  private function _saveExisting($text,$plaintext,$tags,$type,$qualitative_type,$asked,$opt_out)
  {
    $query = <<<SQL
UPDATE
      question
SET
      text = '$text',
      plaintext = '$plaintext',
      tags = '$tags',
      type = '$type',
      qualitative_type = '$qualitative_type',
      asked = '$asked',
	  opt_out = '$opt_out'
WHERE
      id = '$this->id' AND
      instance_id = '$this->instance_id'
SQL;

    if(!$this->DB->execute($query,'updating a question'))
    {
      $this->error = 'Question could not be updated due to a database error: "'.$this->DB->getError().'"';
      return FALSE;
    }
    else
      return TRUE;
  }


  /*****
  * Function: _saveCategories()
  * Purpose: To save the categories for the current question
  */
  private function _saveCategories()
  {
    /***
     *  Delete any existing categories 
     */
    $query = <<<SQL
DELETE
FROM
      question_category
WHERE
      question_id = '$this->id'
SQL;
    if($this->DB->execute($query,'clearing pre-existing category assignments'))
    {
      /***
       * Add new categories if they're present
       */
      if(is_array($this->categories) && count($this->categories))
      {
	$query = 'INSERT INTO question_category (question_id,category_id) VALUES ';
	foreach($this->categories as $category_id)
	{
	  $query .= "('".$this->id."',".$category_id.'),';
	}
	$query = rtrim($query,',');

	if(!$this->DB->execute($query,'adding category assignments'))
	{
	  $this->error = 'Question categories could not be updated due to a database error: "'.$this->DB->getError().'"';
	  return FALSE;
	}
	else
	  return TRUE;
      }
      else
	return TRUE;
    }
    else
    {
      $this->error = 'Pre-existing question categories could not be updated due to a databaes error: "'.$this->DB->getError().'"';
      return FALSE;
    }
  }

  /*****
   * Function: _saveNewAnswers()
   * Purpose: To save answers as stored in $new_answers, to this question
   */
  private function _saveNewAnswers()
  {
    if(!is_array($this->new_answers))
    {
      $this->error = 'No answers were available to save. The question has been created without answers.';
      return FALSE;
    }


    $position = 1;
    foreach($this->new_answers as $id=>$text)
    {
      $Answer = ($id > 0) ? new Answer($id) : new Answer();
      $Answer->setQuestionID($this->id);
      $Answer->setText($text);
      $Answer->setPosition($position);
      if($id == $this->correct_answer)
	$Answer->setCorrect(true);


      $position++;

      if(!$Answer->save())
      {
	$this->error = $Answer->error;
	return FALSE;
      }
    }


    /* Delete any answers that are no longer associated with this question */
    $new_answer_ids = array_keys($this->new_answers);
    if(is_array($this->answers))
    {
      foreach($this->answers as $answer_id=>$Answer)
      {
	if(!in_array($answer_id,$new_answer_ids))
	{
	  if(!$this->deleteAnswer($answer_id))
	    return FALSE;
	}
      }
    }

    $this->loadAnswers();

    return TRUE;
  }

      
  /*****
   * Function: saveClassification()
   * Purpose: To save only the categories & tags for a question
   */
  function saveClassification()
  {
    if($this->_saveCategories())
    {
      $query = <<<SQL
UPDATE
	question
SET
	tags = '$this->tags'
WHERE
	id = '$this->id' AND
	instance_id = '$this->instance_id'
SQL;
      $result = $this->DB->execute($query,'updating tags');
      if($result)
	return TRUE;
      else
      {
	$this->error = 'Question tags could not be saved due to a database error: "'.$this->DB->getError().'"';
	return FALSE;
      }
    }
    else
      return FALSE;
  }


  /*****
   * Function: delete()
   * Purpose: To delete this current question & all answers
   */
  function delete()
  {
    /***
     * Make sure an asked question cannot be deleted
     */
    if($this->asked)
    {
      $this->error = 'Question cannot be deleted because it has been asked.';
      return FALSE;
    }

    /***
     * Make sure this question isn't in any templates
     */
    $this->loadPositions();
    if(count($this->positions) > 0)
    {
      $this->error = 'Question cannot be deleted because it is in template(s): ';
      foreach($this->positions as $template_id=>$position)
      {
	$this->error .= "$template_id, ";
      }
      $this->error = rtrim($this->error,', ');
      return FALSE;
    }



    /***
     * Delete the question
     */
    $query = <<<SQL
DELETE
FROM
      question
WHERE
      id = '$this->id' AND
      instance_id = '$this->instance_id'
SQL;
    $result = $this->DB->execute($query,'deleting a question');
    if(!$result)
    {
      $this->error = 'Question could not be deleted due to a database error: "'.$this->DB->getError().'"';
      return FALSE;
    }
    else if($this->DB->affectedRows() == 0)
    {
      $this->error = "Question could not be found.";
      return FALSE;
    }
    /***
     * Delete the relevant answers
     */
    else
      $this->_deleteAnswers();

    
    return ($this->error) ? FALSE : TRUE;
  }


  /*****
   * Function: _deleteAnswers()
   * Purpose: To delete all the answers associated with this question
   */
  private function _deleteAnswers()
  {
    $error = FALSE;
    if(count($this->answers))
    {
      foreach($this->answers as $Answer)
      {
	$delete_success = $Answer->delete();
	if(!$delete_success)
	  $error = "One or more answers for question # $this->id were not deleted.  Please contact Nancy Goebel ";
      }
    }

    if($error)
    {
      $this->error = $error;
      return FALSE;
    }
    else
      return TRUE;
  }


  /*****
   * Function: deleteAnswer()
   * Purpose: To delete an answer & appropriately shift around the priorities of other answers
   * Parameters: $id: the id of the answer to delete
   */
  function deleteAnswer($id)
  {
    /* Get a list of all the answers that will need their position changed
     * after the target answer is deleted.
     */
    if(is_array($this->answers))
    {
      $passed_curr_answer = FALSE;
      foreach($this->answers as $curr_answer_id=>$CurrAnswer)
      {
	if($curr_answer_id == $id)
	  $passed_curr_answer = TRUE;
	if($passed_curr_answer)
	  $answers_to_modify[$curr_answer_id] =& $CurrAnswer;
      }
    }

    if($this->answers[$id]->delete())
    {
      if(is_array($answers_to_modify))
	foreach($answers_to_modify as $curr_answer_id=>$CurrAnswer)
	{
	  $CurrAnswer->setPosition = $CurrAnswer->position - 1;
	  if($CurrAnswer->save())
	    $this->error = $CurrAnswer->error;
	}

      $this->loadAnswers();
      return ($this->error) ? FALSE : TRUE;
    }
    else
    {
      $this->error = $this->answers[$id]->error;
      return FALSE;
    }
  }


  function __get($name)
  {
    return $this->{$name};
  }
}
?>