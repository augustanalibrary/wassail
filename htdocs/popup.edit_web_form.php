<?PHP
$require_right = array('write');
require_once('setup.php');
require_once('include/classes/webform.php');


/*****
 * Generate data for inclusion in the template
 */
$upload_max_filesize = ini_get('upload_max_filesize').'B';//ini settings don't have the 'B'

$TemplateList = new TemplateList('id','desc',TRUE);
$TemplateList->setSimple(TRUE);
$templates = $TemplateList->getList();

$CourseList = new CourseList('id','desc');
$courses = $CourseList->getList();

/* Ideally, this array would be generated in the template.  Template Lite has a bug though when it comes
 * to decrimenting values in for loops, so PHP must generate the years */
$years = array();
for($curr_year = date('Y');$curr_year >= date('Y')-2;$curr_year--)
{
  $next_year = $curr_year + 1;
  $years[] = $curr_year.'-'.$next_year;
}

$WebForm = new WebForm($_GET['id']);
$selected_template = $WebForm->template_id;
$selected_course = $WebForm->course_id;
$checked_term = $WebForm->term;
$checked_type = $WebForm->type;
$name = $WebForm->name;
$selected_school_year = $WebForm->school_year;
$filled_expiry_date = date('d/m/Y',$WebForm->expiry_date);
$filled_intro = $WebForm->intro;
$filled_file_request = $WebForm->file_request;
$filled_file_count = $WebForm->file_count;
$filled_confirmation = $WebForm->confirmation;
$filled_email = $WebForm->email;
$checked_public = $WebForm->public;
$filled_respondents = 0;
if($WebForm->error)
{
	$tpl->assign('error',$WebForm->error);
}


if(isset($_POST['save']))
{
	$selected_template = (isset($_GET['id'])) ? $_GET['id'] : '';
	$selected_template = (isset($_POST['template'])) ? $_POST['template'] : $selected_template;
	$selected_course = (isset($_POST['course'])) ? $_POST['course'] : '';
	$checked_term = (isset($_POST['term'])) ? $_POST['term'] : '';
	$checked_type = (isset($_POST['type'])) ? $_POST['type'] : '';
	$selected_school_year = (isset($_POST['school_year'])) ? $_POST['school_year'] : '';
	$filled_respondents = (isset($_POST['respondents'])) ? $_POST['respondents'] : '';
	$filled_expiry_date = (isset($_POST['expiry_date'])) ? $_POST['expiry_date'] : '';
	$filled_file_request = (strlen($_POST['file_request'])) ? $_POST['file_request'] : '';
	$filled_file_count = $_POST['file_count'];
	$filled_confirmation = $_POST['confirmation'];
	$filled_email = (strlen($_POST['email'])) ? $_POST['email'] : '';
	$filled_intro = (isset($_POST['intro'])) ? $_POST['intro'] : '';
	$filled_intro = (get_magic_quotes_gpc()) ? stripslashes($filled_intro) : $filled_intro;

	list($expiry_day,$expiry_month,$expiry_year) = explode('/',$_POST['expiry_date']);
    $expiry_date			= mktime(23,59,59,$expiry_month,$expiry_day,$expiry_year);

	/* check expiry date field */
  	if(!preg_match(':^\d{2}/\d{2}/\d{4}$:',$_POST['expiry_date']))
  	{
    	$tpl->assign(array('success'=>FALSE,
			       'message'=>'Expiry date must be entered'));
	}
	else if($WebForm->update($selected_template, $selected_course, $selected_school_year, $checked_term, $checked_type, $expiry_date, $filled_confirmation, $filled_intro, $filled_respondents,$filled_file_request,$filled_file_count,$filled_email))
	{		
		if($filled_respondents != 0 && $filled_respondents != '')
		{
			$https_on = (isset($_SERVER['HTTPS'])) ? TRUE : FALSE;
			
			
			$tpl->assign(array(
			 'respondent_accounts'=>$WebForm->respondent_accounts,
			 'public'=>$checked_public,
			 'form_id'=>$WebForm->id,
			 'form_name'=>$WebForm->name,
			 'https_on'=>$https_on));
			$tpl->display('popup.add_web_form.accounts.tpl');
			exit();
		}
		else
			$tpl->assign(array('success'=>TRUE,
							   'message'=>'Online questionnaire updated'));
	}
	else
		$tpl->assign('error',$WebForm->error);
}

$tpl->assign(array('title'=>'Edit web questionnaire',
		   'id'					=> cleanGPC($_GET['id']),
		   'templates'			=> $templates,
		   'selected_template'	=> $selected_template,
		   'load_calendar'		=> TRUE,
		   'hide_legend'		=> TRUE,
		   'courses'			=> $courses,
		   'selected_course'	=> $selected_course,
		   'terms'				=> $QUESTIONNAIRE_TERMS,
		   'checked_term'		=> $checked_term,
		   'types'				=> $QUESTIONNAIRE_TYPES,
		   'name'				=> $name,
		   'checked_type'		=> $checked_type,
		   'selected_school_year'=> $selected_school_year,
		   'years'				=> $years,
		   'respondents'		=> $filled_respondents,
		   'expiry_date'		=> $filled_expiry_date,
		   'intro'				=> $filled_intro,
		   'file_request'		=> $filled_file_request,
		   'file_count'			=> $filled_file_count,
		   'email'				=> $filled_email,
		   'show_print_icon'	=> TRUE,
		   'upload_max_filesize'=> $upload_max_filesize,
		   'editing'			=> TRUE));
$tpl->display('popup.add_web_form.tpl');
?>