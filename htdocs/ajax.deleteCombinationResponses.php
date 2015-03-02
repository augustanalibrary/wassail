<?PHP
/* This file is called by AJAX via clicking on the bin beside they "eye-con" on the responses page.  This file
 * deletes all responses for a specific template/course/term/type/year combination.
 */
$require_right = 'write';
require_once('setup.php');

$Account = Account::getInstance();
$instance_id = $Account->instance_id;
$template_id = $_GET['template_id'];
$course_id = $_GET['course_id'];
$term_id = $_GET['term_id'];
$type_id = $_GET['type_id'];
$year = $_GET['year'];


$DB = DBi::getInstance();


$success = FALSE;


/* Note: we're not using the responseList object here */
$query = <<<SQL
SELECT
 DISTINCT(response_id)
FROM
  response
WHERE
  instance_id = $instance_id AND
  template_id = $template_id AND
  course_id = $course_id AND
  term = $term_id AND
  questionnaire_type = $type_id AND
  school_year = '$year'

SQL;
$result = $DB->execute($query,'finding response id',FALSE);
if(!$result)
{
  $success = 'false';
  $error = $DB->getError();
}
else
{
  if($DB->numRows($result) > 0)
  {
    while($row = $DB->getData($result))
    {
      $Response = new Response($row['response_id']);
      if(!$Response->delete())
      {
	$success = 'false';
	$error = $Response->error;
	break;
      }
      unset($Response);
    }
    if($success != 'false')
      $success = 'true';
  }
  else
  {
    $success = 'false';
    $error = 'No responses were found that matched the template/course/term/type/year properties';
  }
}
			       


if(!$DB->execute($query,'deleting specific combination responses',FALSE))
{
  $success = 'false';
  $error = $DB->getError();
}
else
{
  $success = 'true';
  $error = '';
}

echo '{"success": '.$success.',"error":"'.$error.'"}';
?>