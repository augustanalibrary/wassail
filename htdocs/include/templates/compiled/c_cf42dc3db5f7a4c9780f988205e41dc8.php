<?php require_once('/var/www/htdocs/include/template_lite/plugins/modifier.date.php'); $this->register_modifier("date", "tpl_modifier_date");  /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2014-05-02 08:58:33 MDT */ ?>

<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("head.tpl", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>


<div class = "success hidden" id = "response-added-note">
Response(s) added/edited.  Please re-open the template to see the changes.
</div>




<?php if ($this->_vars['rightWrite']): ?>
      <img src = "include/templates/images/page_white_go.png" alt = "Import CSV" title = "Click to import a CSV of report data" id = "csv-import" class = "clickable" />
      <img src = "include/templates/images/add.png" alt = "Toggle visibility of add form" title = "Click to start adding responses" id = "add-form-show" class = "clickable"/>
<?php endif; ?>
    
    

    <?php if ($this->_vars['responded_templates'] != FALSE): ?>
    <?php if ($this->_vars['order_dir'] == 'asc'): ?>
      <?php $this->assign('dir', "asc"); ?>
      <?php $this->assign('dir_other', "desc"); ?>
      <?php $this->assign('dir_arrow', "<img src = 'include/templates/images/arrow_down.png' alt = 'Sort descending' />"); ?>
    <?php else: ?>
      <?php $this->assign('dir', "desc"); ?>
      <?php $this->assign('dir_other', "asc"); ?>
      <?php $this->assign('dir_arrow', "<img src = 'include/templates/images/arrow_up.png' alt = 'Sort ascending' />"); ?>
    <?php endif; ?>
    <table class = "list" id = "master-table">
      <tr>
	<th style = "width:40px;"><a href = "responses/id/<?php if ($this->_vars['order_column'] == 'id'):  echo $this->_vars['dir_other'];  else:  echo $this->_vars['dir'];  endif; ?>/"><span title = "Click to sort by ID">ID<?php if ($this->_vars['order_column'] == 'id'):  echo $this->_vars['dir_arrow'];  endif; ?></span></a></th>
	<th><a href = "responses/name/<?php if ($this->_vars['order_column'] == 'name'):  echo $this->_vars['dir_other'];  else:  echo $this->_vars['dir'];  endif; ?>/"><span title = "Click to sort by name">Name<?php if ($this->_vars['order_column'] == 'name'):  echo $this->_vars['dir_arrow'];  endif; ?></span></a></th>
	<th><a href = "responses/date_added/<?php if ($this->_vars['order_column'] == 'date_added'):  echo $this->_vars['dir_other'];  else:  echo $this->_vars['dir'];  endif; ?>/"><span title = "Click to sorty by date">Date Added<?php if ($this->_vars['order_column'] == 'date_added'):  echo $this->_vars['dir_arrow'];  endif; ?></span></a></th>
	<th></th>
      </tr>
      <?php if (count((array)$this->_vars['responded_templates'])): foreach ((array)$this->_vars['responded_templates'] as $this->_vars['properties']): ?>
      <tr class = "clickable real-row" id = "id_<?php echo $this->_vars['properties']['id']; ?>
">
	<td>
	  <?php echo $this->_vars['properties']['id']; ?>

	</td>
	<td style = "text-align:left;">
	  <?php echo $this->_vars['properties']['name']; ?>

	</td>
	<td>
	  <?php echo $this->_run_modifier($this->_vars['properties']['date_added'], 'date', 'plugin', 1, $this->_vars['date_format_short']); ?>

	</td>
	<td>
<?php if ($this->_vars['rightWrite']): ?>
	    <img src = "include/templates/images/bin.png" alt = "Click to delete all responses for this template" title = "Click to delete all responses for this template" class = "delete-responses" id = "delete_<?php echo $this->_vars['properties']['id']; ?>
" />
<?php else: ?>
	  &nbsp;
<?php endif; ?>
	</td>
      </tr>
	<tr class = "hidden">
	<td colspan = "4" id = "child-<?php echo $this->_vars['properties']['id']; ?>
" class = "child" style = "text-align:left;">
	  <img src = "include/templates/images/loading.gif" class = "loading" alt = "Loading" title = "Please wait while entries load..." />
	</td>
	</tr>
      <?php endforeach; endif; ?>
	  </table>
      <?php endif; ?>
    

<?php if ($this->_vars['rightWrite']): ?>
    
    <div class = "modal-div action" id = "add-response">
      <div class = "dialog modal-dialog" style = "width:500px;">
	  <h1>
	    Add responses
	  </h1>
	  <table id = "add-form">
	    <tr>
	      <td style = "text-align:right;">
		Template:
	      </td>
	      <td style = "text-align:left;">
		<?php if (count ( $this->_vars['templates'] ) > 0): ?>
		<select name = "template" class = "clickable small" id = "add-template">
		  <?php if (count((array)$this->_vars['templates'])): foreach ((array)$this->_vars['templates'] as $this->_vars['template']): ?>
		  <option value="<?php echo $this->_vars['template']['id']; ?>
" <?php if ($this->_vars['selected_template'] == $this->_vars['template']['id']): ?>selected="selected"<?php endif; ?>>[<?php echo $this->_vars['template']['id']; ?>
] <?php echo $this->_vars['template']['name']; ?>
</option>
		<?php endforeach; endif; ?>
	      </select>
		<?php else: ?>
		There are no templates created.  Please create one before adding responses.
		<?php endif; ?>
	      </td>
	    </tr>
	    <tr>
	      <td style = "text-align:right;vertical-align:top;">
		Course:
	      </td>
	      <td>				
		<?php if (count ( $this->_vars['courses'] ) > 0): ?>
		<select name = "course" class = "clickable small" id = "add-course">
		  <?php if (count((array)$this->_vars['courses'])): foreach ((array)$this->_vars['courses'] as $this->_vars['course']): ?>
		  <option value = "<?php echo $this->_vars['course']['id']; ?>
" <?php if ($this->_vars['selected_course'] == $this->_vars['course']['id']): ?>selected="selected"<?php endif; ?>>[<?php echo $this->_vars['course']['id']; ?>
] <?php echo $this->_vars['course']['name']; ?>
</option>
		<?php endforeach; endif; ?>
	      </select>
		<?php else: ?>
		There are no courses.  Please create one before adding responses.
		<?php endif; ?>
		<div class = "notice small">
				As online questionnaires/surveys/tests are created, a course will be required in the setup of the questionnaire/survey/test. As a result, you are advised to create a course at this point. A course can be literally a course (eg. PSY 200) or anything you would like to describe (eg. The name of a survey).
			</div>
	      </td>
	    </tr>
	    <tr>
	      <td style = "text-align:right;vertical-align:top;">
		Term:
	      </td>
	      <td>
	      	<input type = "radio" name = "term" value = "2" class = "radio" <?php if ($this->_vars['checked_term'] == 2): ?>checked = "checked"<?php endif; ?> id = "term_2" />
			<label for="term_2" class = "clickable">
		      Fall
		    </label><br />
		    <input type = "radio" name = "term" value = "3" class = "radio" <?php if ($this->_vars['checked_term'] == 3): ?>checked = "checked"<?php endif; ?> id = "term_3" />
			<label for="term_3" class = "clickable">
		      Winter
		    </label><br />
		    <input type = "radio" name = "term" value = "0" class = "radio" <?php if ($this->_vars['checked_term'] == 0): ?>checked = "checked"<?php endif; ?> id = "term_0" />
			<label for="term_0" class = "clickable">
		      Spring
		    </label><br />
		    <input type = "radio" name = "term" value = "1" class = "radio" <?php if ($this->_vars['checked_term'] == 1): ?>checked = "checked"<?php endif; ?> id = "term_1" />
			<label for="term_1" class = "clickable">
		      Summer
		    </label>
		
	      </td>
	    </tr>
	    <tr>
	      <td style = "text-align:right;vertical-align:top;">
		Type:
	      </td>
	      <td style = "text-align:left;">
		<?php if (count((array)$this->_vars['types'])): foreach ((array)$this->_vars['types'] as $this->_vars['type_id'] => $this->_vars['type']): ?>
		<input type = "radio" class = "radio" name = "type" value = "<?php echo $this->_vars['type_id']; ?>
" <?php if ($this->_vars['checked_type'] == $this->_vars['type_id']): ?>checked = "checked"<?php endif; ?> id = "type_<?php echo $this->_vars['type_id']; ?>
"/>
		<label for="type_<?php echo $this->_vars['type_id']; ?>
" class = "clickable"><?php echo $this->_vars['type']; ?>
</label><br />
		<?php endforeach; endif; ?>
	      </td>
	    </tr>
	    <tr>
	      <td>
		School Year:
	      </td> 
	      <td>
		<select name = "school_year" class = "clickable small" id = "add-school-year">
		  
		    <?php if (count((array)$this->_vars['years'])): foreach ((array)$this->_vars['years'] as $this->_vars['curr_year']): ?>
		  <option value = "<?php echo $this->_vars['curr_year']; ?>
" <?php if ($this->_vars['selected_school_year'] == $this->_vars['curr_year']): ?>selected="selected"<?php endif; ?>><?php echo $this->_vars['curr_year']; ?>
</option>
		<?php endforeach; endif; ?>
	      </select>
	      </td>
	    </tr>
	    <tr>
	      <td colspan = "2" style = "text-align:center;">
		<?php if (count ( $this->_vars['templates'] ) > 0 && count ( $this->_vars['courses'] ) > 0): ?>
		<input type = "submit" name = "add" value = "Add new response(s)..." class = "submit" id = "add-submit"/>
		<?php endif; ?>
		<input type = "reset" class = "submit" id = "add-cancel" value = "Cancel" />
	      </td>
	    </tr>
	  </table>
	</div>
      </div>
<?php endif; ?>

<script type = "text/javascript" src = "include/templates/js/responses.js"></script>
<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("foot.tpl", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
