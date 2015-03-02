<?PHP

class CourseList
{
  private $DB;
  private $order_column;
  private $order_dir;
  private $list = FALSE;

  function __construct($order_column = 'id',$order_dir = 'desc')
  {
    $this->DB = DBi::getInstance();
    $this->setOrderColumn($order_column);
    $this->setDirection($order_dir);
  }

  /*****
   * Function: setDirection()
   * Purpose: Set the direction to sort the list by
   * Note: Defaults to 'desc', unless $dir is 'asc'
   */
  function setDirection($dir = 'asc')
  {
    $this->order_dir = ($dir == 'asc') ? 'asc' : 'desc';
  }

  /*****
   * Function: setOrderColumn()
   * Purpose: Set the column to order by
   * Note: defaults to 'id', also allows 'number','name','instructor','date_added'
   */
  function setOrderColumn($column = 'id')
  {
    switch($column)
    {
      case 'number':
	$this->order_column = 'number';
	break;
    case 'name':
      $this->order_column = 'name';
      break;
    case 'instructor':
      $this->order_column = 'instructor';
      break;
    case 'date':
      $this->order_column = 'date_added';
      break;
    default:
      $this->order_column = 'id';
      break;
    }
  }

  /*****
   * Function: getList()
   * Purpose: To return the list of courses
   * Note: builds the list if it's not set
   */
  function getList()
  {
    if(!$this->list)
      $this->buildList();

    return $this->list;
  }

  /*****
   * Function: buildList()
   * Purpose: To actually make the list
   * Note: Doesn't return the list.  If you want the list, call getList()
   */
  function buildList()
  {
    $query = <<<SQL
SELECT
      id,
      number,
      name,
      instructor,
      date_added,
      asked
FROM
      course
WHERE
      instance_id = '$_SESSION[instance_id]'
ORDER BY
      $this->order_column $this->order_dir
SQL;

    $result = $this->DB->execute($query,'retrieving course list');
    if(!$result)
      $this->list = FALSE;
    else if($this->DB->numRows($result))
      $this->list = $this->DB->toArray($result);
    else
      $this->list = array();
  }
}

?>