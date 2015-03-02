<?PHP
  /*****
   * Class: Template
   * Purpose: To manage a single WASSAIL template & all it's properties.  This is NOT the template
   *          engine that files refer to with $tpl.  That's Template Lite
   */

class Template
{
  private $id;
  private $instance_id;
  private $name;
  private $date_added;
  private $questions;
  private $asked;
  private $error;
  private $duplicate_name;
  private $DB;

  /*****
   * Function: __construct()
   * Purpose: Create the object
   * Parameters: [boolean] $properties_only.  If set to TRUE, the questions for this template
   *             won't be loaded, just the template properties.  This is useful when
   *             you only want to do maintenance on the template without a lot of loading.
   */
  function __construct($id=0,$properties_only=FALSE)
  {
    $this->DB = DBi::getInstance();

    if($id !== 0)
    {
      $this->id = $id;
      $this->load($properties_only);
    }
  }

  /*****
   * Function: setName()
   * Purpose: To set $this->name as a sane value.  $name is private so this function MUST
   *          be used if you want to set $this->name
   */
  function setName($name)
  {
    $this->name = strip_tags(cleanGPC($name));
    $this->name = str_replace('"',"'",$this->name);
  }

  /*****
   * Function: setAsked()
   * Purpose: To set the 'asked' flag.  Defaults to TRUE unless $asked evaluates to Boolean TRUE
   */
  function setAsked($asked)
  {
    $this->asked = ($asked) ? TRUE : FALSE;
  }


  /*****
   * Function: load()
   * Purpose: To load all things relevant to this question
   * Parameters: [boolean] $properties_only.  If set to TRUE, the questions for this
   *                                          template won't be loaded.
   */
  function load($properties_only=FALSE)
  {
    $query = <<<SQL
SELECT
      *
FROM
      template
WHERE
      id = $this->id
SQL;
    $result = @$this->DB->execute($query,"loading template #$this->id",FALSE);
    if($result)
    {
      if($this->DB->numRows($result))
      {
	$row = $this->DB->getData($result);
	$this->instance_id = $row['instance_id'];
	$this->name = $row['name'];
	$this->date_added = $row['date_added'];
	$this->asked = $row['asked'];
	if(!$properties_only)
	  $this->loadQuestions();
	return TRUE;
      }
      else
      {
	$this->id = FALSE;
	$this->error = "No template with id #$this->id exists";
	return FALSE;
      }
    }
    else
    {
      $this->error = 'Template could not be loaded due to a database error: "'.$this->DB->getError().'"';
      return FALSE;
    }
  }


  /*****
   * Function: loadQuestions()
   * Purpose: To load the questions for this template
   */
  function loadQuestions()
  {
    $query = <<<SQL
SELECT
      *
FROM
      question_template
WHERE
      template_id = $this->id
ORDER BY
      position asc
SQL;
    $result = $this->DB->execute($query,"Retrieving questions for template #$this->id");
    if($result)
    {
      if($this->DB->numRows($result))
      {
		$this->questions = array();
		while($row = $this->DB->getData($result))
		{
		  $this->questions[] = new Question($row['question_id']);
		}
      }
      else
	$this->questions = array();

      return TRUE;
    }
    else
    {
      $this->error = 'Unable to load questions due to a database error: "'.$this->DB->getError().'"';
      return FALSE;
    }
  }



  /*****
   * Function: save()
   * Purpose: To save the properties (not questions) for this template
   *          If $this->id is set to the default of 0, the template is saved
   *          as new.  If it's a non-zero value, it's overwritten.
   */
  function save()
  {
    if(strlen($this->name) == 0)
    {
      $this->error = 'Cannot save Template because the Template name is empty';
      return FALSE;
    }

    if($this->id == 0)
      $success = $this->_saveAsNew();
    else
      $success = $this->_saveExisting();

    if($success)
      return TRUE;
    else
      return FALSE;
  }



  /*****
   * Function: _saveAsNew()
   * Purpose: To save the existing template as a new template
   * Note: This function is private so it can't be called from outside the class.
   *       To save a template, Template::save() should be called.
   */
  private function _saveAsNew()
  {
    $Account = Account::getInstance();
    $this->instance_id = $Account->instance_id;

    $name = $this->DB->escape($this->name);
    $query = <<<SQL
INSERT
INTO
      template
      (instance_id,
       name,
       date_added)
VALUES
      ($this->instance_id,
       '$name',
       UNIX_TIMESTAMP(NOW()))
SQL;
    $result = $this->DB->execute($query,'adding new template',FALSE);
    if($result)
    {
      $this->id = $this->DB->lastInsertID();
      return TRUE;
    }
    else
    {
      if($this->DB->getErrNum() == 1062)
      {
	$this->error = 'Could not create template because a template named "'.$this->name.'" already exists';
	$this->DB->clearErrors();
      }
      else
	$this->error = 'Could not save Template due to a database error: "'.$this->DB->getError().'"';
      return FALSE;
    }
  }



  /*****
   * Function: _saveExisting
   * Purpose: To update the template this object represents
   */
  private function _saveExisting()
  {
    $name = $this->DB->escape($this->name);
    $asked = ($this->asked) ? 1 : 0;

    $query = <<<SQL
UPDATE
      template
SET
      name = '$name',
      asked = $asked
WHERE
      id = $this->id AND
      instance_id = $this->instance_id
SQL;

    $result = $this->DB->execute($query,"updating template #$this->id",FALSE);
    if($result)
      return TRUE;
    else
    {
      if($this->DB->getErrNum() == 1062)
      {
	$this->error = 'Could not save Template because a Template with that name already exists.';
	$this->DB->clearErrors();
      }
      else
	$this->error = 'Could not save Template due to a database error: "'.$this->DB->getError().'"';
      return FALSE;
    }
  }

  /*****
   * Function: delete()
   * Purpose: To delete this template & initiate the deleting of question association
   */
  function delete()
  {
    $Account = Account::getInstance();
    $this->instance_id = $Account->instance_id;

    $query = <<<SQL
DELETE
FROM
      template
WHERE
      id = $this->id AND
      instance_id = $this->instance_id
SQL;
    $result = $this->DB->execute($query,"Deleting template #$this->id");
    if($result)
      if($this->_deleteQuestionAssociation())
	return TRUE;
      else
	return FALSE;
    else
    {
      $this->error = 'Unable to delete template due to a database error: "'.$this->DB->getError().'"';
      return FALSE;
    }
  }
  
  /*****
   * Function: _deleteQuestionAssociation()
   * Purpose: To delete any question association in `question_template`.
   * Note: This is a private function so it can't be called from outside the class.  It's just
   *       a helper function for delete()
   */
  private function _deleteQuestionAssociation()
  {
    $query = <<<SQL
DELETE
FROM
      question_template
WHERE
      template_id = $this->id
SQL;
    $result = $this->DB->execute($query,"Deleting question association with template #$this->id");
    if($result)
      return TRUE;
    else
    {
      $this->error = 'Unable to delete template association due to a database error: "'.$this->DB->getError().'"';
      return FALSE;
    }
  }




  /*****
   * Function: saveQuestion()
   * Purpose: Purpose to save a new/existing question
   * Parameters: [int] $id: the id number of the question
   *             [int](optional)$position: The position in the template, this question will
   *                                       have.
   */
  function saveQuestion($id,$position=0)
  {
    /*** If this is a new question being added */
    if($position == 0)
    {
      /*
       * Don't allow questions to be added twice
       */
      foreach($this->questions as $Question)
      {
	  if($Question->id == $id)
	  {
	    $Question->loadPositions();
	    $found_position = $Question->positions[$this->id];
	    $this->error = "Question could not be added because it already exists in this template (#$found_position)";
	    return FALSE;
	  }
      }

      /* Set the position to the last position */
      $position = count($this->questions) + 1;
      $query = <<<SQL
INSERT
INTO
	question_template
	(question_id,
	 template_id,
	 position)
VALUES
	($id,
	 $this->id,
	 $position)
SQL;

      $result = $this->DB->execute($query,'adding new question');

      if(!$result)
      {
	$this->error = 'Unable to save question due to database error "'.$this->DB->getError().'"';
	return FALSE;
      }
      else
      {
	/* Reload the questions */
	$this->loadQuestions();
	return TRUE;
      }
    }
    /* If this is an existing question */
    else
    {
      $query = <<<SQL
UPDATE
	question_template
SET
	position = $position
WHERE
	question_id = $id AND
	template_id = $this->id
SQL;
      $result = $this->DB->execute($query,'updating existing question');
      if(!$result)
      {
	$this->error = 'Unable to update question due to a database error "'.$this->DB->getError().'"';
	return FALSE;
      }
      else
	return TRUE;
    }
  }

  /*****
   * Function: deleteQuestion()
   * Purpose: To remove a question from this template
   * Parameters: [int]$id: the id number of the question
   * Note: If the question is removed successfully, all questions with a greater position
   *       will be shuffled.
   */
  function deleteQuestion($id)
  {
    $Question = new Question($id);
    $Question->loadPositions();
    $position = $Question->positions[$this->id];   

    $query = <<<SQL
DELETE
FROM
      question_template
WHERE
      question_id = $id AND
      template_id = $this->id
SQL;

    $result = $this->DB->execute($query,'deleting question from template');
    if(!$result)
    {
      $this->error = 'Unable to delete question due to a databaes error "'.$this->DB->getError().'"';
      return FALSE;
    }
    else if($this->DB->affectedRows() > 0)
    {
      /* Shuffle other questions associated with this template */
      $query = <<<SQL
UPDATE
	question_template
SET
	position = position-1
WHERE
	template_id = $this->id AND
	position > $position
SQL;

      $result = $this->DB->execute($query,'re-positioning questions after question deletion');
      if(!$result)
      {
	$this->error = 'Unable to re-position remaining questions due to a database error "'.$this->DB->getError().'"';
	$this->loadQuestions();
	return FALSE;
      }
      else
      {
	$this->loadQuestions();
	return TRUE;
      }
    }
    else
      return TRUE;
  }

  

  /*****
   * Function: copy()
   * Purpose: To create a copy of this template
   */
  function copy()
  {
    $new_id = $this->_createDuplicateTemplate();
    if($new_id === FALSE)
      return FALSE;

    if($this->_assignDuplicateQuestions($new_id))
      return TRUE;
    else
      return FALSE;
  }

  /*****
   * Function: _createDuplicateTemplate()
   * Purpose: A helper function for copy() to create a duplicate of this template
   *          in `template`
   */
  private function _createDuplicateTemplate()
  {
    $Account = Account::getInstance();
    $this->instance_id = $Account->instance_id;

    $name = $this->_getDuplicateName();
   
    $query = <<<SQL
INSERT
INTO
      template
      (instance_id,
       name,
       date_added)
VALUES
      ($this->instance_id,
       '$name',
       UNIX_TIMESTAMP(NOW()))
SQL;
    $result = $this->DB->execute($query,'creating a copy of the template',FALSE);
    if($result)
      return $this->DB->lastInsertID();
    else
    {
      if($this->DB->getErrNum() == 1062)
	$this->error = 'Unable to copy the template because a template named "'.$name.'" already exists.';
      else
	$this->error = 'Unable to create a copy of the template due to a database error: "'.$this->DB->getError().'"';
      return FALSE;
    }
  }

  /*****
   * Function: _getDuplicateName()
   * Purpose: To find a duplicate name for a duplicate template.
   *          It adds $counter to the template name until the concatenation
   *          of the current template name & $counter aren't found in the database
   */
  private function _getDuplicateName()
  {
    $counter = 2;
    while(true)
    {
      $loop_name = $this->DB->escape($this->name." $counter");

      $query = <<<SQL
SELECT
	*
FROM
	template
WHERE
	name = '$loop_name'
SQL;
      $result = $this->DB->execute($query,'determining name for new template');
      if(!$result)
      {
	$this->error = 'Unable to generate duplicate template name due to a database error: "'.$this->DB->getError().'"';
	return FALSE;
	break;
      }
      else if($this->DB->numRows($result) == 0)
      {
	$this->duplicate_name = $loop_name;
	return $loop_name;
	break;
      }
      $counter++;
    }
  }
	  


  /*****
   * Function: _assignDuplicateQuestions()
   * Purpose: To create question associations for the duplicate template, just like
   *          the current template.
   * Parameters: [int]$duplicate_id the id number of the duplicate template
   */
  private function _assignDuplicateQuestions($duplicate_id)
  {
    if(!isset($this->questions))
      $this->loadQuestions();

    $Template = new Template($duplicate_id);

    foreach($this->questions as $Question)
    {
      /*
       * Note: Not adding the set position.  When adding a question, if no position is set,
       * the question is just added in the next position.  Since $this->questions is already
       * sorted in order of position, the questions being added to the new template will
       * be in the same order as the original.
       */
      if(!$Template->saveQuestion($Question->id))
      {
	$this->error = $Template->error;
	return FALSE;
      }
    }
    
    return TRUE;
  }
    

  /** Magic **/
  function __get($name)
  {
    return $this->{$name};
  }
}
?>