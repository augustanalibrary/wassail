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

  /**********
   * Class: UserAdmin
   * Purpose: To facilitate the management of instances & accounts.
   * Note: There is no function to delete instances.  The consequences of errantly
   *       removing a instance are so high, and the need to remove an instance comes
   *       around so infrequently, that I (Dylan) will do it manually if it's ever necessary
   */


class UserAdmin
{
  private $full_list;
  private $error;
  private $DB;

  function __construct()
  {
    $this->DB = DBi::getInstance();
  }





  /*****
   * Function: getFullList()
   * Purpose: To retrieve a complete list of all instances & accounts.  Stores result in $this->full_list
   * Note: This function is magically called by __get() if $this->full_list isn't populated
   *       when $this->full_list is requested
   */
  function getFullList()
  {
    $query = <<<SQL
SELECT
      instance.*,
      account.username,
      account.right_read,
      account.right_write,
      account.right_write_unconditional,
      account.right_report,
      account.right_help,
      account.right_account
FROM
      instance
LEFT JOIN
      account
ON
      account.instance_id = instance.id
ORDER BY
      instance.id ASC,
      account.username ASC
SQL;
    $result = $this->DB->execute($query,'retrieving a list of all accounts & instances');
    if($result)
    {
      if($this->DB->numRows($result))
      {
	while($row = $this->DB->getData($result))
	{
	  /* Always set the instance name */
	  $this->full_list[$row['id']]['name'] = $row['name'];
	  
	  /* If there are valid users (these fields will be NULL if instance has no accounts */
	  if(!is_null($row['username']))
	  {
	    $user = array('username'=>$row['username'],
			  'right_read'=>$row['right_read'],
			  'right_write'=>$row['right_write'],
			  'right_write_unconditional'=>$row['right_write_unconditional'],
			  'right_report'=>$row['right_report'],
			  'right_help'=>$row['right_help'],
			  'right_account'=>$row['right_account']);
	    $this->full_list[$row['id']]['users'][] = $user;
	  }
	}
      }
    }
  }







  /*****
   * Function: changePassword()
   * Purpose: To change the password for a user
   */
  function changePassword($username,$password,$confirm_password)
  {
    if(!Auth::rightAccount())
      return FALSE;

    if(strlen($password) == 0)
    {
      $this->error = "Password wasn't entered";
      return FALSE;
    }
    if($password != $confirm_password)
    {
      $this->error = "Passwords don't match";
      return FALSE;
    }

    $account = cleanGPC($username);
    $password = Auth::hash(cleanGPC($password));

    $query = <<<SQL
UPDATE
      account
SET
      password = '$password'
WHERE
      username = '$account'
SQL;

    $result = $this->DB->execute($query,'updating password');
    if(!$result)
    {
      $this->error = 'Password could not be updated due to a database error: "'.$this->DB->getError().'"';
      return FALSE;
    }
    else if($this->DB->affectedRows() == 0)
    {
      $this->error = 'Password was not updated.  No matching accounts -OR- password was not different than existing.';
      return FALSE;
    }
    else
      return TRUE;
  }








  /*****
   * Function: setRight()
   * Purpose: To grant/revoke a specific right for a specific account
   * Parameters: $username: self explanatory
   *             $right: a string key to a specific right.  Check the switch() below
   *             $action: either "revoke" or "grant"
   */
  function setRight($username,$right,$action)
  {
    if(!Auth::rightAccount())
      return FALSE;

    /* Filter the right to make sure it's valid */
    switch($right)
    {
      case 'read':
      case 'write':
      case 'write_unconditional':
      case 'help':
      case 'report':
      case 'account':
	break;
      default:
	$this->error = 'Unknown right "'.$right.'"';
	return FALSE;
	break;
    }

    /* convert $action to it's database equivalent */
    $status = ($action == 'grant') ? 1 : 0;

    $query = <<<SQL
UPDATE
      account
SET
      right_$right = $status
WHERE
      username = '$username'
SQL;
    $result = $this->DB->execute($query,'updating user rights',FALSE);
    if(!$result)
    {
      $this->error = 'Database error when setting right: "'.$this->DB->getError().'"';
      return FALSE;
    }
    else
      return TRUE;
  }








  /*****
   * Function: deleteUser()
   * Purpose: ...to delete a user.  Honestly - was that description necessary?
   */
  function deleteUser($username)
  {
    if(!Auth::rightAccount())
      return FALSE;

    $username = $this->DB->escape(cleanGPC($username));
    $query = <<<SQL
DELETE
FROM
      account
WHERE
      username = '$username'
SQL;
    $result = $this->DB->execute($query,'deleting account',FALSE);
    if(!$result)
    {
      $this->error = 'User could not be deleted due to a database error: "'.$this->DB->getError().'"';
      return FALSE;
    }
    return TRUE;
  }









  /*****
   * Function: createUser
   * Purpose: To create a user
   * Note: The rights aren't set with this function.  The interface to allow this
   *       would have been completely superfluous.  Accounts are therefore created
   *       with absolutely no rights.
   */
  function createUser($instance_id,$username,$password,$confirm_password)
  {
    if(!Auth::rightAccount())
      return FALSE;

    /* Make sure account parameters are valid */
    if(strlen($username) == 0)
    {
      $this->error = 'Username must be entered';
      return FALSE;
    }
    if(strlen($password) == 0)
    {
      $this->error = 'Password must be entered';
      return FALSE;
    }
    if($password != $confirm_password)
    {
      $this->error = "Passwords don't match";
      return FALSE;
    }
    if(!$this->checkUsernameExistence($username))
    {
      $this->error = (strlen($this->error)) ? $this->error : 'Username already exists';
      return false;
    }

    $username = $this->DB->escape(cleanGPC($username));
    $password = Auth::hash(cleanGPC($password));

    $query = <<<SQL
INSERT
INTO
      account
      (instance_id,
       username,
       password)
VALUES
      ('$instance_id',
       '$username',
       '$password')
SQL;
    $result = $this->DB->execute($query,'adding a new user');
    if(!$result)
    {
      $this->error = 'User could not added due to a database error: "'.$this->DB->getError().'"';
      return FALSE;
    }
    else
      return TRUE;
  }









  /*****
   * Function: checkUsernameExistence()
   * Purpose: To check if the passed username already exists in the database
   * Note: This function is called internally by createUser and externally from
   *       ajax.checkUsername.php
   */
  function checkUsernameExistence($username)
  {
    $username = $this->DB->escape($username);
      
    $query = <<<SQL
SELECT
      *
FROM
      account
WHERE
      username = '$username'
SQL;

    $result = $this->DB->execute($query,'checking pre-existence of username',FALSE);
    if(!$result)
    {
      $this->error = 'Database error while checking username pre-existence: "'.$this->DB->getError().'"';
      return FALSE;
    }
    else if($this->DB->numRows($result))
      return FALSE;
    else
      return TRUE;
  }











  /*****
   * Function: createInstance()
   * Purpose: To create a new Instance
   */
  function createInstance($name)
  {
    $name = cleanGPC($name);

    if(strlen($name) == 0)
    {
      $this->error = 'Instance name must be entered';
      return FALSE;
    }
    if(!$this->checkInstanceNameExistence($name))
    {
      $this->error = (strlen($this->error)) ? $this->error : 'Instance name already exists';
      return FALSE;
    }

    $name = $this->DB->escape($name);
    
    $query = <<<SQL
INSERT
INTO
      instance
      (name)
VALUES
      ('$name')
SQL;
    $result = $this->DB->execute($query,'inserting new instance');
    if(!$result)
    {
      $this->error = 'Instance could not be created due to a database error: "'.$this->DB->getError().'"';
      return FALSE;
    }
    else
      return TRUE;
  }









  /*****
   * Function: checkInstanceNameExistence()
   * Purpose: To check if the passed instance name exists in the database
   * Note: This function is called both internally by createInstance() and externally
   *       from ajax.checkInstanceName.php
   */
  function checkInstanceNameExistence($name)
  {
    $name = $this->DB->escape($name);

    $query = <<<SQL
SELECT
      *
FROM
      instance
WHERE
      name = '$name'
SQL;
    $result = $this->DB->execute($query,'checking pre-existence of instance name',FALSE);
    if(!$result)
    {
      $this->error = 'Database error while checking instance name pre-existence: "'.$this->DB->getError().'"';
      return FALSE;
    }
    else if($this->DB->numRows($result))
      return FALSE;
    else
      return TRUE;
  }





  function __get($name)
  {
    switch($name)
    {
      case 'full_list':
	if(!is_array($this->full_list))
	  $this->getFullList();
	return $this->full_list;
      default:
	return $this->{$name};
    }
  }
}
?>