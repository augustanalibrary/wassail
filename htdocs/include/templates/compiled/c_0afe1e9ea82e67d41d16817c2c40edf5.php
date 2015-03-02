<?php require_once('/var/www/htdocs/include/template_lite/plugins/function.math.php'); $this->register_function("math", "tpl_function_math");  require_once('/var/www/htdocs/include/template_lite/plugins/modifier.escape.php'); $this->register_modifier("escape", "tpl_modifier_escape");  /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2015-01-13 15:19:58 MST */ ?>

<?php if (! isset ( $this->_vars['inline'] ) || $this->_vars['inline'] == FALSE): ?>
	<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("head.popup.tpl", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
  endif; ?>

<?php if (! isset ( $this->_vars['inline'] ) || $this->_vars['inline'] == FALSE): ?>
<script type = "text/javascript" src = "include/tinyMCE/tiny_mce.js"></script>
	<script type = "text/javascript">

	<?php echo '
tinyMCE.init({
      mode : "specific_textareas",
	  editor_selector:"tinymce_replace",
      theme : "advanced",
      plugins : "nbspfix",
	  preformatted:false,
      theme_advanced_toolbar_location : "top",
      theme_advanced_toolbar_align : "left",
 	  //if these change, the HTMLPurifier call in responsequestion.php will also have to be updated
      theme_advanced_buttons1 : "undo,redo,bold,italic,underline,fullscreen",
      theme_advanced_buttons2 : "",
      theme_advanced_buttons3 : "",
      convert_fonts_to_spans : true,
      content_css: "/include/templates/editor.css",
      handle_event_callback:"listenForEditorChanges",
      force_br_newlines:true,
      cleanup_on_startup : true,
      gecko_spellcheck:true,
      inline_styles : true
});
function listenForEditorChanges(e){
	if(e.type == \'keyup\')
	{
		$(tinyMCE.selectedInstance.formElement).parent().siblings(\'div\').find(\'input[type=checkbox]\').attr(\'checked\',false);
	}
}
'; ?>


</script>
<?php endif; ?>



<?php if (isset ( $this->_vars['success'] )): ?>
      <div class = "<?php if ($this->_vars['success'] == TRUE): ?>success<?php else: ?>error<?php endif; ?>">
	<?php echo $this->_vars['message']; ?>

      </div>
<?php endif; ?>




<?php if (isset ( $this->_vars['error_fields'] )): ?>
<div class = "error">
	Each question must either have a student answer supplied, or have the appropriate "Student provided no response" checkbox checked.
</div>
<?php endif; ?>



<?php if (! isset ( $this->_vars['inline'] ) || $this->_vars['inline'] == FALSE): ?>
<div class = "small">
<strong><?php echo $this->_vars['template_name']; ?>
</strong> &bull; <strong><?php echo $this->_vars['course_name']; ?>
</strong> &bull; <strong><?php echo $this->_vars['term']; ?>
</strong> &bull; <strong><?php echo $this->_vars['type']; ?>
</strong> &bull; <strong><?php echo $this->_vars['year']; ?>
</strong>
</div>
<?php endif;  if (count ( $this->_vars['questions'] ) > 0): ?>
<form method = "post" action = "<?php echo $this->_run_modifier($_SERVER['REQUEST_URI'], 'escape', 'plugin', 1, "html"); ?>
" enctype="multipart/form-data">
<div class = "small" style = "margin-top:10px;margin-bottom:10px;">
<strong>Number:</strong> <input type = "text" name = "number" class = "input-field" size = "3" maxlength = "11" value = "<?php echo $this->_run_modifier($this->_vars['number'], 'escape', 'plugin', 1); ?>
" id = "number-field"/>
</div>
      <table class = "list">

	
	
	<?php if (count((array)$this->_vars['questions'])): foreach ((array)$this->_vars['questions'] as $this->_vars['position'] => $this->_vars['question']): ?>
	<?php $this->assign('answer_name', "answer_".$this->_vars['question']['id']); ?>
	<tr class = "<?php if (!(1 & $this->_vars['position'])): ?>even<?php else: ?>odd<?php endif; ?> <?php if (isset ( $this->_vars['error_fields'] ) && ( in_array ( $this->_vars['answer_name'] , $this->_vars['error_fields'] ) )): ?>input-highlight<?php endif; ?>">
	  <td style = "vertical-align:top;">
	    <input type = "hidden" name = "question_order[]" value = "<?php echo $this->_vars['question']['id']; ?>
" />
	    <?php echo tpl_function_math(array('equation' => "x+1",'x' => $this->_vars['position']), $this);?>)
	  </td>
	  <td style = "vertical-align:top;text-align:left;">
	    <?php echo $this->_vars['question']['text']; ?>

	  </td>
	  <td style = "vertical-align:top;text-align:left;min-width:250px;">

	    
	    
	    <?php if ($this->_vars['question']['type'] == "qualitative"): ?>
		<div class = "no_print">
	     <textarea rows = "5" cols = "40" name = "answer_<?php echo $this->_vars['question']['id']; ?>
" class = "answer_<?php echo $this->_vars['question']['id']; ?>
_text textarea no_print <?php if ($this->_vars['question']['qualitative_type'] == "long"): ?> tinymce_replace<?php endif; ?>"><?php if (isset ( $this->_vars['question']['answers'] )):  echo $this->_vars['question']['answers'];  endif; ?></textarea>
		</div>
		 <div class = "for_print" style = "width:280px;"><?php if (isset ( $this->_vars['question']['answers'] )):  echo $this->_vars['question']['answers'];  endif; ?></div>
		 <?php if (strlen ( $this->_vars['question']['opt_out'] )): ?>
			<div title = "Checking this box will override any other answer for this question">
				<input type = "checkbox" name = "no_answer_<?php echo $this->_vars['question']['id']; ?>
" class = "no_answer" id = "no_answer<?php echo $this->_vars['question']['id']; ?>
" <?php if (isset ( $this->_vars['question']['no_answer_checked'] )): ?>checked="checked"<?php endif; ?>/><label for = "no_answer<?php echo $this->_vars['question']['id']; ?>
"><strong><?php echo $this->_vars['question']['opt_out']; ?>
</strong></label>
			</div>
		<?php endif; ?>
	    <?php elseif (isset ( $this->_vars['question']['answers'] )): ?>
	     <?php if (count((array)$this->_vars['question']['answers'])): foreach ((array)$this->_vars['question']['answers'] as $this->_vars['answer_id'] => $this->_vars['answer']): ?>
	    
	      
	      
	      <?php if ($this->_vars['question']['type'] == "single"): ?>
	       <?php $this->assign('type', "radio"); ?>
	       <?php $this->assign('name', "answer_".$this->_vars['question']['id']); ?>
	       <?php $this->assign('class', "answer radio ".$this->_vars['question']['id']); ?>
	       <?php $this->assign('element_id', "answer_".$this->_vars['question']['id']."".$this->_vars['answer_id']); ?>

	      
	      
	      <?php elseif ($this->_vars['question']['type'] == "multiple"): ?>
	       <?php $this->assign('type', "checkbox"); ?>
	       <?php $this->assign('name', "answer_".$this->_vars['question']['id']."[]"); ?>
	       <?php $this->assign('class', "answer radio ".$this->_vars['question']['id']); ?>
	       <?php $this->assign('element_id', "answer_".$this->_vars['question']['id']."".$this->_vars['answer_id']); ?>
	      <?php endif; ?>

	      
	      
	      <?php if (isset ( $this->_vars['answer']['checked'] )): ?>
	       <?php $this->assign('checked', 'checked = "checked"'); ?>
	      <?php else: ?>
	       <?php $this->assign('checked', ''); ?>
	      <?php endif; ?>
	      <input type="<?php echo $this->_vars['type']; ?>
" name = "<?php echo $this->_vars['name']; ?>
" value = "<?php echo $this->_vars['answer_id']; ?>
" class = "<?php echo $this->_vars['class']; ?>
" id = "<?php echo $this->_vars['element_id']; ?>
" <?php echo $this->_vars['checked']; ?>
 /><label for = "<?php echo $this->_vars['element_id']; ?>
" style = "margin-left:10px;"><?php echo $this->_vars['answer']['text']; ?>
</label><br />
	     <?php endforeach; endif; ?>
		 <?php if (strlen ( $this->_vars['question']['opt_out'] )): ?>
			<div title = "Checking this box will override any other answer for this question">
				<input type = "checkbox" name = "no_answer_<?php echo $this->_vars['question']['id']; ?>
" class = "no_answer" id = "no_answer<?php echo $this->_vars['question']['id']; ?>
" <?php if (isset ( $this->_vars['question']['no_answer_checked'] )): ?>checked="checked"<?php endif; ?>/><label for = "no_answer<?php echo $this->_vars['question']['id']; ?>
"><strong>No response was provided</strong></label>
			</div>
		<?php endif; ?>
	    <?php else: ?>
	    No possible answers
	    <?php endif; ?>
	  </td>
	</tr>
	<?php endforeach; endif; ?>
      </table>
    <?php if ($this->_vars['possible_correct'] != 0): ?>
    	<strong>Correct:</strong> <?php echo $this->_vars['actual_correct']; ?>
 / <?php echo $this->_vars['possible_correct']; ?>
 (<?php echo $this->_vars['correct_percent']; ?>
%) <small><em>[This only considers questions for which a correct answer has been indicated]</em></small>
    <?php endif; ?>
	<?php if ($this->_vars['files']): ?>
		<p>
			<h4 style = "margin-bottom:5px;">
				Uploaded file(s):
			</h4>
			<?php if (count((array)$this->_vars['files'])): foreach ((array)$this->_vars['files'] as $this->_vars['filename']): ?>
				<button type = "submit" name = "delete_file" value = "<?php echo $this->_vars['filename']; ?>
" class = "submit">Delete</button> <a href = "<?php echo constant('WEB_PATH'); ?>
file_proxy.php?file=<?php echo $this->_vars['filename']; ?>
"><?php echo $this->_vars['filename']; ?>
</a><br />
			<?php endforeach; endif; ?>
		</p>
	<?php endif; ?>	
	<br />
		<input type = "file" name = "new_response_file" /><input type = "submit" name = "upload" value = "Upload new file" class = "submit"/>
	<br />

	<?php if (! isset ( $this->_vars['read_only'] ) || $this->_vars['read_only'] == FALSE): ?>
	      <div style = "text-align:right;">
		<?php if (isset ( $_GET['load'] )): ?>
		<input type = "submit" name = "edit" value = "Save and close" title = "Click this button to save the changes you've made to this response" class = "submit" />
		<?php else: ?>
		<input type = "submit" name = "add_again" value = "Save and enter another response" title = "Click this button to add this response &lt;br /&gt;&amp; show this form again to add another response" class = "submit" />
		<input type = "submit" name = "add_close" value = "Save and close" title = "Click this button to add this response &amp; close the window" class = "submit" />
		<input type = "submit" name = "cancel" value = "Cancel" title = "Click to close this window" class = "submit" onclick = "window.close();return false;" />
		<?php endif; ?>
	      </div>
	<?php endif; ?>
      </form>
<?php endif;  if (! isset ( $this->_vars['inline'] ) || $this->_vars['inline'] == FALSE): ?>
<script type = "text/javascript">
<?php echo '
/* Uncheck possible answers if user chooses \'No student provided response\' */
$(".no_answer").click(function(){
			var id = $(this).attr(\'name\').substring(10);
			$(\'.\'+id).attr(\'checked\',false);
			$(\'.answer_\'+id+\'_text\').val(\'\');

		var rteParent = $(this).parent().siblings(\'div.no_print\').children(\'span.mceEditorContainer\');
		if(rteParent.length > 0)
		{
			var parentID = rteParent.attr(\'id\');
			var editorID = parentID.substring(0,parentID.length - 7);
			tinyMCE.getInstanceById(editorID).setHTML(\'\');
		}


});


/* Uncheck \'No student provided response\' if user chooses an answer */
$(".answer").click(function(){
		     var id = $(this).attr(\'name\').substring(7);
		     if(id.indexOf(\'[\') != -1)
		       id = id.substring(0,id.length-id.indexOf(\'[\') + 1);
		     $("#no_answer"+id).attr(\'checked\',false);
		   });
		     

/* Uncheck \'No student provided response\' if user chooses an answer */
$(".textarea").keydown(function(){
			 var id = $(this).attr(\'name\').substring(7);
			 $("#no_answer"+id).attr(\'checked\',false);
		       });

/* Auto grow textareas */
$("textarea").each(function(){    
		     if(this.scrollHeight > this.clientHeight)
		       this.style.height = this.scrollHeight+\'px\';
		   });
/* update the "for print" div whenever a textarea is updated */
$("textarea").change(function(){
	$("div.for_print",$(this).parent().parent()).html($(this).val());	
});

$("#number-field").keydown(function(e){
			     /* First line is numbers.
				Second line is number pad numbers
				Third line is backspace
				Fourth line is delete
				Fifth line is arrows
			     */
			     if((e.keyCode >= 48 && e.keyCode <= 57) ||
				(e.keyCode >= 96 && e.keyCode <= 105) ||
				e.keyCode == 8 ||
				e.keyCode == 46 ||
				(e.keyCode >= 37 && e.keyCode <= 40))
			       return true;
			     else
			       return false;
			   });
			     

'; ?>

</script>

<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("foot.popup.tpl", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
  endif; ?>