<?PHP
# Copyright 2009, University of Alberta
#
# This file is part of WASSAIL
#
# WASSAIL is free software: you can redistribute it and/or modify it under
# the terms of the GNU General Public License as published by the Free 
# Software Foundation, either version 2 of the License, or (at your option) 
# any later version.

# WASSAIL is distributed in the hope that it will be useful, but WITHOUT ANY 
# WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS 
# FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more 
# details.

# You should have received a copy of the GNU General Public License along 
# with WASSAIL.  If not, see <http://www.gnu.org/licenses/>.

$require_right = 'report';
require_once('setup.php');
$Account = Account::getInstance();
$instance_id = $Account->instance_id;

/**********
 * Generate lists for the initial parameter form
 */
$TemplateList = new TemplateList('id','desc');
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
extract(importParameterVariables());

/**********
 * If either the initial parameter form, or the subsequent question form
 * has been submitted, check the data & act on it
 */
if(isset($_POST['set_parameters']) || isset($_POST['generate']) || isset($_POST['generate-csv']) || isset($_POST['generate-with-qualitative']) || isset($_POST['generate-qualitative']))
{
  $Report = new Report();
  if(checkParameterData($tpl))
  {
    $Report->setParameters($chosen_templates,$chosen_courses,$chosen_years,$chosen_terms,$chosen_types);
    $single_template = (count($chosen_templates) == 1 && $chosen_templates[0] != 0);

    if((isset($_POST['generate']) || isset($_POST['generate-csv'])) && checkReportQuestionSanity($tpl))
    {
      $tpl->assign('single_template',$single_template);

      $data = $Report->getData();

      //if only viewing one template, re-order questions in that template's order
      if($single_template)
        $data = $Report->reorderToTemplate($data,$chosen_templates[0]);


      $required_answers_hr = $Report->hrConditions();

      if($data)
      	if(isset($_POST['generate-csv']))
      	{	
      	  $csv_data = $Report->dataAsCSV($data);
      	  header('Pragma: public');
      	  header('Expires: 0');
      	  header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
      	  header('Cache-Control: private',false);
      	  header('Content-Type: text/csv');
      	  header('Content-Disposition: attachment;filename="WASSAIL_report_'.date('d-m-y').'.csv');
      	  header('Content-Length: '.strlen($csv_data));
      	  echo $csv_data;
      	  exit();
      	}
      	else
      	  $tpl->assign(array('data'=>$data,
      			     'responders'=>$Report->responder_count,
      			     'required'=>$required_answers_hr));
      else
      {
      	$tpl->assign(array('success'=>FALSE,
      			   'message'=>$Report->error));
      }
    }
    else if(isset($_POST['generate-qualitative']))
    {
      $tpl->assign('single_template',$single_template);

      $qualitative_data = $Report->getQualitativeData();
	  
	  	//if only viewing one template, re-order questions in that template's order
	  	if($single_template)
			 $qualitative_data = $Report->reorderToTemplate($qualitative_data,$chosen_templates[0]);
	
      if($qualitative_data)
  	  {
  		  $tpl->assign(array(
  							'qualitative_data'=>$qualitative_data,
  							'required'=>$Report->hrConditions()
  							)
  					);
  	  }
      else
		$tpl->assign(array('success'=>FALSE,
				   'message'=>$Report->error));
    }	
    else if(isset($_POST['generate-with-qualitative']) && checkReportQuestionSanity($tpl))
    {
      $tpl->assign('single_template',$single_template);
      $data = $Report->getData();	  
	  
      $required_answers_hr = $Report->hrConditions();
      if($data)
      {
    		$qualitative_data = $Report->getQualitativeData();
    		$data = $data + $qualitative_data;

    		// if we're only viewing one template, order the questions by how they appear
    		// in that template.
    		if($single_template){
        	$data = $Report->reorderToTemplate($data,$chosen_templates[0]);
        }
    		//otherwise use numeric order
    		else
          ksort($data);

    		$tpl->assign(array('data'=>$data,
    			   'responders'=>$Report->responder_count,
    			   'required'=>$required_answers_hr));
      }
      else
		$tpl->assign(array('success'=>FALSE,
			   'message'=>$Report->error));
    }
    else
    {
      $questions = $Report->getQuestions();
      if($questions)
		$tpl->assign('questions',$questions);
      else
      {
		$tpl->assign(array('success'=>FALSE,
			   'message'=>$Report->error));	
      }

      /* If qualitative data exists for these parameters, inform the template */
      if($Report->getQualitativeData(true))
		    $tpl->assign('qualitative_exists',TRUE);
		
    }
  }
}
$tpl->assign(array('title'=>'Reports',
		   'query_count'=>DBi::queryCount(),
		   'template_list'=>$template_list,
		   'course_list'=>$course_list,
		   'terms_list'=>$terms,
		   'types_list'=>$types,
		   'year_list'=>$year_list,
		   'chosen_templates'=>$chosen_templates,
		   'chosen_courses'=>$chosen_courses,
		   'chosen_terms'=>$chosen_terms,
		   'chosen_types'=>$chosen_types,
		   'chosen_years'=>$chosen_years,
		   'icons'=>array('expand'=>'Expand boxes',
				  'shrink'=>'Shrink boxes')));


$tpl->display('report.tpl');






/**********
 * Clean & import initial parameter variables
 * For templates & courses, if the 'Any' option was selected, it'll have
 * an id value of 0.  If it is selected, make it the only 'chosen' option
 */

function importParameterVariables()
{
  if(isset($_POST['param_template']))
    if(!in_array(0,$_POST['param_template']))
      foreach($_POST['param_template'] as $curr_template)
      {
	$chosen_templates[] = (int)$curr_template;
      }
    else
      $chosen_templates[] = 0;
  else
    $chosen_templates = array();

  if(isset($_POST['param_course']))
    if(!in_array(0,$_POST['param_course']))
      foreach($_POST['param_course'] as $curr_course)
      {
	$chosen_courses[] = (int)$curr_course;
      }
    else
      $chosen_courses[] = 0;
  else
    $chosen_courses = array();

  if(isset($_POST['param_year']))
    if(!in_array('--Any--',$_POST['param_year']))
    {
      foreach($_POST['param_year'] as $curr_year)
      {
	$chosen_years[] = $curr_year;
      }
    }
    else
      $chosen_years[] = '--Any--';
  else
    $chosen_years = array();



  if(isset($_POST['param_term']))
    foreach($_POST['param_term'] as $curr_term)
    {
      $chosen_terms[] = (int)$curr_term;
    }
  else
    $chosen_terms = array();

  if(isset($_POST['param_type']))
    foreach($_POST['param_type'] as $curr_type)
    {
      $chosen_types[] = (int)$curr_type;
    }
  else
    $chosen_types = array();

  return array('chosen_templates'=>$chosen_templates,
	       'chosen_courses'=>$chosen_courses,
	       'chosen_terms'=>$chosen_terms,
	       'chosen_types'=>$chosen_types,
	       'chosen_years'=>$chosen_years);
}

function checkParameterData(&$tpl)
{
  if(!isset($_POST['param_template']) || count($_POST['param_template']) == 0)
  {
    $tpl->assign(array('success'=>FALSE,
		       'message'=>'At least one Template or "--Any--" must be selected'));
    return FALSE;
  }
  else if(!isset($_POST['param_course']) || count($_POST['param_course']) == 0)
  {
    $tpl->assign(array('success'=>FALSE,
		       'message'=>'At least one Course or "--Any--" must be selected'));
    return FALSE;
  }
  else if(!isset($_POST['param_year']) || count($_POST['param_year']) == 0)
  {
    $tpl->assign(array('success'=>FALSE,
		       'message'=>'At least one Year or "--Any--" must be selected'));
    return FALSE;
  }
  else if(!isset($_POST['param_term']) || count($_POST['param_term']) == 0)
  {
    $tpl->assign(array('success'=>FALSE,
		       'message'=>'At least one Term must be checked'));
    return FALSE;
  }
  else if(!isset($_POST['param_type']) || count($_POST['param_type']) == 0)
  {
    $tpl->assign(array('success'=>FALSE,
		       'message'=>'At least one Type must be checked'));
    return FALSE;
  }
  else
    return TRUE;
}

function checkReportQuestionSanity(&$tpl)
{
  $show_set = isset($_POST['show']);
  $ignore_set = isset($_POST['ignore']);

  if(!$show_set)
  {
    $tpl->assign(array('success'=>FALSE,
		       'message'=>"At least one question must be checked as 'Show' for the report to contain any data"));
    return FALSE;
  }

  foreach($_POST['questions'] as $question_id)
  {
    /* Make sure all questions that are conditional, are not also flagged as 'show' or 'ignore' */
    if(isset($_POST['required_'.$question_id]))
    {
      if(in_array($question_id,$_POST['show']))
      {
	$tpl->assign(array('success'=>FALSE,
			   'message'=>"A question (#$question_id) cannot be a condition and be shown.  Uncheck either all the boxes in the 'Answer' column, or the box in the 'Show' column"));
	return FALSE;
      }
      else if($ignore_set && in_array($question_id,$_POST['ignore']))
      {
	$tpl->assign(array('success'=>FALSE,
			   'message'=>"A question (#$question_id) cannot be a condition and ignored.  Questions with answer restrictions will not appear in the report data"));
	return FALSE;
      }
    }
    /* Make sure all questions that are flagged as 'show' are not flagged 'ignore' */
    if($ignore_set && $show_set)
    {
      if(in_array($question_id,$_POST['show']) && in_array($question_id,$_POST['ignore']))
      {
	$tpl->assign(array('success'=>FALSE,
			   'message'=>"A question (#$question_id) cannot be both shown & ignored."));
	return FALSE;
      }
    }
  }

  /* It may not look like it, but all possible combinations of conditional, 'show',
   * and 'ignore' have been checked at this point
   */

  return TRUE;
}
?>