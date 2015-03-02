<?PHP

class Account
{
  public $DB;

  private $instance_id;
  private $username;
  private $right_read;
  private $right_write;
  private $right_write_unconditional;
  private $right_report;
  private $right_help;
  private $right_account;
  
  public static function getInstance()
  {
    static $instance;
    if(!isset($instance))
    {
      $c = __CLASS__;
      $username = @$_SESSION['username'];
      $instance = new $c($username);
    }
    return $instance;
  }

  function __construct($username)
  {
    $this->DB = DBi::getInstance();
    $query = <<<SQL
SELECT
      *
FROM
      account
WHERE
      username = '$username'
SQL;
    $result = $this->DB->execute($query,'retrieving user instance & rights');
    if($this->DB->numRows($result))
    {
      $row = $this->DB->getData($result);
      $this->instance_id = $row['instance_id'];
      $this->username = $row['username'];
      $this->right_read = ($row['right_read'] == 1) ? TRUE : FALSE;
      $this->right_write = ($row['right_write'] == 1) ? TRUE : FALSE;
      $this->right_write_unconditional = ($row['right_write_unconditional'] == 1) ? TRUE : FALSE;
      $this->right_report = ($row['right_report'] == 1) ? TRUE : FALSE;
      $this->right_help = ($row['right_help'] == 1) ? TRUE : FALSE;
      $this->right_account = ($row['right_account'] == 1) ? TRUE : FALSE;
    }
    else
      return FALSE;
  }

  /*****
   * Function: __get()
   * Purpose: This function is called automatically by PHP whenever code tries
   *          to directly reference a non-public class variable (such as $username).
   *          This function will return that value, as the private keyword for this class
   *          is only used to stop 'setting' of the variables.
   */  
  function __get($var)
  {
    return $this->{$var};
  }
}

?>