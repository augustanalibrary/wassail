<?PHP
$require_right = array('write');
require_once('setup.php');


/*****
 * Generate data for inclusion in the template
 */

$upload_max_filesize = ini_get('upload_max_filesize').'B';//ini settings don't have the 'B'


$TemplateList = new TemplateList('id','desc',TRUE);
$TemplateList->setSimple(TRUE);
$templates = $TemplateList->getList();

$CourseList = new CourseList('id','desc');
$courses = $CourseList->getList();

$selected_template = (isset($_GET['id'])) ? $_GET['id'] : '';
$selected_template = (isset($_POST['template'])) ? $_POST['template'] : $selected_template;
$selected_course = (isset($_POST['course'])) ? $_POST['course'] : '';
$checked_term = (isset($_POST['term'])) ? $_POST['term'] : '';
$checked_type = (isset($_POST['type'])) ? $_POST['type'] : '';
$name = (isset($_POST['name']) && strlen($_POST['name'])) ? $_POST['name'] : '';
$name = (get_magic_quotes_gpc()) ? stripslashes($name) : $name;
$selected_school_year = (isset($_POST['school_year'])) ? $_POST['school_year'] : FALSE;
// If no school year was selected
if(!$selected_school_year){
  $curr_year = date('Y');

  // if it's after May 1st, default to next academic year
  if(date('nd') >= '501')
   $selected_school_year = $curr_year.'-'.($curr_year + 1);
  else
     $selected_school_year = ($curr_year - 1).'-'.$curr_year;
}

$filled_respondents  = (isset($_POST['respondents'])) ? $_POST['respondents'] : '';
$filled_expiry_date  = (isset($_POST['expiry_date'])) ? $_POST['expiry_date'] : '';
$filled_intro        = (isset($_POST['intro'])) ? $_POST['intro'] : '';
$filled_intro        = (get_magic_quotes_gpc()) ? stripslashes($filled_intro) : $filled_intro;
$filled_file_request = (isset($_POST['file_request'])) ? $_POST['file_request'] : '';
$filled_file_request = (get_magic_quotes_gpc()) ? stripslashes($filled_file_request) : $filled_file_request;
$filled_file_count   = (isset($_POST['file_count'])) ? $_POST['file_count'] : 1;
$filled_confirmation = (isset($_POST['confirmation'])) ? $_POST['confirmation'] : NULL;
$filled_email        = (isset($_POST['email'])) ? $_POST['email'] : '';
$filled_email        = (get_magic_quotes_gpc()) ? stripslashes($filled_email) : $filled_email;
$checked_public      = (isset($_POST['public'])) ? TRUE : FALSE;

/* Ideally, this array would be generated in the template.  Template Lite has a bug though when it comes
 * to decrimenting values in for loops, so PHP must generate the years */
$years = array();
for($curr_year = date('Y');$curr_year >= date('Y')-2;$curr_year--)
{
  $next_year = $curr_year + 1;
  $years[] = $curr_year.'-'.$next_year;
}

$tpl->assign(array('title'=>'Create web questionnaire',
		   'templates'=>$templates,
		   'selected_template'=>$selected_template,
		   'load_calendar'=>TRUE,
		   'hide_legend'=>TRUE,
		   'courses'=>$courses,
		   'selected_course'=>$selected_course,
		   'terms'=>$QUESTIONNAIRE_TERMS,
		   'checked_term'=>$checked_term,
		   'types'=>$QUESTIONNAIRE_TYPES,
		   'name'=>$name,
		   'checked_type'=>$checked_type,
		   'selected_school_year'=>$selected_school_year,
		   'years'=>$years,
		   'respondents'=>$filled_respondents,
		   'expiry_date'=>$filled_expiry_date,
		   'public'=>$checked_public,
		   'intro'=>$filled_intro,
		   'file_request'=>$filled_file_request,
       'file_count'=>$filled_file_count,
       'confirmation'=>$filled_confirmation,
		   'show_print_icon'=>TRUE,
       'upload_max_filesize'=>$upload_max_filesize,
		   'email'=>$filled_email));

/*****
 * Handle form submission
 */
if(isset($_POST['generate']))
{
  /* check respondents field */
  if(!preg_match('/\d+/',$_POST['respondents']))
  {
    $tpl->assign(array('success'=>FALSE,
		       'message'=>'# of respondents must be entered and must be larger than zero.'));
    $tpl->display('popup.add_web_form.tpl');
  }
  else if($_POST['respondents'] == 0)
  {
    $tpl->assign(array('success'=>FALSE,
		       'message'=>'# of respondents must be larger than zero.'));
    $tpl->display('popup.add_web_form.tpl');
  }

  /* check expiry date field */
  else if(!preg_match(':^\d{2}/\d{2}/\d{4}$:',$_POST['expiry_date']))
  {
    $tpl->assign(array('success'=>FALSE,
		       'message'=>'Expiry date must be entered'));
    $tpl->display('popup.add_web_form.tpl');
  }
  
  /* otherwise everything should be fine */
  else
  {
    list($expiry_day,$expiry_month,$expiry_year) = explode('/',$_POST['expiry_date']);
    $expiry_date = mktime(23,59,59,$expiry_month,$expiry_day,$expiry_year);

    $WebForm = new WebForm();


    if($WebForm->create($selected_template,$selected_course,$selected_school_year,$checked_term,$checked_type,$name,$_POST['respondents'],$expiry_date,$checked_public,$filled_confirmation,$filled_intro,$filled_file_request,$filled_file_count,$filled_email))
    {
		$https_on = (isset($_SERVER['HTTPS'])) ? TRUE : FALSE;
      $tpl->assign(array('respondent_accounts'=>$WebForm->respondent_accounts,
			 'public'=>$checked_public,
			 'form_id'=>$WebForm->id,
			 'form_name'=>$WebForm->name,
			 'https_on'=>$https_on));
      $tpl->display('popup.add_web_form.accounts.tpl');
    }
    else
    {
      $tpl->assign(array('success'=>FALSE,
			 'message'=>$WebForm->error));
      $tpl->display('popup.add_web_form.tpl');
    }
  }
 }
else
  $tpl->display('popup.add_web_form.tpl');

?>