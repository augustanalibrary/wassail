<?PHP
$require_right = 'read';
require('setup.php');

/******
 * Generate info for the 'Add new response' form 
 */
$TemplateList = new TemplateList('id','desc',TRUE);
$TemplateList->setSimple(TRUE);
$templates = $TemplateList->getList();

$CourseList = new CourseList('id','desc');
$courses = $CourseList->getList();

$selected_template = (isset($_POST['template'])) ? $_POST['template'] : '';
$selected_course = (isset($_POST['course'])) ? $_POST['course'] : '';
$checked_term = (isset($_POST['term'])) ? $_POST['term'] : '';
$checked_type = (isset($_POST['type'])) ? $_POST['type'] : '';
$selected_school_year = (isset($_POST['school_year'])) ? $_POST['school_year'] : '';

/* Ideally, this array would be generated in the template.  Template Lite has a bug though when it comes
 * to decrimenting values in for loops, so PHP must generate the years */
$years = array();
for($curr_year = date('Y');$curr_year >= date('Y')-10;$curr_year--)
{
  $next_year = $curr_year + 1;
  $years[] = $curr_year.'-'.$next_year;
}


/*****
 * Generate info for the list
 */
$order_column = (isset($_GET['o'])) ? $_GET['o'] : 'id';
$order_dir = (isset($_GET['d'])) ? $_GET['d'] : 'desc';

$ResponseList = new ResponseList();
$responded_templates = $ResponseList->loadTemplates($order_column,$order_dir);


$tpl->assign(array('title'=>'Responses',
		   'query_count'=>DBi::queryCount(),
		   'rightWrite'=>Auth::rightWrite(),
		   'templates'=>$templates,
		   'selected_template'=>$selected_template,
		   'courses'=>$courses,		   
		   'selected_course'=>$selected_course,
		   'terms'=>$QUESTIONNAIRE_TERMS,
		   'checked_term'=>$checked_term,
		   'types'=>$QUESTIONNAIRE_TYPES,
		   'checked_type'=>$checked_type,
		   'years'=>$years,
		   'selected_school_year'=>$selected_school_year,
		   'order_column'=>$order_column,
		   'order_dir'=>$order_dir,
		   'responded_templates'=>$responded_templates,
		   'icons'=>array('add'=>'Add a new response...',
				  'edit'=>'Edit a response',
				  'show'=>'Show all responses',
				  'hide'=>'Hide responses',
				  'sort'=>'Sort by column',
				  'switch'=>'Edit response properties',
				  'import_csv'=>'Import CSV')));
$tpl->display('responses.tpl');

?>