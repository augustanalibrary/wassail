<?PHP

  /*************
   * This class was created as a DB abstraction class.
   * This is a successor to the db class which doesn't store database credentials
   * and uses PHP5 constructs as much as possible, 
   * Dylan Anderson
   * September 27, 2007
   *
   * The getInstance() method should be used to invoke this class, with the
   * $DB = DBi::getInstance() method, rather than simply creating a new object.
   * This will result in only one "Singleton" instance of this object (& therefore only
   * one DB connection) per pageload.
   * Dylan Anderson
   * November 2, 2007
   */

class DBi
{
  protected $mysqli = FALSE;
  public $result = FALSE;
  protected $error = FALSE;
  protected $errnum = FALSE;
  public $query_count = 0;

  /*****
   * Return the already existing DB object if it exists,
   * create if it doesn't
   */
  public static function getInstance()
  {
    static $instance;
    if(!isset($instance))
    {
      $c = __CLASS__;
      $instance = new $c;
    }
    return $instance;
  }

  /*****
   * Function: __construct()
   * Purpose: A magical constructor function that instantiates this object
   * Note: The db connection parameters are stored here rather than include/config.inc
   *       to make sure they stay out of any other namespace
   */
  function __construct()
  {
    include INSTALL_DIR.'include/config.db.php';

    $this->mysqli = new mysqli($host,$username,$password,$db);
    if(!$this->mysqli)
    {
      $this->error = "Could not connect to database '$db' on host '$host'";
      $this->errnum = -1;
    }
  }





  /******
   * Function: execute()
   * Purpose: To run a query
   * Parameters: $query: the query to run
   *             $purpose: A short explanation of what the query is supposed to do (used for error reporting)
   *             $output_error: If TRUE, a nicely formatted error message will be dumped to the
   *                            screen if there's an error (malformed query, etc)
   */
  function execute($query,$purpose,$output_error = TRUE)
  {
    $result = $this->mysqli->query($query);
    if(!$result)
    {
      $this->error = $this->mysqli->error;
      $this->errnum = $this->mysqli->errno;
    }

    if($this->errnum != 0)
    {
      if($output_error)
	$this->_outputError($query,$purpose);
      return FALSE;
    }
    else
    {
      $this->query_count++;
      return $result;
    }
  }




  /*****
   * Function: getData()
   * Purpose: To retrieve one row from the passed data set
   */
  function getData($result = FALSE)
  {
    if(!is_object($result))
    {
      $this->_outputError('N/A','trying to retrieve data from resultset');
      return FALSE;
    }
    try
    {
      $row = $result->fetch_assoc();
    }
    catch(Exception $e)
    {
      $row = FALSE;
    }

    return $row;
  }





  /*****
   * Function: numRows()
   * Purpose: To return the number of rows in the passed data set
   */
  function numRows($result = FALSE)
  {
    try
    {
      $num_rows = $result->num_rows;
    }
    catch(Exception $e)
    {
      $num_rows = FALSE;
    }

    return $num_rows;
  }




  /*****
   * Function: affectedRows()
   * Purpose: To return the number of rows affected by the last query
   */
  function affectedRows()
  {
    return $this->mysqli->affected_rows;
  }



  /*****
   * Function: lastInsertID()
   * Purpose: To retrieve the last number generated for an AUTO_INCREMENT row 
   *          over this connection
   */
  function lastInsertID()
  {
    return $this->mysqli->insert_id;
  }


  

  /*****
   * Function: getError()
   * Purpose: return the plain text description of the last error (as provided by MySQL)
   */
  function getError()
  {
    return $this->error;
  }


  

  /*****
   * Function: getErrNum()
   * Purpose: return the error number from the last query run through this connection
   */
  function getErrNum()
  {
    return $this->errnum;
  }



  /*****
   * Function: escape()
   * Purpose: To make a string safe for insertion into the DB
   */
  function escape($string)
  {
    return $this->mysqli->real_escape_string($string);
  }

  /*****
   * Function: _outputError()
   * Purpose: To output an error & some contextual information if a
   *          database error was encountered.  Called manually by getData() and execute()
   */
  function _outputError($query,$purpose)
  {
    $backtrace = debug_backtrace();
    array_shift($backtrace);

    foreach($backtrace as $call)
    {
      $backtrace_output[] = $call['file'].'['.$call['line'].']';
    }
    $backtrace = array_reverse($backtrace_output);
    $backtrace = implode(' <strong style = "color:#00F;">&raquo</strong> ',$backtrace);

    echo <<<ERROR
      <span style = 'font-weight:bold;color:#D00;'>Database error while:</span> "$purpose"<br />
    <span style = 'font-weight:bold;color:#D00;'>Error message:</span> $this->error<br />
    <span style = 'font-weight:bold;color:#D00;'>Error number:</span> $this->errnum<br />
<strong>Query:</strong>
<pre>$query</pre>
<strong>Backtrace</strong>: $backtrace<br />
ERROR;
  }


  /*****
   * Function: toArray()
   * Purpose: To convert the passed result set into 
   *          a 2-dimensional array
   */
  function toArray($result=FALSE)
  {
    if(!$result)
      return FALSE;

    //loop through each row
    while($row = $result->fetch_assoc())
    {
      //loop through each element
      while(($element = current($row) !== FALSE))
      {
	$assoc_row[key($row)] = current($row);
	next($row);
      }
      $ret_val[] = $assoc_row;
    }
    return($ret_val);
  }


  /*****
   * Function: queryCount()
   * Purpose: To return the number of queries that have been
   *          executed so far through this connection.
   */
  public static function queryCount()
  {
    $me = DBi::getInstance();
    return $me->query_count;
  }


  /*****
   * Function: clearErrors()
   * Purpose: To clear out any errors generated
   */
  function clearErrors()
  {
    $this->error = FALSE;
    $this->errnum = FALSE;
  }
} // class DBi

?>