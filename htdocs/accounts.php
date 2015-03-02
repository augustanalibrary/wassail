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

$require_right = 'account';
require_once('setup.php');
$UserAdmin = new UserAdmin();



/* Password form */
if(isset($_POST['password_submit']))
{
  if(!$UserAdmin->changePassword($_POST['account'],$_POST['password'],$_POST['confirm_password']))
    $tpl->assign(array('success'=>FALSE,
		       'message'=>$UserAdmin->error));
  else
    $tpl->assign(array('success'=>TRUE,
		       'message'=>'Password changed'));
}


/* User delete form */
else if(isset($_POST['delete_x']))
{
  if(!$UserAdmin->deleteUser($_POST['account']))
    $tpl->assign(array('success'=>FALSE,
		       'message'=>$UserAdmin->error));
  else
    $tpl->assign(array('success'=>TRUE,
		       'message'=>'User deleted'));
}


/* User create form */
else if(isset($_POST['create_new_user']))
{
  if(!$UserAdmin->createUser($_POST['instance_id'],$_POST['username'],$_POST['password'],$_POST['confirm_password']))
    $tpl->assign(array('success'=>FALSE,
		       'message'=>$UserAdmin->error));
  else
    $tpl->assign(array('success'=>TRUE,
		       'message'=>'User added'));
}


/* Instance create form */
else if(isset($_POST['create_instance_submit']))
{
  if(!$UserAdmin->createInstance($_POST['name']))
    $tpl->assign(array('success'=>FALSE,
		       'message'=>$UserAdmin->error));
  else
    $tpl->assign(array('success'=>TRUE,
		       'message'=>'Instance created'));
}


$UserAdmin->getFullList();
$tpl->assign(array('title'=>'Account management',
		   'list'=>$UserAdmin->full_list,
		   'icons'=>array('add'=>'Add new Instance',
				  'user_add'=>'Add new User',
				  'key'=>'Change User password',
				  'delete'=>'Delete User')));
$tpl->display('useradmin.tpl');

?>