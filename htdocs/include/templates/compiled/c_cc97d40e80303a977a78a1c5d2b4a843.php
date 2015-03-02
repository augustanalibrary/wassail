<?php require_once('/var/www/htdocs/include/template_lite/plugins/modifier.escape.php'); $this->register_modifier("escape", "tpl_modifier_escape");  require_once('/var/www/htdocs/include/template_lite/plugins/function.counter.php'); $this->register_function("counter", "tpl_function_counter");  /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2014-04-20 16:02:04 MDT */ ?>

<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("head.tpl", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
  if (isset ( $this->_vars['success'] )): ?>
<div class = "<?php if ($this->_vars['success']): ?>success<?php else: ?>error<?php endif; ?>">
  <?php echo $this->_vars['message']; ?>

</div>
<br />
<?php endif; ?>

<?php if (count ( $this->_vars['list'] ) > 0): ?>
      <table class = "list">
	<tr class = "plain-header">
	  <th>
	    Instance ID
	  </th>
	  <th>
	    Instance Name
	  </th>
	  <th>
	    Username
	  </th>
	  <th style = "width:11%;">
	    Can read
	  </th>
	  <th style = "width:11%;">
	    Can write
	  </th>
	  <th style = "width:12%;">
	    Can write unconditionally
	  </th>
	  <th style = "width:11%;">
	    Can create reports
	  </th>
	  <th style = "width:11%;">
	    Can edit help
	  </th>
	  <th style = "width:11%;">
	    Can modify accounts
	  </th>
	<th>
	  <img src = "include/templates/images/add.png" title = "Create a new instance" alt = "Create instance" class = "instance-create clickable" />
	</th>
	</tr>
	<?php echo tpl_function_counter(array('name' => "instance_counter",'print' => FALSE,'assign' => "instance_counter",'start' => 0,'skip' => 1,'direction' => "up"), $this);?>

	<?php if (count((array)$this->_vars['list'])): foreach ((array)$this->_vars['list'] as $this->_vars['instance_id'] => $this->_vars['instance']): ?>
	<?php if ($this->_vars['instance_counter'] % 5 == 0 && $this->_vars['instance_counter'] != 0): ?>
		<tr class = "plain-header">
		  <th>
		    Instance ID
		  </th>
		  <th>
		    Instance Name
		  </th>
		  <th>
		    Username
		  </th>
		  <th style = "width:11%;">
		    Can read
		  </th>
		  <th style = "width:11%;">
		    Can write
		  </th>
		  <th style = "width:12%;">
		    Can write unconditionally
		  </th>
		  <th style = "width:11%;">
		    Can create reports
		  </th>
		  <th style = "width:11%;">
		    Can edit help
		  </th>
		  <th style = "width:11%;">
		    Can modify accounts
		  </th>
		<th>
		</th>
		</tr>
	<?php endif; ?>
	<?php echo tpl_function_counter(array('name' => "instance_counter",'assign' => "instance_counter"), $this);?>
	<tr class = "sub-header">
	  <td>
	    <?php echo $this->_vars['instance_id']; ?>

	  </td>
	  <td class = "instance_name">
	    <span class = "hidden id"><?php echo $this->_vars['instance_id']; ?>
</span>
	    <input type = "text" class = "hidden instance_field" value = "<?php echo $this->_run_modifier($this->_vars['instance']['name'], 'escape', 'plugin', 1); ?>
" />
	    <span class = "instance_display"><?php echo $this->_vars['instance']['name']; ?>
</span>
	    <img src = "include/templates/images/pencil.png" class = "instance_edit hidden clickable" />
		<br />
	    <img src = "include/templates/images/disk.png" class = "instance_save hidden clickable" />
	    <img src = "include/templates/images/cancel.png" class = "instance_cancel hidden clickable" />
	  </td>
	<td colspan = "8" style = "text-align:right;">
	  <!-- used by JS for user add -->
	  <div style = "display:none" id = "instance_<?php echo $this->_vars['instance_id']; ?>
_name"><?php echo $this->_vars['instance']['name']; ?>
</div>
	  <img src = "include/templates/images/user_add.png" title = "Add user to this instance" alt = "Add user" class = "user-add clickable" id = "user-add-<?php echo $this->_vars['instance_id']; ?>
"/>
	</td>
	</tr>
	<?php if (isset ( $this->_vars['instance']['users'] )): ?>
	<?php echo tpl_function_counter(array('name' => "account_counter",'print' => false,'assign' => "account_counter",'start' => 0), $this);?>
	<?php if (count((array)$this->_vars['instance']['users'])): foreach ((array)$this->_vars['instance']['users'] as $this->_vars['account']): ?>
	<?php echo tpl_function_counter(array('name' => "account_counter",'assign' => "account_counter"), $this);?>
      <tr class = "<?php if ((1 & $this->_vars['account_counter'])): ?>odd<?php else: ?>even<?php endif; ?>">
	<td>
	  <!-- Instance ID Filler -->
	</td>
	<td>
	  <!-- Instance Name Filler -->
	</td>
	<td>
	  <?php echo $this->_vars['account']['username']; ?>

	</td>
	<td>
	  <input type = "checkbox" name = "read" <?php if ($this->_vars['account']['right_read']): ?>checked="checked"<?php endif; ?> class = "radio clickable" value = "<?php echo $this->_vars['account']['username']; ?>
" id = "right_<?php echo $this->_vars['account']['username']; ?>
_read"/>
	</td>
	<td>
	  <input type = "checkbox" name = "write" <?php if ($this->_vars['account']['right_write']): ?>checked="checked"<?php endif; ?> class = "radio clickable" value = "<?php echo $this->_vars['account']['username']; ?>
" id = "right_<?php echo $this->_vars['account']['username']; ?>
_write"/>
	  </td>
	  <td>
	    <input type = "checkbox" name = "write_unconditional" <?php if ($this->_vars['account']['right_write_unconditional']): ?>checked="checked"<?php endif; ?> class = "radio write-unconditional clickable" value = "<?php echo $this->_vars['account']['username']; ?>
" id = "right_<?php echo $this->_vars['account']['username']; ?>
_write_unconditional"/>
	  </td>
	  <td>
	    <input type = "checkbox" name = "report" <?php if ($this->_vars['account']['right_report']): ?>checked="checked"<?php endif; ?> class = "radio clickable" value = "<?php echo $this->_vars['account']['username']; ?>
" id = "right_<?php echo $this->_vars['account']['username']; ?>
_report"/>
	  </td>
	  <td>
	    <input type = "checkbox" name = "help" <?php if ($this->_vars['account']['right_help']): ?>checked="checked"<?php endif; ?> class = "radio clickable" value = "<?php echo $this->_vars['account']['username']; ?>
" id = "right_<?php echo $this->_vars['account']['username']; ?>
_help"/>
	  </td>
	  <td>
	    <input type = "checkbox" name = "account" <?php if ($this->_vars['account']['right_account']): ?>checked="checked"<?php endif; ?> class = "radio clickable" value = "<?php echo $this->_vars['account']['username']; ?>
" id = "right_<?php echo $this->_vars['account']['username']; ?>
_account"/>
	  </td>
	  <td style = "width:40px;">
	    <img src = "<?php echo constant('WEB_PATH'); ?>
include/templates/images/password.png" alt = "Change password" title = "Click to change password for <?php echo $this->_vars['account']['username']; ?>
" class = "clickable password-button" id = "account_<?php echo $this->_vars['account']['username']; ?>
"/>
	    <form method = "post" action = "<?php echo constant('WEB_PATH'); ?>
accounts/">
	    <div style = "display:inline;">
	      <input type = "hidden" name = "account" value = "<?php echo $this->_vars['account']['username']; ?>
"/>
	      <input type = "image" src = "include/templates/images/bin.png" name = "delete" class = "image clickable delete-account" title = "Click to delete this account"/>
	    </div>
	    </form>
	  </td>
	</tr>
	<?php endforeach; endif; ?>
	<?php endif; ?>
	<?php endforeach; endif; ?>
      </table>
    <!-- New password form -->
    <div id = "password-form" class = "action modal-div">
      <div class = "dialog modal-dialog">
	<h1>
	  Enter new password for <span id = "password-account" style = "font-weight:bold"></span>:
	</h1>
	<form method = "post" action = "accounts/">
	<div>
	  <input type = "hidden" name = "account" id = "password-account-field" />
	  <table>
	    <tr>
	      <td>
		Password:
	      </td>
	      <td>
		<input type = "password" name = "password" class = "input-field" id = "password-field"/>
	      </td>
	    </tr>
	    <tr>
	      <td>
		Password again:
	      </td>
	      <td>
		<input type = "password" name = "confirm_password" class = "input-field" id = "confirm_password-field"/>
	      </td>
	    </tr>
	    <tr>
	      <td colspan = "2" style = "text-align:center;">
		<input type = "submit" class = "submit" value = "Change password" id = "password-submit" name = "password_submit"/>
	        <input type = "reset" class = "submit action-cancel" value = "Cancel"/>
	      </td>
	    </tr>
	  </table>
	</div>
      </form>
      </div>
    </div>

    <!-- Feedback from AJAX actions -->
    <div id = "right-feedback-wrapper" class = "action modal-div">
      <div id = "right-feedback">
      </div>
      <div id = "ajax-feedback-close" style = "display:none;text-align:center;margin-top:10px;">
	<input type = "submit" class = "submit action-cancel" value = "OK" />
      </div>
    </div>

    <!-- New user form -->
    <div id = "new-user-wrapper" class = "action modal-div">
      <div class = "dialog modal-dialog">
	<h1>
	  Create new user for <span id = "new-user-instance-name" style = "font-weight:bold;"></span>:
	</h1>
	<form method = "post" action = "<?php echo constant('WEB_PATH'); ?>
accounts/">
	  <div>
	  <input type = "hidden" name = "instance_id" id = "new-user-instance-id"/>
	  <table>
	    <tr>
	      <td style = "vertical-align:middle;">
		New username: 
	      </td>
	      <td>
		<input type = "text" name = "username" style = "vertical-align:middle;" class = "input-field" id = "new-user-username" />
		<img src = "include/templates/images/bullet_red.png" id = "username-status" alt = "Username status" title = "Enter a username.  When this light turns green, the username is acceptable." style = "vertical-align:middle;" class = "invalid"/>
	      </td>
	    </tr>
	    <tr>
	      <td>
		Password:
	      </td>
	      <td>
		<input type = "password" name = "password" id = "new-user-password" class = "input-field"/>
	      </td>
	    </tr>
	    <tr>
	      <td>
		Password again:
	      </td>
	      <td>
		<input type = "password" name = "confirm_password" id = "new-user-confirm-password" class = "input-field" />
	      </td>
	    </tr>
	    <tr>
	      <td colspan = "2" style = "text-align:center;">
		<input type = "submit" class = "submit" name = "create_new_user" id = "create-new-user" value = "Create" />
		<input type = "reset" class = "submit" id = "close-new-user" value = "Cancel"/>
	      </td>
	    </tr>
	  </table>
	</div>
      </form>
      </div>
    </div>


    <!-- New instance form -->
    <div id = "create-instance-wrapper" class = "action modal-div">
      <div class = "dialog modal-dialog">
	<form method = "post" action = "accounts/">
	<div style = "text-align:center;vertical-align:middle;">
	  <h1>
	    Create new Instance
	  </h1>
	  Instance name: <input type = "text" name = "name" id = "new-instance-name" class = "input-field" /><img src = "include/templates/images/bullet_red.png" id = "instance-name-status" alt = "New name status" title = "Enter a new instance name.  When this light turns green, the instance name is acceptable." class = "invalid" />
	  <br />
	  <br />
	  <input type = "submit" class = "submit" name = "create_instance_submit" id = "create-instance-submit" value = "Create new instance" />
	  <input type = "reset" class = "submit" id = "close-create-instance" value = "Cancel" />
	</div>
      </form>
      </div>
    </div>

<?php endif; ?>

<script type = "text/javascript" src = "include/templates/js/useradmin.js"></script>
<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("foot.tpl", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
