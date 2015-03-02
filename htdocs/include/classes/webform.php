<?PHP
class WebForm
{
  private $id;
  private $instance_id;
  private $template_id;
  private $template_name;
  private $course_id;
  private $school_year;
  private $term;
  private $type;
  private $name;
  private $respondents;
  private $expiry_date;
  private $public;
  private $intro;
  private $file_request = FALSE;
  private $file_count = 1;
  private $email = FALSE;
  private $password_hash;
  private $respondent_accounts;
  public $questions;

  private $DB;
  private $error;

  function __construct($identifier = FALSE)
  {
    $this->DB = DBi::getInstance();

    if($identifier !== FALSE)
    	$this->load($identifier);
  }

  /*****
   * Function: load()
   * Purpose: To load the properties of the web form identified by $identifier which may be a name or an ID
   */
  function load($identifier)
  {
	$db_identifier = $this->DB->escape($identifier);
	
    $query = <<<SQL
SELECT
      *
FROM
      `web_form`
WHERE
      `id` = '$identifier' OR
	  `name` = '$identifier'
SQL;

    $result = @$this->DB->execute($query,'loading web form');
    if(!$result)
    {
      $this->error = 'Unable to load form due to a database error: "'.$this->DB->getError().'"';
      return FALSE;
    }
    else
    {		
		if($this->DB->numRows($result) != 0)
		{
			$row                = $this->DB->getData($result);
			$this->id           = $row['id'];
			$this->instance_id  = $row['instance_id'];
			$this->template_id  = $row['template_id'];
			$this->course_id    = $row['course_id'];
			$this->term         = $row['term'];
			$this->type         = $row['questionnaire_type'];
			$this->name         = $row['name'];
			$this->school_year  = $row['school_year'];
			$this->expiry_date  = $row['expiry_date'];
			$this->public       = ($row['public'] == 1) ? TRUE : FALSE;
			$this->intro        = $row['intro'];
			$this->file_request = (is_null($row['file_request'])) ? FALSE : $row['file_request'];
			$this->file_count   = $row['file_count'];
			$this->confirmation = $row['confirmation'];
			$this->email        = (is_null($row['email'])) ? FALSE : $row['email'];
		  $this->removeExpired();
		}
		else
		{
			$this->error = 'No web form exists with that ID';
			return FALSE;
		}
    }
  }
  
  	/******
	 * Function: loadRespondents()
	 * Purpose: To load existing respondent accounts for this form
	 */
	function loadRespondents()
	{
		$id = $this->DB->escape($this->id);
		
		$query = <<<SQL
			SELECT
				*
			FROM
				`web_form_account`
			WHERE
				`form_id` = '$id'
SQL;

		$result = $this->DB->execute($query,'retrieving number of remaining respondents');
		if(!$result)
		{
			$this->error = 'Unable to retrieve number of respondents due to a database error: "'.$this->DB->getError().'"';
			return FALSE;
		}
		else
		{
			if($this->DB->numRows($result))
			{		
				while($row = $this->DB->getData($result))
				{
					$this->respondent_accounts[] = $row['password'];
				}
			}
		}
	}

  /*****
   * Function: create()
   * Purpose: To create a new web form & set it's properties in `web_form`
   * Parameters: (int)$template_id: the id of the template the form is built from
   *             (int)$course_id: the id of the course the form is for
   *             (string)$school_year: the school year the course is for.  Should be in the format: XXXX-YYYY where YYYY = XXXX+1
   *             (int)$term: the ID for the term.  This should be an index value of $QUESTIONNAIRE_TERMS
   *             (int)$type: the ID for the type.  This should be an index value of $QUESTIONNAIRE_TYPES
   *			 (string)$name: the name for the form
   *             (int)$respondents: The number of expected respondents
   *             (int)$expiry_date: The date this web form & it's accounts expires.  UNIX_TIMESTAMP
   *             (bool)$public: Whether this form is public or not
   *			 (text)$intro: Text to appear as an intro to the form
   *			 (text)$file_request: Text to appear before the <input:file> field
   *			 (int)$file_count: The number of file inputs to display
   *			 (text)$email: Email address to be emailed when an entry is provided
   */
  function create($template_id,$course_id,$school_year,$term,$type,$name,$respondents,$expiry_date,$public,$confirmation,$intro=FALSE,$file_request=FALSE,$file_count=1,$email=FALSE)
  {
    if(!$this->removeExpired())
      return FALSE;

    $Account = Account::getInstance();
    $instance_id = $Account->instance_id;

    $db_public = ($public) ? 1 : 0;
    $db_confirmation = $this->DB->escape($confirmation);
    $db_intro = ($intro) ? $this->DB->escape($intro) : '';
	$db_file_request = ($file_request) ? $this->DB->escape($file_request) : '';
	$db_file_count = (int)$file_count;

	$db_email = ($email) ? $this->DB->escape($email) : '';


    /* Check if any of the questions in the template don't have answers. */
    $Template = new Template($template_id);
    foreach($Template->questions as $Question)
    {
      if(count($Question->answers) == 0 && $Question->type != 'qualitative')
      {
	$this->error = 'Cannot create web form because question id #'.$Question->id.' does not have any possible answers';
	return FALSE;
      }
    }
	
	/* Check if the desired name is already taken */
	$db_name = $this->DB->escape($name);
	
	if(strlen($name) > 0)
	{
		$query = <<<SQL
SELECT
	count(*) as 'count'
FROM
	`web_form`
WHERE
	`name` = '$db_name'
SQL;
	
		$result = $this->DB->execute($query,'checking if form name is unique');
		if(!$result)
		{
		  $this->error = 'Unable to check if web form name is unique due to a database error: "'.$this->DB->getError().'"';
		  return FALSE;
		}
		else
		{
			$row = $this->DB->getData($result);
			if($row['count'] > 0)
			{
				$this->error = 'The web form name "'.$name.'" has already been used.  Please enter another.';
				return FALSE;
			}
		}
	}

    $query = <<<SQL
INSERT
INTO
      web_form
      (instance_id,
       template_id,
       course_id,
       term,
       questionnaire_type,
	   name,
       school_year,
       expiry_date,
       public,
       intro,
	   file_request,
	   file_count,
	   confirmation,
	   email)
VALUES
      ('$instance_id',
       '$template_id',
       '$course_id',
       '$term',
       '$type',
	   '$db_name',
       '$school_year',
       '$expiry_date',
       $db_public,
       '$db_intro',
	   '$db_file_request',
	   '$db_file_count',
	   '$confirmation',
	   '$db_email')
SQL;

    $result = $this->DB->execute($query,'creating web form');
    if(!$result)
    {
      $this->error = 'Unable to create web form due to a database error: "'.$this->DB->getError().'"';
      return FALSE;
    }
    else
    {
		$this->id           = $this->DB->lastInsertID();
		$this->instance_id  = $instance_id;
		$this->template_id  = $template_id;
		$this->course_id    = $course_id;
		$this->school_year  = $school_year;
		$this->term         = $term;
		$this->type         = $type;
		$this->name         = $name;
		$this->respondents  = $respondents;
		$this->expiry_date  = $expiry_date;
		$this->public       = $public;
		$this->intro        = $intro;
		$this->file_request = $file_request;
		$this->file_count   = $file_count;
		$this->confirmation = $confirmation;
		$this->email        = $email;
      return($this->_createRespondents());
    }
  }

	/*****
	 * Function: update()
	 * Purpose: To update some properties of the web form, and add respondents if necessary
	 * Parameters: Parameters are identical to their object property counterparts
	 */
	public function update($template_id,$course_id,$year,$term,$type,$expiry_date,$confirmation,$intro, $respondents,$file_request,$file_count,$email)
	{
		$id			= $this->DB->escape($this->id);
		$template 	= $this->DB->escape($template_id);
		$course		= $this->DB->escape($course_id);
		$year		= $this->DB->escape($year);
		$term		= $this->DB->escape($term);
		$type		= $this->DB->escape($type);
		$intro		= $this->DB->escape($intro);
		$expiry_date= $this->DB->escape($expiry_date);
		$file_request=$this->DB->escape($file_request);
		$file_count=$this->DB->escape($file_count);
		$confirmation = $this->DB->escape($confirmation);
		$email 		= $this->DB->escape($email);
		
		$query = <<<SQL
			UPDATE
				`web_form`
			SET
				`template_id`			= '$template',
				`course_id`				= '$course',
				`school_year`			= '$year',
				`term`					= '$term',
				`questionnaire_type`	= '$type',
				`intro`					= '$intro',
				`expiry_date`			= '$expiry_date',
				`file_request`			= '$file_request',
				`file_count`			= '$file_count',
				`confirmation`			= '$confirmation',
				`email`					= '$email'
			WHERE
				`id`					= '$id'
SQL;

		$result = $this->DB->execute($query,'updating web form properties');
		if(!$result)
		{
			$this->error = $this->DB->getError();
			return FALSE;
		}
		else
		{
			if($respondents != 0)
			{
				if($this->_createRespondents($respondents))
				{
					$this->template_id		= $template;
					$this->course			= $course;
					$this->year				= $year;
					$this->term				= $term;
					$this->type				= $type;
					$this->expiry_date		= $expiry_date;
					return TRUE;
				}
				else
					return FALSE;
			}
			else
				return TRUE;
		}
	}
  /*****
   * Function: createRespondents()
   * Purpose: To generate the account passwords for this form
   * Parameters: $accounts_add [optional] the number of accounts to add.  If not provided
   *			 $this->respondents is used to determine how many accounts to create
   *
   */
  private function _createRespondents($accounts_add=FALSE)
  {
	  $accounts_add = ($accounts_add) ? $accounts_add : $this->respondents;
    for($i=1;$i<=$accounts_add;++$i)
    {
      /* generate password */
      do
      {
	/* generate a new password */
	$curr_password = '';
	for($j=1;$j<=RESPONDENT_PASSWORD_LENGTH;++$j)
	{
	  /* This line just pulls a random character out of RESPONDENT_PASSWORD_CHARACTERS & puts it in the the $jth position */
	  $curr_password .= substr(RESPONDENT_PASSWORD_CHARACTERS,rand(0,strlen(RESPONDENT_PASSWORD_CHARACTERS)-1),1);  
	}
	
	$password_hash = Auth::hash($this->id.$curr_password);

	/* check if it's in the DB already */
	$query = "SELECT * FROM web_form_account WHERE password = '$password_hash'";

	$result = $this->DB->execute($query,'checking pre-existence of newly created password');
	if(!$result)
	{
	  $this->error = 'Unable to check pre-existence of a newly created password due to a database error: "'.$this->DB->getError().'"';
	  return FALSE;
	}
      }
      while($this->DB->numRows($result) > 0);

      $query = <<<SQL
INSERT
INTO
	web_form_account
	(form_id,
	 password)
VALUES
	($this->id,
	 '$password_hash')
SQL;
      $result = $this->DB->execute($query,'creating a web form login');
      if(!$result)
      {
	$this->error = 'Unable to create a web form login due to a database error: "'.$this->DB->getError().'"';
	return FALSE;
      }
      else
	$this->respondent_accounts[] = $curr_password;
    }
    return TRUE;
  }


  /*****
   * Function: login()
   * Purpose: To make sure the password is valid & create some session variables
   * Parameters: (string)$raw_password: the POSTed password the user entered
   */
  function login($raw_password=FALSE)
  {	  
	  
    /* If the web form is public, don't worry about checking the password yet */
    if($this->public)
    {
		// cause a problem if there are no unused passwords for this form
		$password_hash = $this->findUnusedPasswordHash();
		
		//unlock the web_form table
		$query = "UNLOCK TABLES";
		$result = $this->DB->execute($query,'unlocking table');
		
		if(!$password_hash)
			return FALSE;

		$_SESSION['logged_in'] = TRUE;
		$_SESSION['form'] = $this->id;
		$_SESSION['password_hash'] = 'public';
		$_SESSION['instance_id'] = $this->instance_id;
		return TRUE;
    }
	
    $raw_password = trim(cleanGPC($raw_password));
    $password_hash = Auth::hash($this->id.$raw_password);

    $query = <<<SQL
SELECT
      *
FROM
      web_form_account,
      web_form
WHERE
      form_id = $this->id AND
      password = '$password_hash' AND
      web_form_account.form_id = web_form.id AND
      web_form.expiry_date > UNIX_TIMESTAMP(NOW())
SQL;


    $result = @$this->DB->execute($query,'checking validity of password');
    if(!$result)
    {
      $this->error = 'Could not login due to a database error';
      return FALSE;
    }
    else if($this->DB->numRows($result) > 0)
    {
      $_SESSION['logged_in'] = TRUE;
      $_SESSION['form'] = $this->id;
      $_SESSION['password_hash'] = $password_hash;
      $row = $this->DB->getData($result);
      $_SESSION['instance_id'] = $row['instance_id'];
      return TRUE;
    }
    else
    {
      $this->error = 'Unknown password/form id';
      return FALSE;
    }
  }

  /*****
   * Function: removeExpired()
   * Purpose: To remove any web forms & web form accounts that are past their 
   *          expiry date.  It manages to delete from both tables with 1 query.
   * Note: It's completely instance agnostic as an expired account is an expired account.
   */
  function removeExpired()
  {
    $query = <<<SQL
DELETE
      web_form,
      web_form_account
FROM
      web_form,
      web_form_account
WHERE
      web_form.expiry_date < UNIX_TIMESTAMP(NOW()) AND
      web_form.id = web_form_account.form_id
SQL;
    $result = $this->DB->execute($query,'removing expired forms & form accounts');
    if(!$result)
    {
      $this->error = 'Unable to remove expired forms & form accounts due to a database error: "'.$this->DB->getError().'"';
      return FALSE;
    }
    else
      return TRUE;
  }

  /*****
   * Function: loadQuestions()
   * Purpose: To load the questions for the template this form is based on.
   * Note: Creates an array indexed by question id, with the question text, question type and position as an arrayed value
   */
  function loadQuestions()
  {
    $Template = new Template($this->template_id);
    $this->template_name = $Template->name;
    $questionsObj = $Template->questions;

    foreach($questionsObj as $Question)
    {		
      $Question->loadPositions();
      $this->questions[$Question->id] = array('text'=>$Question->text,
					      'type'=>$Question->type,
					      'qualitative_type'=>$Question->qualitative_type,
						  'opt_out'=>$Question->opt_out,
					      'position'=>$Question->positions[$this->template_id]);
      if($Question->answers_exist)
      {
	foreach($Question->answers as $Answer)
	{
	  $answers[$Answer->id] = $Answer->text;
	}
	$this->questions[$Question->id]['answers'] = $answers;
	unset($answers);
      }
    }
    return TRUE;
  }  
    
  /*****
   * Function: checkPost()
   * Purpose: To check $_POST & make sure all questions have answers
   */
  function checkPost()
  {
    if(!isset($this->questions))
      $this->loadQuestions();

    if(!isset($this->questions))
      return FALSE;

    foreach($this->questions as $question_id=>$properties)
    {
      if($properties['type'] == 'single')
      {
	if(isset($_POST['q_'.$question_id]))
	{
	  if(!is_array($properties['answers']))
	  {
	    $this->error = "Not all questions have answers.  This questionnaire cannot be completed.";
	    return FALSE;
	  }
	  /* If the value of this question is not a valid answer id, or 0... */
	  if(!in_array($_POST['q_'.$question_id],array_keys($properties['answers'])) && $_POST['q_'.$question_id] != 0)
	  {
	    $this->error = "All questions require a response.  Please answer question #".$properties['position'].'.';
	    return FALSE;
	  }
	}
	else
	{
	  $this->error = "All questions require a response.  Please answer question #".$properties['position'].'.';
	  return FALSE;
	}
      }
      else if($properties['type'] == 'multiple')
      {
	if(isset($_POST['q_'.$question_id]))
	{
	  /* won't be an array if "I prefer not to answer" is checked */
	  if(is_array($_POST['q_'.$question_id]))
	    foreach($_POST['q_'.$question_id] as $answer_id)
	    {
	      if(!in_array($answer_id,array_keys($properties['answers'])) && $answer_id != 0)
	      {
		$this->error = "Unknown answer id #$answer_id";
		return FALSE;
	      }
	    }
	}
	else
	{
	  $this->error = 'All questions require a response.  Please answer #'.$properties['position'].'.';
	  return FALSE;
	}
      }
      else if($properties['type'] == 'qualitative')
      {
	if(strlen($_POST['q_'.$question_id]) == 0)
	{
	  $this->error = 'All questions require a response.  Please answer #'.$properties['position'].'.';
	  return FALSE;
	}
	
      }
    }
    return TRUE;
  }
      

  /*****
   * Function: submit()
   * Purpose: To submit the response
   * Note: This function is pretty simple, because all the functionality & logic is done in Response
   */
  function submit()
  {
	$Response = new Response();

	/* All this just to check if the file upload went OK */
	if(isset($_FILES['userfile']))
	{
		echo __FILE__.'::'.__LINE__.'<br />';
		foreach($_FILES['userfile']['name'] as $index=>$name){
			$file = array(
				'tmp_name' =>$_FILES['userfile']['tmp_name'][$index],
				'error'    =>$_FILES['userfile']['error'][$index],
			);

			if(!$Response->checkFile($file,$index))
			{
				$this->error = $Response->error;
				return FALSE;
			}
		}
	}
	$Response->setProperties($this->template_id,$this->course_id,$this->term,$this->type,$this->school_year,$this->_getResponseNumber());

	foreach($this->questions as $question_id=>$properties)
	{
	  $Question = new Question($question_id,TRUE);
	  $Response->setAnswer($Question,$_POST['q_'.$question_id]);
	}

	// Saving the file has to be done after $Response->setAnswer() is called, because it is that method that triggers
	// the creation of the "response_id", which is needed in saveFile()
	if(isset($_FILES['userfile']))
	{
		$filenames = array();

		foreach($_FILES['userfile']['name'] as $index=>$name){
			$file = array(
				'name'     =>$name,
				'type'     =>$_FILES['userfile']['type'][$index],
				'tmp_name' =>$_FILES['userfile']['tmp_name'][$index],
				'error'    =>$_FILES['userfile']['error'][$index],
				'size'     =>$_FILES['userfile']['size'][$index],
			);

			$filename = $Response->moveFile($file,$index);
			if($filename)
				$filenames[] = $filename;
			else{
				$this->error = $Response->error;
				return FALSE;
			}

		}

		if(!$Response->saveFiles($filenames))
		{
			$this->error = $Response->error;
			return FALSE;
		}
	}
	if($this->email && !$this->sendNotification()){
		return FALSE;
	}
	else{
		#$this->invalidateAccount();
		return TRUE;
	}
  }

  /*****
   * Function: _getResponseNumber()
   * Purpose: To retrieve the current response number & increment the value in the database, all as atomically as possible
   * Note: This function locks the web_form table so no 2 requests can get the same number
   */
  private function _getResponseNumber()
  {
    $query = "LOCK TABLE web_form WRITE";
    $result = $this->DB->execute($query,'locking table');
    if($result)
    {
      $query = "SELECT number FROM web_form WHERE id=$this->id";
      $select_result = $this->DB->execute($query,'getting web form number');
      if($select_result)
      {
	$query = "UPDATE web_form SET number=number+1 WHERE id=$this->id";
	$update_result = $this->DB->execute($query,'updating web form number');
      }

      $query = "UNLOCK TABLES";
      $result = $this->DB->execute($query,'unlocking table');
    }
    $row = $this->DB->getData($select_result);
    return ($row['number'] + 1);
  }


  /*****
   * Function: invalidateAccount()
   * Purpose: To render this account invalid, thereby not allowing
   *          a user to re-post their data & screw up the data set,
   *          nor allowing them to login again.
   */
  function invalidateAccount()
  {
    /* If the form is public, find an unused password for this form & invalidate it.  Still using a password
     * behind-the-scenes allows the # of responses to still be limited
     */
    if($this->public)
    {
      $password_hash = $this->findUnusedPasswordHash();
      if(!$password_hash)
		return FALSE;
    }
    else
      $password_hash = $_SESSION['password_hash'];
    

    $query = <<<SQL
DELETE
FROM
      web_form_account
WHERE
      form_id = $_SESSION[form] AND
      password = '$password_hash'
SQL;
    $result = $this->DB->execute($query,'deleting web form account',TRUE);



    /* Regardless of the success of the account deletion, the table still needs to be unlocked if the form is public.
     * `web_form_account` will have been locked by $this->findUnusedPasswordHash
     */
    if($this->public)
      $this->DB->execute('UNLOCK TABLES','unlocking web_form_account table');


    /* After we've unlocked the table, carry on with acting on the result of the deletion query. */
    if(!$result)
    {
      $this->error = 'Unable to delete web form account after successful entry due to a database error: '.$this->DB->getError();
      return FALSE;
    }
    else
    {
      unset($_SESSION['form'],$_SESSION['password_hash']);
      return TRUE;
    }
  }


  /*****
  * Function: findUnusedPasswordHash()
  * Purpose: To find an unused password for a public form, that can be invalidated
  */
  function findUnusedPasswordHash()
  {
    /* Lock the table so 2 users can't retrieve the same password */
    $query = <<<SQL
LOCK TABLE web_form_account WRITE
SQL;
    $this->DB->execute($query,'locking web_form_account to ensure no one else retrieves the same password');

    $query = <<<SQL
SELECT
      password
FROM
      web_form_account
WHERE
      form_id = $this->id
SQL;
    $result = $this->DB->execute($query,'retrieving password hash for a public questionnaire');
    if($this->DB->numRows($result))
    {
      $row = $this->DB->getData($result);
      return $row['password'];
    }
    else
    {
      $this->error = 'Unable to find an unused password and/or the maximum number of respondents has been reached.';
      return FALSE;
    }
  }


	/*****
	 * Function: sendNotification()
	 * Purpose: To send an email notification to the requested email(s)
	 */
	function sendNotification()
	{
		$identifier = (strlen($this->name)) ? 'name of '.$this->name : 'id of '.$this->id;

		$message = "A response has been entered for the webform with the $identifier";
		
		$sent = mail($this->email,'WASSAIL web form response',$message,'From: no-reply@'.$_SERVER['HTTP_HOST']."\r\n");

		if(!$sent){
			$this->error = 'Notification email was not sent.  Contact system administrator.';
			return FALSE;
		}
		else
			return TRUE;	
	}



  function __get($name)
  {
    return $this->{$name};
  }
}
?>