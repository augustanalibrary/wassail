<?PHP
$require_right = 'report';
require_once('setup.php');
$Account = Account::getInstance();
$instance_id = $Account->instance_id;

/**********
 * Generate lists for the initial parameter form
 */
$TemplateList = new TemplateList('name','asc');
$TemplateList->setSimple(true);
$template_list = $TemplateList->getList();
array_unshift($template_list,array('name'=>'--All--',
				   'id'=>0));
$CourseList = new CourseList('name','asc');
$course_list = $CourseList->getList();
array_unshift($course_list,array('number'=>'--All--',
				 'id'=>0));
$terms = $QUESTIONNAIRE_TERMS;
$types = $QUESTIONNAIRE_TYPES;

$DB = DBi::getInstance();
$query = "SELECT distinct(school_year) FROM response WHERE instance_id = $instance_id ORDER BY school_year DESC";
$result = $DB->execute($query,'retrieving used school years');
if($DB->numRows($result))
  while($row = $DB->getData($result))
  {
    $year_list[] = $row['school_year'];
  }
else
  $year_list = array();
array_unshift($year_list,'--All--');


/* This line sets $chosen_templates,$chosen_courses,$chosen_terms, $chosen_types, & $chosen_years */
extract(importParameterVariables(1));
extract(importParameterVariables(2));



if(isset($_POST['generate']) || isset($_POST['generate-csv']))
{
  $GainsAnalysis = new GainsAnalysis();
  if(checkParameterData($tpl,1) && checkParameterData($tpl,2))
  {
    $GainsAnalysis->setParameters(1,$chosen_templates1,$chosen_courses1,$chosen_years1,$chosen_terms1,$chosen_types1);
    $GainsAnalysis->setParameters(2,$chosen_templates2,$chosen_courses2,$chosen_years2,$chosen_terms2,$chosen_types2);

    $data = $GainsAnalysis->getData();
    if($data)
      if(isset($_POST['generate-csv']))
      {
	$csv_data = $GainsAnalysis->dataAsCSV($data);
	header('Pragma: public');
	header('Expires: 0');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Cache-Control: private',false);
	header('Content-Type: text/csv');
	header('Content-Disposition: attachment;filename="WASSAIL_GA_'.date('d-m-y').'.csv');
	header('Content-Length: '.strlen($csv_data));
	echo $csv_data;
	exit();
      }
      else
      {
	$tpl->assign('data',$GainsAnalysis->getData());
      }
    else
    {
      $tpl->assign(array('success'=>FALSE,
			 'message'=>$GainsAnalysis->error
			 ));
    }
  }
}


$tpl->assign(array('title'=>'Gains Analysis',
		   'query_count'=>DBi::queryCount(),
		   'template_list'=>$template_list,
		   'course_list'=>$course_list,
		   'terms_list'=>$terms,
		   'types_list'=>$types,
		   'year_list'=>$year_list,
		   'chosen_templates1'=>$chosen_templates1,
		   'chosen_courses1'=>$chosen_courses1,
		   'chosen_terms1'=>$chosen_terms1,
		   'chosen_types1'=>$chosen_types1,
		   'chosen_years1'=>$chosen_years1,
		   'chosen_templates2'=>$chosen_templates2,
		   'chosen_courses2'=>$chosen_courses2,
		   'chosen_terms2'=>$chosen_terms2,
		   'chosen_types2'=>$chosen_types2,
		   'chosen_years2'=>$chosen_years2,
		   'hide_legend'=>TRUE));

$tpl->display('gains_analysis.tpl');





/**********
 * Clean & import initial parameter variables
 * For templates & courses, if the 'Any' option was selected, it'll have
 * an id value of 0.  If it is selected, make it the only 'chosen' option
 */

function importParameterVariables($set)
{
  /**********
   * Import parameters for parameter set 1
   */
  if(isset($_POST["param_template$set"]))
    if(!in_array(0,$_POST["param_template$set"]))
      foreach($_POST["param_template$set"] as $curr_template)
      {
	$chosen_templates[] = (int)$curr_template;
      }
    else
      $chosen_templates[] = 0;
  else
    $chosen_templates = array();

  if(isset($_POST["param_course$set"]))
    if(!in_array(0,$_POST["param_course$set"]))
      foreach($_POST["param_course$set"] as $curr_course)
      {
	$chosen_courses[] = (int)$curr_course;
      }
    else
      $chosen_courses[] = 0;
  else
    $chosen_courses = array();

  if(isset($_POST["param_year$set"]))
    if(!in_array('--Any--',$_POST["param_year$set"]))
    {
      foreach($_POST["param_year$set"] as $curr_year)
      {
	$chosen_years[] = $curr_year;
      }
    }
    else
      $chosen_years[] = '--Any--';
  else
    $chosen_years = array();

  if(isset($_POST["param_term$set"]))
    foreach($_POST["param_term$set"] as $curr_term)
    {
      $chosen_terms[] = (int)$curr_term;
    }
  else
    $chosen_terms = array();

  if(isset($_POST["param_type$set"]))
    foreach($_POST["param_type$set"] as $curr_type)
    {
      $chosen_types[] = (int)$curr_type;
    }
  else
    $chosen_types = array();

  return array("chosen_templates$set"=>$chosen_templates,
	       "chosen_courses$set"=>$chosen_courses,
	       "chosen_terms$set"=>$chosen_terms,
	       "chosen_types$set"=>$chosen_types,
	       "chosen_years$set"=>$chosen_years);
}


function checkParameterData(&$tpl,$set)
{
  if(!isset($_POST["param_template$set"]) || count($_POST["param_template$set"]) == 0)
  {
    $tpl->assign(array('success'=>FALSE,
		       'message'=>"At least one Template or '--Any--' must be selected in Parameter set $set"));
    return FALSE;
  }
  else if(!isset($_POST["param_course$set"]) || count($_POST["param_course$set"]) == 0)
  {
    $tpl->assign(array('success'=>FALSE,
		       'message'=>"At least one Course or '--Any--' must be selected in Parameter set $set"));
    return FALSE;
  }
  else if(!isset($_POST["param_year$set"]) || count($_POST["param_year$set"]) == 0)
  {
    $tpl->assign(array('success'=>FALSE,
		       'message'=>"At least one Year or '--Any--' must be selected in Parameter set $set"));
    return FALSE;
  }
  else if(!isset($_POST["param_term$set"]) || count($_POST["param_term$set"]) == 0)
  {
    $tpl->assign(array('success'=>FALSE,
		       'message'=>"At least one Term must be checked in Parameter set $set"));
    return FALSE;
  }
  else if(!isset($_POST["param_type$set"]) || count($_POST["param_type$set"]) == 0)
  {
    $tpl->assign(array('success'=>FALSE,
		       'message'=>"At least one Type must be checked in Parameter set $set"));
    return FALSE;
  }
  else
    return TRUE;
}