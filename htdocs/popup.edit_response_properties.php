<?PHP
$require_right = 'write_unconditional';
require('setup.php');

$DB = DBi::getInstance();
$tpl->assign('success',FALSE);
if(isset($_POST['submit'])){
	$new_template_id = $DB->escape($_POST['template_id']);
	$new_course_id   = $DB->escape($_POST['course_id']);
	$new_term_id     = $DB->escape($_POST['term_id']);
	$new_type_id     = $DB->escape($_POST['type_id']);
	$new_year        = $DB->escape($_POST['year']);
	
	$response_ids    = array();
	foreach($_GET['id'] as $response_id){
		$response_id = (int)$response_id;
		$response_ids[] = $response_id;
	}
	$response_ids = implode(',',$response_ids);

	$query = <<<SQL
		UPDATE
			`response`
		SET
			`template_id` = '$new_template_id',
			`course_id` = '$new_course_id',
			`term` = '$new_term_id',
			`questionnaire_type` = '$new_type_id',
			`school_year` = '$new_year'
		WHERE
			`response_id` IN ($response_ids)
SQL;

	if($DB->execute($query,'updating response properties'))
		$tpl->assign('success',TRUE);
}

$Response = new Response($_GET['id'][0]);
$Template = new Template($Response->template_id);
$Course   = new Course($Response->course_id);
$AllTemplates = new TemplateList('id','desc',TRUE);
$AllCourses = new CourseList();

/* Get the earliest year in the DB */
$query = 'SELECT min(`school_year`) as "min" FROM `response`';
$result = $DB->execute($query,'finding earliest year');
$row = $DB->getData($result);
list($earliest,) = explode('-',$row['min']);

/* Ideally, this array would be generated in the template.  Template Lite has a bug though when it comes
 * to decrimenting values in for loops, so PHP must generate the years */
$years = array();
for($curr_year = date('Y');$curr_year >= $earliest;$curr_year--)
{
  $next_year = $curr_year + 1;
  $years[] = $curr_year.'-'.$next_year;
}

$tpl->assign(array(
	'template_name' => $Template->name,
	'template_id'	=> $Template->id,
	'title'         => 'Editing response properties',
	'course_name'   => $Course->name,
	'course_id'		=> $Course->id,
	'term'          => $QUESTIONNAIRE_TERMS[$Response->term],
	'term_id'		=> $Response->term,
	'type'          => $QUESTIONNAIRE_TYPES[$Response->type],
	'type_id'		=> $Response->type,
	'year'          => $Response->year,
	'hide_iconbar'  => TRUE,
	'id_count'      => count($_GET['id']),
	'years'			=> $years,
	'all_templates' => $AllTemplates->getList(),
	'all_courses'   => $AllCourses->getList(),
	'all_terms'		=> $QUESTIONNAIRE_TERMS,
	'all_types'		=> $QUESTIONNAIRE_TYPES,
	)
);

$tpl->display('popup.edit_response_properties.tpl');