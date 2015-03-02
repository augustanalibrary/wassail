<?php /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2014-04-22 11:56:38 MDT */ ?>



<?php if (is_array ( $this->_vars['entries'] )): ?>
      <table class = "list" style = "margin-left:40px;margin-bottom:20px;width:auto;">
	<tr class = "sub-header">
	  <td>
	    Course Name
	  </td>
	  <td>
	    Term
	  </td>
	  <td>
	    Type
	  </td>
	  <td>
	    Year
	  </td>
	  <td>
	    Responses
	  </td>
	</tr>
	<?php if (count((array)$this->_vars['entries'])): foreach ((array)$this->_vars['entries'] as $this->_vars['entry_index'] => $this->_vars['entry']): ?>
	<tr>
	  <td style = "vertical-align:top;text-align:left;">
	    [<?php echo $this->_vars['entry']['course_id']; ?>
] <?php echo $this->_vars['entry']['course_name']; ?>

	  </td>
	  <td style = "vertical-align:top;">
	    <?php echo $this->_vars['entry']['term']; ?>

	  </td>
	  <td style = "vertical-align:top;">
	    <?php echo $this->_vars['entry']['questionnaire_type']; ?>

	  </td>
	  <td style = "vertical-align:top;">
	    <?php echo $this->_vars['entry']['school_year']; ?>

	  </td>
	  <td style = "text-align:right;">
	  	<img src = "include/templates/images/printer.png" title = "Print all responses" alt = "Print all responses" class = "clickable responses_print" id = "print_<?php echo $this->_vars['entry']['template_id']; ?>
_<?php echo $this->_vars['entry']['course_id']; ?>
_<?php echo $this->_vars['entry']['term_id']; ?>
_<?php echo $this->_vars['entry']['questionnaire_type_id']; ?>
_<?php echo $this->_vars['entry']['school_year']; ?>
" />
	    <img src = "include/templates/images/eye.png" alt = "Click to show responses" title = "Click to show responses" onclick = "$('#numbers-<?php echo $this->_vars['id']; ?>
-<?php echo $this->_vars['entry_index']; ?>
').toggle();" class = "clickable"/>
	    <?php if ($this->_vars['right_write']): ?>
	    	<img src = "include/templates/images/bin.png" alt = "Click to delete responses" title = "Click to delete responses" onclick = "if(confirm('Are you sure you want to delete all the responses for this template/course/term/type/year combination?\n\nThis is not undo-able.'))deleteResponses(this,<?php echo $this->_vars['entry']['template_id']; ?>
,<?php echo $this->_vars['entry']['course_id']; ?>
,<?php echo $this->_vars['entry']['term_id']; ?>
,<?php echo $this->_vars['entry']['questionnaire_type_id']; ?>
,'<?php echo $this->_vars['entry']['school_year']; ?>
')" class = "clickable" />
	    <?php endif; ?>
	    <?php if ($this->_vars['right_write_unconditional']): ?>
	    	<img src = "include/templates/images/arrow-switch.png" alt = "Click to edit properties of all responses (course, term, etc.)" title = "Click to edit properties of all responses (course, term, etc.)" class = "clickable edit_response_properties" id = "edit_response_properties<?php if (count((array)$this->_vars['entry']['individual'])): foreach ((array)$this->_vars['entry']['individual'] as $this->_vars['number'] => $this->_vars['response_id']): ?>-<?php echo $this->_vars['response_id'];  endforeach; endif; ?>" />
	    <?php endif; ?>
	    <div id = "numbers-<?php echo $this->_vars['id']; ?>
-<?php echo $this->_vars['entry_index']; ?>
" style = "display:none;">
	      <?php if (count((array)$this->_vars['entry']['individual'])): foreach ((array)$this->_vars['entry']['individual'] as $this->_vars['number'] => $this->_vars['response_id']): ?>
	      <div id = "response-<?php echo $this->_vars['response_id']; ?>
" style = "vertical-align:middle;">
		<?php echo $this->_vars['number']; ?>

		<?php if ($this->_vars['right_write']): ?>
		<img src = "include/templates/images/pencil.png" title = "Edit response..." alt = "Edit response..." id = "edit_response_<?php echo $this->_vars['response_id']; ?>
" class = "response_edit clickable" style = "vertical-align:middle;"/>
		<img src = "include/templates/images/bin.png" title = "Delete response" alt = "Delete response" id = "delete-response-<?php echo $this->_vars['response_id']; ?>
" class = "response_delete clickable" style = "vertical-align:middle;" />
	      
	      <?php endif; ?>
	      <?php if ($this->_vars['right_write_unconditional']): ?>
	    	<img src = "include/templates/images/arrow-switch.png" alt = "Click to edit properties of this response (course, term, etc.)" title = "Click to edit properties of this response (course, term, etc.)" class = "clickable edit_response_properties" style = "vertical-align:middle" id = "edit_response_properties-<?php echo $this->_vars['response_id']; ?>
"/>
	    	<?php endif; ?>
	      </div>
	      
	      <?php endforeach; endif; ?>
	    </div>
	  </td>
	  <?php endforeach; endif; ?>
      </table>
<script type = "text/javascript">
addAJAXListeners();
</script>
<?php endif; ?>