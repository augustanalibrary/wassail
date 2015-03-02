<?PHP
class ResponseList
{
  private $template_id,$course_id,$term,$type,$year,$DB,$instance_id;

  function __construct()
  {
    $this->DB = DBi::getInstance();
    $Account = Account::getInstance();
    $this->instance_id = $Account->instance_id;
  }

  function __set($name,$value)
  {
    if($name != 'DB' && $name != 'responses')
    {
      $this->{$name} = $value;
    }
  }

  function loadTemplates($order_column='id',$order_dir='desc')
  {
    /* Sanitize input */
    switch($order_column)
    {
      case 'id':
      case 'name':
      case 'date_added':
	break;
      default:
	$order_column = 'id';
    }
    $order_dir = ($order_dir == 'desc') ? 'desc' : 'asc';
    
    $query = <<<SQL
SELECT
      distinct(template_id) as template_id,
      template.*
FROM
      response,
      template
WHERE
      template.id = response.template_id AND
      response.instance_id = $this->instance_id
ORDER BY
      $order_column $order_dir
SQL;

    $result = $this->DB->execute($query,'retrieving distinct, responded template ids');
    if($result && $this->DB->numRows($result))
      while($row = $this->DB->getData($result))
      {
	$templates[$row['template_id']] = array('id'=>$row['id'],
						'name'=>$row['name'],
						'date_added'=>$row['date_added']);
      }
    else
      $templates = FALSE;
    
    return($templates);
  }

  function loadEntriesForTemplate($template_id)
  {
    $query = <<<SQL
SELECT
      template_id,
      course.id as 'course_id',
      course.number as 'course_number',
      course.name as 'course_name',
      term,
      questionnaire_type,
      school_year,
      response.number,
      response.response_id      
FROM
      response,
      course
WHERE
      course.id = response.course_id AND
      response.instance_id = $this->instance_id AND
      template_id = $template_id
ORDER BY
      course.name asc,
      response.number desc
SQL;

    $result = $this->DB->execute($query,'retrieving all responses for template');
    if($this->DB->numRows($result))
    {
      global $QUESTIONNAIRE_TERMS,$QUESTIONNAIRE_TYPES;

      while($row = $this->DB->getData($result))
      {
	$term = $QUESTIONNAIRE_TERMS[$row['term']];
	$questionnaire_type = $QUESTIONNAIRE_TYPES[$row['questionnaire_type']];
	/* Might look funky indexing the array like this, but its only temporary & is the only way to build up
	 * the ids & numbers sub-arrays w/o making duplicate arrays for other properties
	 */

	$key = implode('-:-',array($row['template_id'],
				   $row['course_id'],
				   $row['course_number'],
				   $row['course_name'],
				   $term,
				   $row['term'],
				   $questionnaire_type,
				   $row['questionnaire_type'],
				   $row['school_year']));

	$keyed_entries[$key][$row['number']] = $row['response_id'];
      }
      
      foreach($keyed_entries as $key=>$properties)
      {
	list($template_id,
	     $course_id,
	     $course_number,
	     $course_name,
	     $term,
	     $term_id,
	     $questionnaire_type,
	     $questionnaire_type_id,
	     $school_year) = explode('-:-',$key);
	$entries[] = array('template_id'=>$template_id,
			   'course_id'=>$course_id,
			   'course_number'=>$course_number,
			   'course_name'=>$course_name,
			   'term'=>$term,
			   'term_id'=>$term_id,
			   'questionnaire_type'=>$questionnaire_type,
			   'questionnaire_type_id'=>$questionnaire_type_id,
			   'school_year'=>$school_year,
			   'individual'=>$properties);
      }
    }
    else
      $entries = FALSE;

    return($entries);
  }
}
?>      

