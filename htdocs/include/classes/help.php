<?PHP

  /*****
   * Class: Help
   * Purpose: To mastermind the retrieval & saving of help pages
   */
class Help
{
  private $DB;
  private $from;
  private $error = FALSE;

  function __construct($from)
  {
    $this->DB = DBi::getInstance();
    $this->from = $this->DB->escape($from);

  }


  /*****
   * Function: __get()
   * Purpose: Handle the retrieval of object variables.  Only allows $error
   *          and $content to be retrieved.
   */
  function __get($name)
  {
    if($name == 'content')
    {
      $query = <<<SQL
SELECT
	*
FROM
	help
WHERE
	page = '$this->from'
SQL;
      $result = $this->DB->execute($query,'retrieving help');
      if(!$result)
      {
	$this->error = 'Unable to retrieve help due to a database error: "'.$this->DB->getError().'"';
	return FALSE;
      }
      else if($this->DB->numRows($result) == 0)
	return '';
      else
      {
	$row = $this->DB->getData($result);
	return $row['content'];
      }
    }
    else if($name == 'error')
      return $this->error;
    else
      return FALSE;
  }

  /*****
   * Function: __set()
   * Purpose: To set object variables.  Only allows $content (which isn't an actual
   *          object variable - that's why they call it a "magic" function), to be set.
   */
  function __set($name,$value)
  {
    if($name == 'content')
    {
      $value = $this->DB->escape($value);
      $query = <<<SQL
REPLACE
INTO
	help
	(page,
	 content)
VALUES
	('$this->from',
	 '$value')
SQL;

      $result = $this->DB->execute($query,'setting help contents');
      if(!$result)
      {
	$this->error = 'Unable to set help contents due to a database error: "'.$this->DB->getError().'"';
	return FALSE;
      }
      else if($this->DB->affectedRows() > 0)
	return TRUE;
      else
	return FALSE;
    }
    else
      return TRUE;
  }
}

?>





