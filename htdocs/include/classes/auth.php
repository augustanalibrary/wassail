<?PHP
class Auth
{
  /******
   * Function: hash
   * Purpose: To be a common method for generating a hash of a string
   *          This method currently uses SHA256, but can be changed in the future
   *          This method does not refer to any object variables, so can be called
   *          instantly with the :: syntax.
   */  
  public static function hash($input)
  {
    return hash('sha256',$input);
  }


  /******
   * Function: login
   * Purpose: To process the login for a user.
   * Returns: boolean TRUE if everything went fine
   *          string message if something went wrong
   */
  function login($username,$password)
  {
    $username = cleanGPC($username);
    $password = Auth::hash(cleanGPC($password));

    $DB = DBi::getInstance();

    $query = <<<SQL
SELECT
    account.*,
    instance.name as 'instance_name'
FROM
    account,
    instance
WHERE
    username = '$username' AND
    password = '$password' AND
    account.instance_id = instance.id
SQL;
    $result = $DB->execute($query,'checking user credentials at login');
    if($DB->numRows($result) > 0)
    {
      $row = $DB->getData($result);

      $_SESSION['instance_id'] = $row['instance_id'];
      $_SESSION['instance_name'] = $row['instance_name'];
      $_SESSION['username'] = $username;
      if($row['right_read'] == 1)
	$_SESSION['right_read'] = TRUE;
      if($row['right_write'] == 1)
	$_SESSION['right_write'] = TRUE;
      if($row['right_write_unconditional'] == 1)
	$_SESSION['right_write_unconditional'] = TRUE;
      if($row['right_report'] == 1)
	$_SESSION['right_report'] = TRUE;
      if($row['right_help'] == 1)
	$_SESSION['right_help'] = TRUE;
      if($row['right_account'] == 1)
	$_SESSION['right_account'] = TRUE;

      return TRUE;
    }
    else
      $error = 'Invalid username/password';

    return $error;
  }

  /*****
   * Function: logout()
   * Purpose: To kill the current session
   * Returns: TRUE if everything went fine
   *          string message if something went wrong
   */
  public static function logout()
  {
    $error = FALSE;
    if(isset($_COOKIE[session_name()]))
    {
      if(!setcookie(session_name(), '', time() - 42000, '/'))
	$error = 'Session cookie could not be destroyed';
    }
    if(!$error)
    {
      if(!session_destroy())
	$error = 'Session data could not be destroyed';
    }

    return ($error) ? $error : TRUE;
  }

  /*****
   * Function: isAuthed()
   * Purpose: To determine if the current page load is coming from an authenticated client
   * Parameters: [optional] $required:  Either a string, an array of strings, or not passed.  
   * Returns:         If $required isn't set, this function just returns TRUE if the username
   *                     session variable is set, FALSE if not.  
   *                  If $required is a string & is a pre-defined  value (the values can 
   *                     be seen in the switch statement), the function returns TRUE if
   *                     the corresponding session variable is set.
   *                  If $required is an array of pre-defined strings, the function returns
   *                     TRUE if all the corresponding session variables are set.
   */
  public static function isAuthed($required = FALSE)
  {   
    if(!$required)
      return (isset($_SESSION['username'])) ? TRUE : FALSE;

    if(is_string($required))
    {
      $required_value = $required;
      unset($required);
      $required[] = $required_value;
    }

    if(is_array($required))
    {
      $permissions_satisfied = TRUE;

      foreach($required as $right)
      {
	switch($right)
	{
          case 'read':
	    $permissions_satisfied = ($permissions_satisfied && isset($_SESSION['right_read']));
	    break;
          case 'write':
	    $permissions_satisfied = ($permissions_satisfied && isset($_SESSION['right_write']));
	    break;
          case 'write_unconditional':
	    $permissions_satisfied = ($permissions_satisfied && isset($_SESSION['right_write_unconditional']));
	    break;
	  case 'report':
	    $permissions_satisfied = ($permissions_satisfied && isset($_SESSION['right_report']));
	    break;
	  case 'help':
	    $permissions_satisfied = ($permissions_satisfied && isset($_SESSION['right_help']));
	    break;
	  case 'account':
	    $permissions_satisfied = ($permissions_satisfied && isset($_SESSION['right_account']));
	    break;
	  default:
	    $permissions_satisfied = FALSE;
	    break;
	}
      }

      return $permissions_satisfied;
    }
    
    return FALSE;
  }


  /*****
   * You should be able to figure out what these functions do.
   * Note that they can be called in a singleton context: Auth::rightRead()
   */
  public static function rightRead()
  {
    return isset($_SESSION['right_read']);
  }
  public static function rightWrite()
  {
    return isset($_SESSION['right_write']);
  }
  public static function rightWriteUnconditional()
  {
    return isset($_SESSION['right_write_unconditional']);
  }
  public static function rightReport()
  {
    return isset($_SESSION['right_report']);
  }
  public static function rightHelp()
  {
    return isset($_SESSION['right_help']);
  }
  public static function rightAccount()
  {
    return isset($_SESSION['right_account']);
  }
}

?>