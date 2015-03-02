<?php require_once('/var/www/htdocs/include/template_lite/plugins/modifier.count_characters.php'); $this->register_modifier("count_characters", "tpl_modifier_count_characters");  require_once('/var/www/htdocs/include/template_lite/plugins/modifier.escape.php'); $this->register_modifier("escape", "tpl_modifier_escape");  require_once('/var/www/htdocs/include/template_lite/plugins/function.counter.php'); $this->register_function("counter", "tpl_function_counter");  /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2015-02-17 10:21:17 MST */ ?>

<?php $this->assign('no_tooltip_load', TRUE);  $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("head.tpl", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>


<script type = "text/javascript" src = "<?php echo constant('WEB_PATH'); ?>
include/tinyMCE/tiny_mce.js"></script>
	<script type = "text/javascript">
	<?php echo '
tinyMCE.init({
      mode : "textareas",
      theme : "advanced",
      plugins : "nbspfix,paste",
	  preformatted: true,
      theme_advanced_toolbar_location : "top",
      theme_advanced_toolbar_align : "left",
	  //if these change to allow new html tags, the HTMLPurifier call in responsequestion.php will also have to be updated
      theme_advanced_buttons1 : "bold,italic,underline,undo,redo,selectall,removeformat",
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
		$(tinyMCE.selectedInstance.formElement).siblings(\'input[type=checkbox]\').attr(\'checked\',false);
	}
}
'; ?>

</script>


    <h1 style = "text-align:center;">
      <?php echo $this->_vars['template_name']; ?>

    </h1>
	<?php if (isset ( $this->_vars['success'] )): ?>
		<div class = "<?php if ($this->_vars['success']): ?>success<?php else: ?>error<?php endif; ?>">
		  <?php echo $this->_vars['message']; ?>

		</div>
		<br />
	<?php endif; ?>
    <form method = 'post' action = "<?php echo constant('WEB_PATH'); ?>
form/<?php echo $this->_vars['id']; ?>
/" enctype="multipart/form-data">
    <table class = "web-form-table" style = "margin-left:auto;margin-right:auto;">
      <?php echo tpl_function_counter(array('print' => false,'assign' => "counter"), $this);?>
      <?php if (count((array)$this->_vars['questions'])): foreach ((array)$this->_vars['questions'] as $this->_vars['question_id'] => $this->_vars['properties']): ?>
	<?php $this->assign('question_field', "q_".$this->_vars['question_id']); ?>
      <tr class = "<?php if ((1 & $this->_vars['counter'])): ?>odd<?php else: ?>even<?php endif; ?>">
	<td style = "text-align:right;vertical-align:top;padding-top:15px;">
	  <?php echo $this->_vars['counter']; ?>
)
	</td>
	
	
	<?php if ($this->_vars['properties']['type'] == 'qualitative' && $this->_vars['properties']['qualitative_type'] == 'long'): ?>
		<td colspan = "2" style = "vertical-align:top;padding-top:15px;">
			<?php echo $this->_vars['properties']['text']; ?>

		</td>
		</tr>
		<tr class = "<?php if ((1 & $this->_vars['counter'])): ?>odd<?php else: ?>even<?php endif; ?>">
		<td>
		<!-- filler cell below question number -->
		</td>
		<td colspan = "2" style = "padding-bottom:15px;">
				<textarea name = "q_<?php echo $this->_vars['question_id']; ?>
" cols = "159" rows = "4" class = "<?php echo $this->_vars['question_id']; ?>
_text textarea" style = "height:100px;"><?php if (isset ( $_POST[$this->_vars['question_field']] ) && $_POST[$this->_vars['question_field']] != '0'):  echo $this->_run_modifier($_POST[$this->_vars['question_field']], 'escape', 'plugin', 1, "post");  endif; ?></textarea>
	<?php else: ?>
		<td style = "vertical-align:top;padding-bottom:15px;padding-top:15px;">
		  <?php echo $this->_vars['properties']['text']; ?>

		</td>
		<td style = "padding-bottom:15px;padding-top:15px;">
	
		  
		  <?php if ($this->_vars['properties']['type'] == 'single' && isset ( $this->_vars['properties']['answers'] )): ?>
			  <?php if (count((array)$this->_vars['properties']['answers'])): foreach ((array)$this->_vars['properties']['answers'] as $this->_vars['answer_id'] => $this->_vars['answer_text']): ?>
			  <input type = "radio" 
				  name = "q_<?php echo $this->_vars['question_id']; ?>
" 
				  value = "<?php echo $this->_vars['answer_id']; ?>
" 
				  id = "q_<?php echo $this->_vars['question_id'];  echo $this->_vars['answer_id']; ?>
" 
				  class = "clickable radio answer <?php echo $this->_vars['question_id']; ?>
"
				  <?php if (isset ( $_POST[$this->_vars['question_field']] ) && $_POST[$this->_vars['question_field']] == $this->_vars['answer_id']): ?>checked="checked"<?php endif; ?>/>
			  <label for="q_<?php echo $this->_vars['question_id'];  echo $this->_vars['answer_id']; ?>
" class = "clickable">
				<?php echo $this->_vars['answer_text']; ?>

			  </label>
			  <br />
			  <?php endforeach; endif; ?>
		  
		  
		  <?php elseif ($this->_vars['properties']['type'] == 'multiple'): ?>
			  <?php if (count((array)$this->_vars['properties']['answers'])): foreach ((array)$this->_vars['properties']['answers'] as $this->_vars['answer_id'] => $this->_vars['answer_text']): ?>
			  <input type = "checkbox" 
				  name = "q_<?php echo $this->_vars['question_id']; ?>
[]" 
				  value = "<?php echo $this->_vars['answer_id']; ?>
" 
				  id = "q_<?php echo $this->_vars['question_id'];  echo $this->_vars['answer_id']; ?>
" 
				  class = "clickable radio answer <?php echo $this->_vars['question_id']; ?>
"
				<?php if (isset ( $_POST[$this->_vars['question_field']] ) && is_array ( $_POST[$this->_vars['question_field']] ) && in_array ( $this->_vars['answer_id'] , $_POST[$this->_vars['question_field']] )): ?>checked="checked"<?php endif; ?> />
			  <label for="q_<?php echo $this->_vars['question_id'];  echo $this->_vars['answer_id']; ?>
" class = "clickable">
				<?php echo $this->_vars['answer_text']; ?>

			  </label>
			  <br />
			  <?php endforeach; endif; ?>
		  
		  
		  	<?php elseif ($this->_vars['properties']['type'] == 'qualitative'): ?>
				<input type = "text" name = "q_<?php echo $this->_vars['question_id']; ?>
" class = "<?php echo $this->_vars['question_id']; ?>
_text" value = "<?php if (isset ( $_POST[$this->_vars['question_field']] ) && $_POST[$this->_vars['question_field']] != '0'):  echo $this->_run_modifier($_POST[$this->_vars['question_field']], 'escape', 'plugin', 1, "post");  endif; ?>" style = "width:100%;" />
			<?php endif; ?>
		<?php endif; ?>
			<?php if ($this->_run_modifier($this->_vars['properties']['opt_out'], 'count_characters', 'plugin', 1, true) > 0): ?>
				<?php if ($this->_vars['properties']['type'] == 'qualitative'): ?>
					<br />
					<input type = "checkbox" 
					  name = "q_<?php echo $this->_vars['question_id']; ?>
" 
					  class = "no_answer radio clickable" 
					  value="0" 
					  id = "no_answer_<?php echo $this->_vars['question_id']; ?>
"
					<?php if (isset ( $_POST[$this->_vars['question_field']] ) && $_POST[$this->_vars['question_field']] == '0'): ?>checked="checked"<?php endif; ?>/>
	
					<label for = "no_answer_<?php echo $this->_vars['question_id']; ?>
" class = "clickable">
					  <?php echo $this->_vars['properties']['opt_out']; ?>

					</label>	
				<?php endif; ?>
			<?php endif; ?>
		</td>
      </tr>
      <?php echo tpl_function_counter(array(), $this);?>
	<?php endforeach; endif; ?>
	 
	<?php if ($this->_vars['file_request']): ?>
		<tr style = "border-top:1px solid #CCC;border-bottom:1px solid #CCC;">
			<td>
			</td>
			<td style = "padding-top:10px;padding-bottom:20px;">
				<?php echo $this->_vars['file_request']; ?>

			</td>
			<td style = "padding-top:20px;">
				<input type="hidden" name="MAX_FILE_SIZE" value="1000000000" /><!-- 1 GB should be larger than any practical upload file size limit -->
				<?php for($for1 = 0; ((0 < $this->_vars['file_count']) ? ($for1 < $this->_vars['file_count']) : ($for1 > $this->_vars['file_count'])); $for1 += ((0 < $this->_vars['file_count']) ? 1 : -1)): ?>
					<span class = "upload-wrapper">
						<input type = "file" name = "userfile[]" />
					</span>
					<input type = "submit" class = "submit hidden upload-clear" value = "Clear" />
					<br />
				<?php endfor; ?>
				<div class = "notice small">
					Files must be smaller than <?php echo $this->_vars['upload_max_filesize']; ?>

				</div>
			</td>
		</tr>
	<?php endif; ?>
	
      <tr>
	<td colspan = "3" style = "text-align:center;">
	    <input type = "submit" name = "print" class = "submit" value = "Print form" onClick = "window.print();return false;" />
	  <input type = "submit" name = "submit" class = "submit" value = "Submit questionnaire" style = "font-weight:bold;"/>
	  <br />
	  <br />
	</td>
      </tr>
    </table>
  </form>
<script type = "text/javascript">
<!--
<?php echo '
	/* Uncheck possible answers if user chooses \'I prefer not to answer\' */
	$(".no_answer").click(function(){
		var id = $(this).attr(\'name\').substring(2);
		$(\'.\'+id).attr(\'checked\',false);
		$(\'.\'+id+\'[]\').attr(\'checked\',false);
		
		var rteParent = $(this).siblings(\'span.mceEditorContainer\');
		if(rteParent.length > 0)
		{
			var parentID = rteParent.attr(\'id\');
			var editorID = parentID.substring(0,parentID.length - 7);
			tinyMCE.getInstanceById(editorID).setHTML(\'\');
		}
		
		if($(this).siblings(\'input[type=text]\').length > 0)
		{
			$(this).siblings(\'input[type=text]\').val(\'\');
		}
	});
	
	/* Uncheck \'I prefer not to answer\' if user chooses an answer */
	$(".answer").click(function(){
				var id = $(this).attr(\'name\').substring(2);
	
				/* Strip \'[]\' if necessary */
				if(id.indexOf(\'[\') != -1)
				  id = id.substring(0,id.length-2);
				$("#no_answer_"+id).attr(\'checked\',false);
			  });
	
	/* Uncheck \'I prefer not to answer\' if the user types qualitative text */
	$(".textarea, input[type=text]").keydown(function(){
			   var id = $(this).attr(\'name\').substring(2);
			   $("#no_answer_"+id).attr(\'checked\',false);
			 });
	
	/* File upload "clear" button
	   Since the file input element can\'t be accessed with Javascript, the "clear" button just overwrites part of the DOM,
	   essentially removing the old, populated element & adding a new, empty element.
	*/
	
	$(".upload-clear").removeClass(\'hidden\').click(function(){
		$(this).siblings(\'.upload-wrapper\').html(\'<input type = "file" name = "userfile[]" />\');
		return false;
	})

'; ?>

-->
</script>    
<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("foot.tpl", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
