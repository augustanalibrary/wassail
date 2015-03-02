<?PHP

class Course
{
  private $id;
  private $number;
  private $name;
  private $instructor;
  private $date_added;
  private $instance_id;
  private $asked;
  public $errors;
  private $DB;


  /*****
   * Function: __construct()
   * Purpose: instantiate the object
   * Parameters: [int](optional)$id.  If set, the respective course will be loaded
   */
  function __construct($id=FALSE)
  {
    $this->DB = DBi::getInstance();

    if($id !== FALSE)
    {
      $this->id = $id;
      $this->load();
    }
  }

  /*****
   * Function: load()
   * Purpose: To load the course identified by $this->id.
   *          Usually this function doesn't need to be called directly, as the id should
   *          be passed to the constructor if it's known (& the constructor calls load())
   */
  function load()
  {
    $query = <<<SQL
SELECT
      *
FROM
      course
WHERE
      id = $this->id
SQL;
    $result = $this->DB->execute($query,'retrieving Course info');
    $row = $this->DB->getData($result);
    if($this->DB->numRows($result))
    {
      if($_SESSION['instance_id'] == $row['instance_id'])
      {
	$this->number = $row['number'];
	$this->name = $row['name'];
	$this->instructor = $row['instructor'];
	$this->date_added = $row['date_added'];
	$this->instance_id = $row['instance_id'];
	$this->asked = ($row['asked'] == 1) ? TRUE : FALSE;
      }
    }
    /* If the passed course ID was not found, reset to FALSE */
    else
      $this->id = FALSE;
  }

  /*****
   * Function: setName()
   * Purpose: set the name of this course
   * Parameters: [string]$name: the name of the course
   * Note: This function expects to be sent raw POST values, so it un-escapes any escaped quotes.
   */
  function setName($name)
  {
    $this->name = cleanGPC($name);
  }

  /*****
   * Function: setNumber()
   * Purpose: To set the course number.  Note that the course number is a string, not a number
   * Parameters: [string]$number: the course number (such as PSY 201)
   * Note: This function expects to be sent raw POST values, so it un-escapes any escaped quotes.
   */
  function setNumber($number)
  {
    $this->number = cleanGPC($number);
  }


  /*****
   * Function: setInstructor()
   * Purpose: To set the instructor of this course
   * Parameters: (string)$instructor: The instructor
   * Note: This function expects to be sent raw POST values, so it un-escapes any escaped quotes.
   */
  function setInstructor($instructor)
  {
    $this->instructor = cleanGPC($instructor);
  }

  
  /*****
   * Function: setInstructor()
   * Purpose: To set the 'asked' flag
   * Parameters: (boolean)$asked
   */
  function setAsked($asked)
  {
    $this->asked = ($asked) ? TRUE : FALSE;
  }


  /*****
   * Function: save()
   * Purpose: To create a new course or update the existing course
   * Note: whether this function creates a new course or updates an existing course depends on whether
   *       or not $this->id is set.
   */
  function save()
  {
    /* Import & escape data */
    $name = $this->DB->escape($this->name);
    $number = $this->DB->escape($this->number);
    $instructor = $this->DB->escape($this->instructor);
    $instance_id = $_SESSION['instance_id'];
    $asked = ($this->asked === TRUE) ? 1 : 0;
   
    /* Error check data */
    if(!strlen($name) || !strlen($number))
      $this->errors['other'] = 'Course name &amp; Course number must be entered.';
    else if(!strlen($instance_id))
      $this->errors['other'] = 'Could not determine instance id';

    if(count($this->errors) > 0)
      return FALSE;

    /* Build query for editing an existing course */
    if(isset($this->id))
    {
      $query = <<<SQL
UPDATE
	course
SET
	number = '$number',
	name = '$name',
	instructor = '$instructor',
	asked = '$asked'
WHERE
	id = $this->id AND
	instance_id = $instance_id
SQL;
    }
    /* Or build the query for creating a new course */
    else
    {
      $query = <<<SQL
INSERT
INTO
      course
      (instance_id,
       number,
       name,
       instructor,
       date_added)
VALUES
      ('$instance_id',
       '$number',
       '$name',
       '$instructor',
       UNIX_TIMESTAMP(NOW()))
SQL;
    }

    $result = $this->DB->execute($query,'adding new course');
    if(!$result)
    {
      $this->errors['other'] = 'Could not add/create Course.  Database error: "'.$this->DB->getError().'"';
      return FALSE;
    }

    /* Set some properties if making a new Course */
    if(!isset($this->id))
    {
      $this->id = $this->DB->lastInsertID();
      $this->asked = FALSE;
    }
    return TRUE;
  }


  /*****
   * Function: delete()
   * Purpose: To delete this course
   * Note: This class uses (array)$this->errors as opposed to (string)$this->error like other classes
   *       This is likely because I wrote this class early before I decided on an error handling standard.  It works
   *       though, so I'm not changing it now.
   */
  function delete()
  {
    if($this->asked)
      $this->errors['other'] = 'Course cannot be deleted because it has had questionnaires asked';
    if(!$this->instance_id)
      $this->errors['other'] = 'Course cannot be deleted because an instance id could not be found';
    if(!$this->id)
      $this->errors['other'] = "Course cannot be deleted because it could not be found.  Likely it's already been deleted.";

    if(count($this->errors))
      return FALSE;

    $query = <<<SQL
DELETE
FROM
      course
WHERE
      id = $this->id AND
      instance_id = $this->instance_id
SQL;
    $result = $this->DB->execute($query,'deleting a course');
    if(!$result)
    {
      $this->errors['other'] = 'Course could not be deleted due to a database error: '.$this->DB->getError();
      return FALSE;
    }

    return TRUE;
  }

  function __get($name)
  {
    return $this->{$name};
  }
}

?>