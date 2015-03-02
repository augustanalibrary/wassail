<?PHP
class TemplateList
{
  private $simple;
  private $order_column;
  private $order_dir;
  private $list;

  /*****
   * Function: __construct
   * Parameters: All optional.  $order_column & $order_dir should be self-explanatory
   *             if $simple is set TRUE, then the questions for the templates aren't loaded.
   */
  function __construct($order_column='id',$order_dir='desc',$simple=FALSE)
  {
    $this->setOrderColumn($order_column);
    $this->setOrderDirection($order_dir);
    $this->setSimple($simple);
  }


  /*****
   * Function: setOrdeDirection()
   * Purpose: To set the order direction
   * Note: defaults to 'asc' unless $dir is 'desc'
   */
  function setOrderDirection($dir)
  {
    $this->order_dir = ($dir == 'desc') ? 'desc' : 'asc';
  }

  /*****
   * Function: setOrderColumn
   * Purpose: To set the column to order by
   * Note: defaults to 'id', also allows 'name' and 'date_added'
   */
  function setOrderColumn($column)
  {
    switch($column)
    {
      case 'name':
	$this->order_column = 'name';
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
   * Function: setSimple()
   * Purpose: to set whether this list is simple or not
   *          If it's simple, the questions aren't loaded.  This
   *          is useful if you just want a list of templates & their
   *          properties.
   */
  function setSimple($simple)
  {
    $this->simple = ($simple) ? TRUE : FALSE;
  }

  /*****
   * Function: getList()
   * Purpose: To return the current list.  Will generate it if it doesn't exist
   */
  function getList()
  {
    if(!$this->list)
      $this->buildList();

    return $this->list;
  }
  
  
  /*****
   * Function: buildList()
   * Purpose: To generate the list of templates
   */
  function buildList()
  {
    $Account = Account::getInstance();
    $instance_id = $Account->instance_id;

    $DB = DBi::getInstance();

    $query = <<<SQL
SELECT
      *
FROM
      template
WHERE
      instance_id = '$instance_id'
ORDER BY
      $this->order_column $this->order_dir
SQL;
    $result = $DB->execute($query,'retrieving all templates');

    if(!$result)
      $this->list = FALSE;
    else if(!$DB->numRows($result))
    {
      $this->list = array();
      return TRUE;
    }
    /* Load the questions for this template if it's not simple */
    else if(!$this->simple)
    {
      $this->list = $DB->toArray($result);
      foreach($this->list as $index=>$template)
      {
	$query = <<<SQL
SELECT
	  text
FROM
	  question,
	  question_template
WHERE
	  question.id = question_template.question_id AND
	  template_id = $template[id]
ORDER BY
	  question_template.position
SQL;
	$result = $DB->execute($query,"retrieving all question text for template $template[id]");
	if($result)
	{
	  if($DB->numRows($result))
	    while($row = $DB->getData($result))
	      $this->list[$index]['questions'][] = $row['text'];
	}
	else
	{
	  $this->error = 'Unable to retrieve template questions due to a database error "'.$DB->getError().'"';
	  return FALSE;
	}
      }
      return TRUE; 
    }
    else
    {
      $this->list = $DB->toArray($result);
      return TRUE;
    }
  }
}
?>