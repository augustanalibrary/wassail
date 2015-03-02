<?php require_once('/var/www/htdocs/include/template_lite/plugins/modifier.date.php'); $this->register_modifier("date", "tpl_modifier_date");  require_once('/var/www/htdocs/include/template_lite/plugins/modifier.escape.php'); $this->register_modifier("escape", "tpl_modifier_escape");  require_once('/var/www/htdocs/include/template_lite/plugins/function.counter.php'); $this->register_function("counter", "tpl_function_counter");  /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2014-04-29 11:02:29 MDT */ ?>

<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("head.tpl", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
      <?php if (isset ( $this->_vars['success'] )): ?>
      <div <?php if ($this->_vars['success']): ?>class = "success" id = "success-message"<?php else: ?>class = "error"<?php endif; ?>>
	<?php echo $this->_vars['message']; ?>

      </div>
      <?php endif; ?>
      <?php if ($this->_vars['right_write']): ?>
    <img src = "include/templates/images/add.png" alt = "Add new Course" title = "Click to add a new Course..." id = "add-course" class = "clickable"/>
    <?php endif; ?>

    
      <?php if (isset ( $this->_vars['list'] ) && count ( $this->_vars['list'] )): ?>
      <?php if ($this->_vars['order_dir'] == 'asc'): ?>
        <?php $this->assign('dir', "asc"); ?>
        <?php $this->assign('dir_other', "desc"); ?>
        <?php $this->assign('dir_arrow', "<img src = 'include/templates/images/arrow_down.png' alt = 'Sort descending' />"); ?>
      <?php else: ?>
        <?php $this->assign('dir', "desc"); ?>
        <?php $this->assign('dir_other', "asc"); ?>
        <?php $this->assign('dir_arrow', "<img src = 'include/templates/images/arrow_up.png' alt = 'Sort ascending' />"); ?>
      <?php endif; ?>
    <form method = "post" action = "courses/<?php echo $this->_vars['order_column']; ?>
/<?php echo $this->_vars['order_dir']; ?>
/">
      <div>
	
	<input type = "hidden" name = "unsetedit" id = "hidden-edit" value = "0" />
	<input type = "hidden" name = "unsetdelete" id = "hidden-delete" value = "0" />
	
	<table class = "list">
	  <tr>
	    <th style = "width:40px;">
	      <span title = "Click to sort by ID">
		<a href = "courses/id/<?php if ($this->_vars['order_column'] == 'id'):  echo $this->_vars['dir_other'];  else:  echo $this->_vars['dir'];  endif; ?>/">
		  ID<?php if ($this->_vars['order_column'] == 'id'):  echo $this->_vars['dir_arrow'];  endif; ?>
		</a>
	      </span>
	    </th>
	    <th style = "width:120px;">
	      <span title = "Click to sort by Course number">
		<a href = "courses/number/<?php if ($this->_vars['order_column'] == 'number'):  echo $this->_vars['dir_other'];  else:  echo $this->_vars['dir'];  endif; ?>/">
		  Course number<?php if ($this->_vars['order_column'] == 'number'):  echo $this->_vars['dir_arrow'];  endif; ?>
		</a>
	      </span>
	    </th>
	    <th>
	      <span title = "Click to sort by Course name">
		<a href = "courses/name/<?php if ($this->_vars['order_column'] == 'name'):  echo $this->_vars['dir_other'];  else:  echo $this->_vars['dir'];  endif; ?>/">
		  Course name<?php if ($this->_vars['order_column'] == 'name'):  echo $this->_vars['dir_arrow'];  endif; ?>
		</a>
	      </span>
	    </th>
	    <th style = "width:220px;">
	      <span title = "Click to sort by Course instructor">
		<a href = "courses/instructor/<?php if ($this->_vars['order_column'] == 'instructor'):  echo $this->_vars['dir_other'];  else:  echo $this->_vars['dir'];  endif; ?>/">
		  Course instructor<?php if ($this->_vars['order_column'] == 'instructor'):  echo $this->_vars['dir_arrow'];  endif; ?>
		</a>
	      </span>
	    </th>
	    <th style = "width:110px;">
	      <span title = "Click to sort by date">
		<a href = "courses/date/<?php if ($this->_vars['order_column'] == 'date'):  echo $this->_vars['dir_other'];  else:  echo $this->_vars['dir'];  endif; ?>/">
		  Date added<?php if ($this->_vars['order_column'] == 'date'):  echo $this->_vars['dir_arrow'];  endif; ?>
		</a>
	      </span>
	    </th>
	    <th style = "width:50px;">
	    </th>
	  </tr>
	  <?php echo tpl_function_counter(array('print' => false,'assign' => "counter"), $this);?>
	  <?php if (count((array)$this->_vars['list'])): foreach ((array)$this->_vars['list'] as $this->_vars['row_id'] => $this->_vars['row']): ?>
	  <?php echo tpl_function_counter(array(), $this);?>
	  <tr class = "<?php if ((1 & $this->_vars['counter'])): ?>odd<?php else: ?>even<?php endif; ?>">
	    <td>
	      <?php echo $this->_vars['row']['id']; ?>

	    </td>
	    <td>
	      <input name = "number_<?php echo $this->_vars['row']['id']; ?>
" type = "text" value = "<?php echo $this->_run_modifier($this->_vars['row']['number'], 'escape', 'plugin', 1); ?>
" class = "input-field small" size = "15"/>
	    </td>
	    <td>
	      <input name = "name_<?php echo $this->_vars['row']['id']; ?>
" type = "text" value = "<?php echo $this->_run_modifier($this->_vars['row']['name'], 'escape', 'plugin', 1); ?>
" class = "input-field small" size = "62"/>
	    </td>
	    <td>
	      <input name = "instructor_<?php echo $this->_vars['row']['id']; ?>
" type = "text" value = "<?php echo $this->_run_modifier($this->_vars['row']['instructor'], 'escape', 'plugin', 1); ?>
" class = "input-field small" size = "33"/>
	    </td>
	    <td>
	      <?php echo $this->_run_modifier($this->_vars['row']['date_added'], 'date', 'plugin', 1, $this->_vars['date_format_short']); ?>

	    </td>
	    <td style = "text-align:left;">
	      <?php if ($this->_vars['right_write'] || $this->_vars['right_write_unconditional']): ?>
	      <input type = "image" src = "include/templates/images/disk.png" title = "Save changes" class = "image edit-submitter" name = "edit" value = "<?php echo $this->_vars['row']['id']; ?>
"/>
	      <?php if ($this->_vars['row']['asked'] == 0): ?>
	      <input type = "image" src = "include/templates/images/bin.png" title = "Delete" class = "image delete-submitter" name = "delete" value = "<?php echo $this->_vars['row']['id']; ?>
" />
	      <?php endif; ?>
	      <?php endif; ?>
	    </td>
	  </tr>
	  <?php endforeach; endif; ?>
	</table>
      </div>
    </form>
    <?php endif; ?>
    
    
    <?php if ($this->_vars['right_write']): ?>
    <div id = "add-course-wrapper" class = "action modal-div">
      <div class = "dialog modal-dialog" style = "width:1000px;">
	<h1>
	  Add a new Course/Event:
	</h1>
	<form id = "add-form" method = "post" action = "courses/<?php echo $this->_vars['order_column']; ?>
/<?php echo $this->_vars['order_dir']; ?>
/">
	<table>
	  <tr>
	    <th style = "text-align:right;vertical-align:top;">
	      Course number / Event name:
	    </th>
	    <td>
	      <input type = "text" name = "number" id = "new-number" size = "7" class = "input-field<?php if (( isset ( $this->_vars['add_error']['number'] ) )): ?> input-highlight<?php endif; ?>"/>
	      <img src = "include/templates/images/bullet_red.png" id = "new-number-status" class = "invalid" title = "Enter a new course number.  When this light turns green, the number is acceptable" alt = "Course number status"/><br />
	      (eg PSY 200 / Photo Contest)<br /><br />
	      </td>
	    </tr>
	    <tr>
	      <th style = "text-align:right;vertical-align:top;">
		Course / Event name:
	      </th>
	      <td>
			<input type = "text" name = "name" id = "new-name" size = "40" class = "input-field<?php if (( isset ( $this->_vars['add_error']['name'] ) )): ?> input-highlight<?php endif; ?>"/>
	      	<img src = "include/templates/images/bullet_red.png" id = "new-name-status" class = "invalid" title = "Enter a new course name.  When this light turns green, the name is acceptable" alt = "Course name status"/> <br />
	      	(eg Intro to Psychology / Photo Contest 2014)<br /><br />
	      </td>
	    </tr>
	    <tr>
	      <th style = "text-align:right;vertical-align:top;">
			Course instructor / Other info:
	      </th>
	      <td>
			<input type = "text" name = "instructor" id = "new-instructor" size = "30" class = "input-field<?php if (( isset ( $this->_vars['add_error']['instructor'] ) )): ?> input-highlight<?php endif; ?>"/><br />
			(eg Professor G. Smith / Used for gather info about photographer, submissions and upload photo entry)<br /><br />
	      </td>
	    </tr>
	    <tr>
	      <td colspan = "2" style = "text-align:center;">
		<input type = "submit" name = "save" value = "Add new course" style = "visibility:hidden;" class = "submit" id = "add-course-submit"/>
		<input type = "reset" name = "reset" value = "Cancel" class = "submit" id = "add-course-cancel" />
	      </td>
	    </tr>
	  </table>
	</form>
	</div>
      </div>
      <?php endif; ?> 



    <script type = "text/javascript" src = "include/templates/js/courses.js"></script>
    <?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("foot.tpl", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
