<?PHP

  /**********
   * Class: Answer
   *
   */

class Answer
{
  private $id;
  private $instance_id;
  private $question_id;
  private $text;
  private $position;
  private $asked;
  public $correct;
  private $date_added;
  private $error;
  private $DB;


  /*****
   * Function: __construct
   * Purpose: To instantiate the object.  If an ID is passed,
   *          it will load the data for that answer
   */
  function __construct($id=FALSE)
  {
    $this->instance_id = $_SESSION['instance_id'];
    $this->DB = DBi::getInstance();

    if($id !== FALSE)
    {
      $this->id = $id;
      $this->load();
    }
  }

  /*****
   * Function: load()
   * Purpose: To load the data for a particular id
   */
  function load()
  {
    $query = <<<SQL
SELECT
      *
FROM
      answer
WHERE
      id = $this->id AND
      instance_id = $this->instance_id
SQL;
    $result = $this->DB->execute($query,'retrieving answer');
    if(!$result || $this->DB->numRows($result) == 0)
    {
      $this->id = FALSE;
      return;
    }
    else
    {
      $row = $this->DB->getData($result);
      $this->question_id = $row['question_id'];
      $this->text = $row['text'];
      $this->position = $row['position'];
      $this->date_added = $row['date_added'];
      $this->asked = $row['asked'];
      $this->correct = $row['correct'];
    }
  }

  /*****
   * Function: setQuestionID()
   * Purpose: To set the question id this answer is associated with.
   * Parameters: (int)$id: The id of the question. Note that this function expects to be sent
   *                       raw POST data, so it un-escapes any escaped quotes.
   */
  function setQuestionID($id)
  {
    $this->question_id = (int)cleanGPC($id);
  }

  /*****
   * Function: setText()
   * Purpose: To set the text of this answer.
   * Parameters: (string)$text: The text for this quesion.  Note that this function expects to be
   *                            sent raw POST data, so it un-escapes any escaped quotes.
   */
  function setText($text)
  {
    $this->text = cleanGPC($text);
  }

  /*****
   * Function: setPosition()
   * Purpose: To set the position of this answer relative to it's question
   * Parameters: (int)$position: The position of this answer.
   */
  function setPosition($position)
  {
    $this->position = (int)cleanGPC($position);
  }


  /*****
   * Function: setAsked()
   * Purpose: To set this answers 'asked' flag
   * Parameters: (boolean)$asked
   */
  function setAsked($asked)
  {
    $this->asked = ($asked) ? TRUE : FALSE;
  }

  /*****
   * Function: setCorrect()
   * Purpose: To set whether this answer is the correct answer or not
   * Parameters: (boolean)$correct
   */
  function setCorrect($correct)
  {
    $this->correct = ($correct) ? TRUE : FALSE;
  }

  /*****
   * Function: save
   * Purpose: To save the answer.  If $this->id isn't set, this
   *          function assumes a new answer is being saved, otherwise
   *          it overwrites the answer identified by $this->id
   */
  function save()
  {
    /* Ensure this answer can be edited */
    if($this->asked)
    {
      /* verify that this question can be modified */
      $Account = Account::getInstance();
      if(!$Account->right_write_unconditional)
      {
	$this->error = 'You do not have permissions to edit that answer';
	return FALSE;
      }
    }

    $question_id = $this->DB->escape($this->question_id);
    $text = $this->DB->escape($this->text);
    $position = (int)$this->DB->escape($this->position);
    $asked = ($this->asked) ? 1 : 0;
    $correct = ($this->correct) ? 1 : 0;

    if(!strlen($text))
      $this->error = 'Answers must have some text';
    if(!strlen($position))
      $this->error = 'Answers must have a position';

    if(strlen($this->error) > 0)
      return FALSE;


    if(isset($this->id))
    {
      $query = <<<SQL
UPDATE
	answer
SET
	text = '$text',
	position = '$position',
	asked = '$asked',
	correct = '$correct'
WHERE
	id = '$this->id' AND
	instance_id = '$this->instance_id'
SQL;
    }
    else
    {
      $query = <<<SQL
INSERT
INTO
	answer
	(instance_id,
	 question_id,
	 text,
	 position,
	 date_added,
	 correct)
VALUES
	('$this->instance_id',
	 '$question_id',
	 '$text',
	 '$position',
	 UNIX_TIMESTAMP(NOW()),
	 $correct)
SQL;
    }


    $result = $this->DB->execute($query,'updating/adding an answer');
    if(!$result)
    {
      $this->error = 'Answer could not be created/updated due to a database error: "'.$this->DB->getError().'"';
      return FALSE;
    }
    else
    {
      if(!isset($this->id))
	$this->id = $this->DB->lastInsertID();

      return TRUE;
    }
  }

  /*****
   * Function: delete()
   * Purpose: To delete this answer()
   */
  function delete()
  {
    if($this->asked)
    {
      $this->error = 'Answer could not be deleted because it has already been asked';
      return FALSE;
    }

    $query = <<<SQL
DELETE
FROM
      answer
WHERE
      id = '$this->id' AND
      instance_id = '$this->instance_id'
SQL;
    $result = $this->DB->execute($query,'deleting question');
    if(!$result)
    {
      $this->error = 'Answer could not be deleted due to a database error: "'.$this->DB->getError().'"';
      return FALSE;
    }
    else
    {
      $this->id = FALSE;
      return TRUE;
    }
  }
  function __get($name)
  {
    return $this->{$name};
  }
}

?>