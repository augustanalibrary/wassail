<?php require_once('/var/www/htdocs/include/template_lite/plugins/modifier.date.php'); $this->register_modifier("date", "tpl_modifier_date");  require_once('/var/www/htdocs/include/template_lite/plugins/function.counter.php'); $this->register_function("counter", "tpl_function_counter");  /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2014-04-15 10:47:40 MDT */ ?>

<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("head.tpl", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>


<?php if (isset ( $this->_vars['success'] )): ?>
      <div <?php if ($this->_vars['success'] == TRUE): ?>class = "success" id = "success-message"<?php else: ?>class = "error"<?php endif; ?>>
	<?php echo $this->_vars['message']; ?>

      </div>
<?php endif; ?>
      <?php if ($this->_vars['order_dir'] == 'asc'): ?>
        <?php $this->assign('dir', "asc"); ?>
        <?php $this->assign('dir_other', "desc"); ?>
        <?php $this->assign('dir_arrow', "<img src = 'include/templates/images/arrow_down.png' alt = 'Sort descending' />"); ?>
      <?php else: ?>
        <?php $this->assign('dir', "desc"); ?>
        <?php $this->assign('dir_other', "asc"); ?>
        <?php $this->assign('dir_arrow', "<img src = 'include/templates/images/arrow_up.png' alt = 'Sort ascending' />"); ?>
      <?php endif; ?>


    <?php if ($this->_vars['right_write'] || $this->_vars['right_write_unconditional']): ?>
      <img src = "include/templates/images/add.png" alt = "Add new Template" title = "Click to add a new Template..." id = "add-template" class = "clickable" />
    <?php endif;  if (count ( $this->_vars['list'] ) != 0): ?>
    <form method = "post" action = "templates/<?php echo $this->_vars['order_column']; ?>
/<?php echo $this->_vars['order_dir']; ?>
/">
      
      
      <div style = "display:none;">
	<input type = "hidden" name = "unsetsave" id = "hidden-save" value = "0" />
	<input type = "hidden" name = "unsetcopy" id = "hidden-copy" value = "0" />
	<input type = "hidden" name = "unsetprint" id = "hidden-print" value = "0" />
	<input type = "hidden" name = "unsetdelete" id = "hidden-delete" value = "0" />
      </div>
      <table class = "list">
	<tr>
	  <th style = "width:40px;"><span title = "Click to sort by ID"><a href = "templates/id/<?php if ($this->_vars['order_column'] == 'id'):  echo $this->_vars['dir_other'];  else:  echo $this->_vars['dir'];  endif; ?>/">ID<?php if ($this->_vars['order_column'] == 'id'):  echo $this->_vars['dir_arrow'];  endif; ?></a></span></th>
	  <th style = "width:300px;"><span title = "Click to sort by Template name"><a href = "templates/name/<?php if ($this->_vars['order_column'] == 'name'):  echo $this->_vars['dir_other'];  else:  echo $this->_vars['dir'];  endif; ?>/" id = "name-link"><span id = "filter-title">Name<?php if ($this->_vars['order_column'] == 'name'):  echo $this->_vars['dir_arrow'];  endif; ?></span><span id = "filter-field-wrapper" class = "hidden"><input type = "text" class = "input-field small" id = "filter-field" title = "Enter any number of filter words.&lt;br /&gt;Only rows matching ALL seach terms will be visible.&lt;br /&gt;Search terms are case sensitive." /></span><img src = "include/templates/images/filter.png" title = "Filter on Name..." alt = "Filter" style = "vertical-align:top;" id = "filter" /></a></span></th>
	  <th>Questions</th>
	<th style = "width:120px;"><span title = "Click to sort by date"><a href = "templates/date/<?php if ($this->_vars['order_column'] == 'date'):  echo $this->_vars['dir_other'];  else:  echo $this->_vars['dir'];  endif; ?>/">Date added<?php if ($this->_vars['order_column'] == 'date'):  echo $this->_vars['dir_arrow'];  endif; ?></a></span></th>
	  <th style = "width:110px;"></th>
	</tr>
	<?php echo tpl_function_counter(array('print' => false,'assign' => "counter"), $this);?>
	<?php if (count((array)$this->_vars['list'])): foreach ((array)$this->_vars['list'] as $this->_vars['template']): ?>
	<?php echo tpl_function_counter(array(), $this);?>
	<tr class = "<?php if ((1 & $this->_vars['counter'])): ?>odd<?php else: ?>even<?php endif; ?>" style = "vertical-align:top;">
	  <td style = "width:40px;">
	    <?php echo $this->_vars['template']['id']; ?>

	  </td>
	  <td style = "text-align:left;width:300px;">
	    <input type = "text" class = "input-field small" value = "<?php echo $this->_vars['template']['name']; ?>
" name = "name_<?php echo $this->_vars['template']['id']; ?>
" size = "50" />
	    <!-- Used for filtering -->
	  <div class = "filter hidden"><?php echo $this->_vars['template']['name']; ?>
</div>
	  </td>
	  <td style = "text-align:left;">
	    <?php if (( ! $this->_vars['template']['asked'] && $this->_vars['right_write'] ) || $this->_vars['right_write_unconditional']): ?>
	    <img src = "include/templates/images/pencil.png" class = "clickable" alt = "Edit questions" title = "Modify Template content" onclick = "newWindow('<?php echo $this->_vars['template']['id']; ?>
');" />
	    <?php endif; ?>
	    <img src = "include/templates/images/eye.png" class = "question-show clickable" alt = "Show questions" title = "Show questions" id = "show-<?php echo $this->_vars['template']['id']; ?>
" />
	    <img src = "include/templates/images/eye-closed.png" class = "question-hide clickable" alt = "Hide questions" title = "Hide questions" style = "display:none;" id = "hide-<?php echo $this->_vars['template']['id']; ?>
"/>
	    <div class = "question-list hidden" id = "questions-<?php echo $this->_vars['template']['id']; ?>
">
	    </div>
	  </td>
	<td>
	  <?php echo $this->_run_modifier($this->_vars['template']['date_added'], 'date', 'plugin', 1, $this->_vars['date_format_short']); ?>

	</td>
	  <td style = "text-align:left;width:125px;">
	    <?php if ($this->_vars['right_write'] || $this->_vars['right_write_unconditional']): ?>
	    <input type = "image" src = "include/templates/images/disk.png" title = "Save changes" class = "image save-icon clickable" name = "save" value = "<?php echo $this->_vars['template']['id']; ?>
"/>
	    <input type = "image" src = "include/templates/images/page_copy.png" title = "Copy..." class = "image copy-icon" name = "copy" value = "<?php echo $this->_vars['template']['id']; ?>
"/>
	    <input type = "image" src = "include/templates/images/application_form_add.png" alt = "Make this template an online questionnaire..." title = "Make this template an online questionnaire..." class = "form-icon clickable image" value = "<?php echo $this->_vars['template']['id']; ?>
" />
		<?php if ($this->_vars['right_write_unconditional']): ?>
			<input type = "image" src = "include/templates/images/application_form_edit.png" alt = "Edit online questionnaire for this template" title = "Edit online questionnaire for this template" class = "form-edit-icon clickable image" value = "<?php echo $this->_vars['template']['id']; ?>
" />
		<?php endif; ?>
	    <img src = "include/templates/images/printer.png" title = "Print" class = "image print-icon clickable" id = "print-<?php echo $this->_vars['template']['id']; ?>
" alt = "Print"/>

	      <?php if (! $this->_vars['template']['asked']): ?>
	        <input type = "image" src = "include/templates/images/bin.png" title = "Delete" class = "image delete-icon clickable" name = "delete" value = "<?php echo $this->_vars['template']['id']; ?>
"/>
	      <?php endif; ?>
	    <?php endif; ?>
	  </td>
	</tr>
	<?php endforeach; endif; ?>
      </table>
    </form>
      <?php endif; ?>
    <?php if ($this->_vars['right_write'] || $this->_vars['right_write_unconditional']): ?>
    <div class = "modal-div action" id = "add-template-wrapper">
      <div class = "dialog modal-dialog">
	<h1>
	  Add a new Template
	</h1>
	<form method = "post" action = "templates/<?php echo $this->_vars['order_column']; ?>
/<?php echo $this->_vars['order_dir']; ?>
/" id = "add-form">
	<div style = "text-align:center;">
	  Name: <input type = "text" value = "<?php if (isset ( $this->_vars['add_name'] )):  echo $this->_vars['add_name'].escape;  endif; ?>" name = "name" <?php if (isset ( $this->_vars['add_error'] )): ?>class = "input-highlight"<?php endif; ?> id = "new-template-name"/>
	  <br />
	  <br />
	  <input type = "submit" value = "Add new Template" class = "submit" name = "add" id = "add-submit"/>
	  <input type = "reset" value = "Cancel" class = "submit" id = "add-cancel"/>
	</div>
      </form>
      </div>
    </div>
    <?php endif; ?>
	
	<?php if ($this->_vars['right_write_unconditional']): ?>
		<div class = "modal-div action" id = "web_form_list_wrapper">
      		<div class = "dialog modal-dialog">
				<h1>
	  				Edit web forms
				</h1>
				<div id = "web_form_list">
				</div>
				<p style = "text-align:center;">
					<input type = "submit" value = "Cancel" class = "submit" id = "edit-cancel"/>
				</p>
			</div>
		</div>
    <?php endif; ?>
<script type = "text/javascript" src = "include/templates/js/templates.js"></script>
<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("foot.tpl", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
