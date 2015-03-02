<?PHP
/**********
 * Class: Import
 * Purpose: To facilitate the uploading & importing of a CSV file which should contain
 *          valid responses, into the database
 *
 * Dylan Anderson
 * December 13, 2007
 * Check VC for revisions
 */

class Import
{
  private $filename;
  private $file_contents;
  private $DB;
  private $error;
  private $sane = TRUE;
  public $sanity_errors;
  private $valid_term_ids;
  private $valid_type_ids;

  function __construct($filename=FALSE)
  {
    $this->DB = DBi::getInstance();
    if($filename !== FALSE)
    {
      $this->filename = $filename;
      $this->load();
    }
  }

  /*****
   * Function: upload()
   * Purpose: Does more than just handle the upload of the file, it also calls load()
   *          which checks the data & ensures it's sane.
   */
  function upload()
  {
    $tmp_name = $_FILES['userfile']['tmp_name'];
    $original_name = $_FILES['userfile']['name'];
    $error = $_FILES['userfile']['error'];


    /* Generate a meaningful error if there was an upload error */
    if($error != UPLOAD_ERR_OK)
    {
      switch($error)
      {
        case UPLOAD_ERR_INI_SIZE:
	  $this->error = 'File was too large.  It exceeded the maximum filesize allowed by the server.';
	  return FALSE;
	  break;
        case UPLOAD_ERR_FORM_SIZE:
	  $this->error = 'File was too large.  It exceeded the maximum filesize allowed by the form.';
	  return FALSE;
	  break;
        case UPLOAD_ERR_PARTIAL:
	  $this->error = 'File upload did not complete.  Please try again.';
	  return FALSE;
	  break;
        case UPLOAD_ERR_NO_FILE:
	  $this->error = 'No file specified.';
	  return FALSE;
	  break;
        case UPLOAD_ERR_NO_TMP_DIR:
	  $this->error = 'No temporary directory available.';
	  return FALSE;
	  break;
        case UPLOAD_ERR_CANT_WRITE:
	  $this->error = 'Failed to write to disk.';
	  return FALSE;
	  break;
        case UPLOAD_ERR_EXTENSION:
	  $this->error = 'Improper file extension.';
	  return FALSE;
	  break;
        default:
	  $this->error = 'Unknown error value: '.$error;
	  return FALSE;
	  break;
      }
    }
    else
    {
      /* If the file was uploaded fine, move the file out of the temp directory */
      $new_filename = Auth::hash(microtime().$original_name).'.csv';
      if(@move_uploaded_file($tmp_name,UPLOAD_DIR.$new_filename))
      {
	$this->filename = $new_filename;
	return($this->load());
      }
    }
  }
	  

  /*****
   * Function: load()
   * Purpose: To load the file identified by $this->file into local variable space.  This function
   *          also masterminds the verification of the data to ensure it's sane
   */
  function load()
  {
    $this->file_contents = array();

    /* These variables will be used by the various _check* functions - but import them here to save cycles */
    global $QUESTIONNAIRE_TYPES,$QUESTIONNAIRE_TERMS;
    $this->valid_type_ids = array_keys($QUESTIONNAIRE_TYPES);
    $this->valid_term_ids = array_keys($QUESTIONNAIRE_TERMS);

    /* realpath() resolves symbolic links & ../. */
    $full_path = realpath(UPLOAD_DIR.$this->filename);
    if(!$full_path)
    {
      $this->error = "File path for '$this->filename' doesn't exist/isn't allowed.  Please rename the file and try again";
      return FALSE;
    }
    else
    {
      /* This will make fgetcsv properly examine the file to see if it's *nix/Windoze/Mac & use the
       * appropriate line endings
       */
      ini_set('auto_detect_line_endings',1);
      $fp = fopen($full_path,'r');
      if(!$fp)
      {
	$this->error = "Failed to open the uploaded file";
	return FALSE;
      }

      $line_number = 1;
      while($line = fgetcsv($fp))
      {
	/* this line generates a warning if the file isn't a legitimate CSV file */
	@list($instance_id,$number,$template_id,$course_id,$term_id,$type_id,$school_year,$question_id,$answer_id) = $line;
	list($sane,$errors) = $this->_checkLineSanity($instance_id,$number,$template_id,$course_id,$term_id,$type_id,$school_year,$question_id,$answer_id);
	$this->sane = ($this->sane) ? $sane : FALSE;

	if($sane)
	  $this->file_contents[] = array('instance_id'=>$instance_id,
					 'number'=>$number,
					 'template_id'=>$template_id,
					 'course_id'=>$course_id,
					 'term_id'=>$term_id,
					 'type_id'=>$type_id,
					 'school_year'=>$school_year,
					 'question_id'=>$question_id,
					 'answer_id'=>$answer_id);
	if(!$sane)
	  $this->sanity_errors[$line_number] = $errors;
	$line_number++;
      }

      return $this->sane;
    }
  }


  function import($filename)
  {
    $this->filename = $filename;
    if(!$this->load())
      return FALSE;


    $Response = new Response();
    $curr_template_id = $curr_course_id = $curr_term_id = $curr_type_id = $curr_school_year = $curr_number = FALSE;

    foreach($this->file_contents as $row)
    {
      /* Only make a new Response object if the response-specific data has changed */
      if($row['template_id'] != $curr_template_id ||
	 $row['course_id'] != $curr_course_id ||
	 $row['term_id'] != $curr_term_id ||
	 $row['type_id'] != $curr_type_id ||
	 $row['school_year'] != $curr_school_year ||
	 $row['number'] != $curr_number)
      {
	/*
	echo <<<COMPARE
<pre>
	  $row[template_id] : $curr_template_id
	  $row[course_id] : $curr_course_id 
	  $row[term_id] : $curr_term_id
	  $row[type_id] : $curr_type_id
	  $row[school_year] : $curr_school_year
	  $row[number] : $curr_number
</pre>
<br />
COMPARE;
	*/
	$Response = new Response();
	if(!$Response->setProperties($row['template_id'],$row['course_id'],$row['term_id'],$row['type_id'],$row['school_year'],$row['number']))
	{
	  $this->error = "Failed to create Response object with these properties: Template ID: $row[template_id], Course ID: $row[course_id], Term ID: $row[term_id], Type ID: $row[type_id], School year: $row[school_year], Number: $row[number].  Import stopped.";
	  return FALSE;
	}
	else
	{
	  $curr_template_id = $row['template_id'];
	  $curr_course_id = $row['course_id'];
	  $curr_term_id = $row['term_id'];
	  $curr_type_id = $row['type_id'];
	  $curr_school_year = $row['school_year'];
	  $curr_number = $row['number'];
	}
      }
	
      if(!$Response->setAnswer(new Question($row['question_id'],TRUE),$row['answer_id']))
      {
	$this->error = "Failed to import row with the information: '$row[instance_id]','$row[number]','$row[template_id]','$row[course_id]','$row[term_id]',$row[type_id]','$row[school_year]','$row[question_id]','$row[answer_id]'.  Import stopped";
	return FALSE;
      }
    }

    $this->deleteExpired();
    return TRUE;
  }

  /*****
   * Function: deleteExpired()
   * Purpose: To delete import files that have been sitting around for too long
   */
  function deleteExpired()
  {
    chdir(UPLOAD_DIR);
    $files = glob('*');
    foreach($files as $file)
    {
      if($file != '_README')
      {
	if(fileatime(UPLOAD_DIR.$file) < time()-UPLOAD_EXPIRY_TIME)
	{
	  if(!@unlink(UPLOAD_DIR.$file))
	    Mail::send(SYSADMIN_EMAIL,"Unable to delete expired import file: $file");
	}
      }
    }
  }

  /*****
   * Function: _checkLineSanity()
   * Purpose: To mastermind the data sanity checking for a line of the CSV
   * Returns: An array - the first element is whether the data is sane or not, the second element is the error message to show the user
   */
  function _checkLineSanity($instance_id,$number,$template_id,$course_id,$term_id,$type_id,$school_year,$question_id,$answer_id)
  {
    if(!$this->_checkInstanceIDSanity($instance_id))
      return array(FALSE,'Instance ID ('.$instance_id.') is not your instance id');

    if(!$this->_checkNumberSanity($number))
      return array(FALSE,'Number ('.$number.')is not a whole number (1,2,3,etc)');
    
    if(!$this->_checkTemplateSanity($instance_id,$template_id))
      return array(FALSE,'Template ID ('.$template_id.') is not a valid Template in your instance');
    
    if(!$this->_checkCourseSanity($instance_id,$course_id))
      return array(FALSE,'Course ID ('.$course_id.') is not of a valid Course in your instance');

    if(!$this->_checkTermSanity($term_id))
      return array(FALSE,'Term ID ('.$term_id.') is not valid.  Must be 0-3');

    if(!$this->_checkTypeSanity($type_id))
      return array(FALSE,'Type ID ('.$type_id.') is not valid.  Must be 0-3');

    if(!$this->_checkSchoolYearSanity($school_year))
      return array(FALSE,'School year "'.$school_year.'" is not valid.  Check Help for valid year format');

    if(!$this->_checkQuestionSanity($instance_id,$template_id,$question_id))
      return array(FALSE,'Question ID ('.$question_id.')is either not associated with the template id ('.$template_id.') or is not a valid question in your instance');

    if(!$this->_checkAnswerSanity($question_id,$answer_id))
      return array(FALSE,'Answer id ('.$answer_id.') is not associated with the question id ('.$question_id.')');

    return array(TRUE,'Data is sane');
  }

  /*****
   * Functions: _check*
   * Purpose: To check the different properties of a response & make sure they're valid
   * Individual functions in this section won't be fully commented - just a short blurb
   */

  /* Make sure the passed instance is the same as the instance the user is in */
  function _checkInstanceIDSanity($instance_id)
  {
    $Account = Account::getInstance();
    return ($instance_id == $Account->instance_id) ? TRUE : FALSE;
  }
  
  /* Make sure the number is an integer > 0 */
  function _checkNumberSanity($number)
  {
    return ((int)$number == $number && (int)$number !== 0) ? TRUE : FALSE;
  }
  
  /* Make sure the template id is valid & in the passed instance */
  function _checkTemplateSanity($instance_id,$template_id)
  {
    if((int)$template_id != $template_id || (int)$template_id === 0)
      return FALSE;

    $query = <<<SQL
SELECT
      *
FROM
      template
WHERE
      id = '$template_id' AND
      instance_id = '$instance_id'
SQL;
    $result = $this->DB->execute($query,'checking template id sanity',FALSE);
    if($result && $this->DB->numRows($result) > 0)
      return TRUE;
    else
      return FALSE;
  }
  
  /* Make sure the course is in the current instance */
  function _checkCourseSanity($instance_id,$course_id)
  {
    if((int)$course_id != $course_id || (int)$course_id === 0)
      return FALSE;

    $query = <<<SQL
SELECT
      *
FROM
      course
WHERE
      id = '$course_id' AND
      instance_id = '$instance_id'
SQL;
    $result = $this->DB->execute($query,'checking course id sanity',FALSE);
    if($result && $this->DB->numRows($result) > 0)
      return TRUE;
    else
      return FALSE;
  }
  /* Check term id validity.  $this->valid_term_ids is set in load() */
  function _checkTermSanity($term_id)
  {
    return (in_array($term_id,$this->valid_term_ids));
  }
  
  /* Check type id validity */
  function _checkTypeSanity($type_id)
  {
    return (in_array($type_id,$this->valid_type_ids));
  }

  /* Make sure the school year is in the right format (XXXX-YYYY) & that YYYY is 1 greater than XXXX */
  function _checkSchoolYearSanity($school_year)
  {
    if(preg_match('/^(\d{4})-(\d{4})$/',$school_year,$matches))
    {
      if((int)$matches[2] == (((int)$matches[1])+1))
	return TRUE;
    }
    return FALSE;
  }

  /* Make sure the question is in this instance & is assigned to the template */
  function _checkQuestionSanity($instance_id,$template_id,$question_id)
  {
    /* This query checks if the question is assigned to the template, and that the question exists
     * for the instance.
     */
    $query = <<<SQL
SELECT
      *
FROM
      question_template,
      question
WHERE
      template_id = '$template_id' AND
      question_id = '$question_id' AND
      instance_id = '$instance_id' AND
      question_template.question_id = question.id
SQL;
    $result = $this->DB->execute($query,'checking question id sanity',FALSE);
    if($result && $this->DB->numRows($result) > 0)
      return TRUE;
    else
      return TRUE;
  }

  /* Make sure the answer id is assiged to the passed question id */
  function _checkAnswerSanity($question_id,$answer_id)
  {
    $query = <<<SQL
SELECT
      *
FROM
      answer
WHERE
      id = '$answer_id' AND
      question_id = '$question_id'
SQL;
    $result = $this->DB->execute($query,'checking answer id sanity',FALSE);
    if($result && $this->DB->numRows($result) > 0)
      return TRUE;
    else
      return FALSE;
  }

  function __get($name)
  {
    return $this->{$name};
  }
}
?>