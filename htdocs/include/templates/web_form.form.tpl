{ assign var="no_tooltip_load" value=TRUE }
{include file="head.tpl"}


<script type = "text/javascript" src = "{ $templatelite.CONST.WEB_PATH }include/tinyMCE/tiny_mce.js"></script>
	<script type = "text/javascript">
	{literal}
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
	if(e.type == 'keyup')
	{
		$(tinyMCE.selectedInstance.formElement).siblings('input[type=checkbox]').attr('checked',false);
	}
}
{/literal}
</script>


    <h1 style = "text-align:center;">
      {$template_name}
    </h1>
	{if isset($success)}
		<div class = "{if $success}success{else}error{/if}">
		  {$message}
		</div>
		<br />
	{/if}
    <form method = 'post' action = "{$templatelite.CONST.WEB_PATH}form/{$id}/" enctype="multipart/form-data">
    <table class = "web-form-table" style = "margin-left:auto;margin-right:auto;">
      {counter print=false assign="counter"}
      {foreach from=$questions key=question_id value=properties}
	{assign var="question_field" value="q_".$question_id}
      <tr class = "{if $counter is odd}odd{else}even{/if}">
	<td style = "text-align:right;vertical-align:top;padding-top:15px;">
	  {$counter})
	</td>
	
	{* Long qualitative questions get a special layout *}
	{ if $properties.type eq 'qualitative' and $properties.qualitative_type == 'long' }
		<td colspan = "2" style = "vertical-align:top;padding-top:15px;">
			{$properties.text}
		</td>
		</tr>
		<tr class = "{if $counter is odd}odd{else}even{/if}">
		<td>
		<!-- filler cell below question number -->
		</td>
		<td colspan = "2" style = "padding-bottom:15px;">
				<textarea name = "q_{$question_id}" cols = "159" rows = "4" class = "{$question_id}_text textarea" style = "height:100px;">{if isset($templatelite[POST][$question_field]) and $templatelite[POST][$question_field] != '0'}{$templatelite[POST][$question_field]|escape:"post"}{/if}</textarea>
	{ else }
		<td style = "vertical-align:top;padding-bottom:15px;padding-top:15px;">
		  {$properties.text}
		</td>
		<td style = "padding-bottom:15px;padding-top:15px;">
	
		  {* Single answer questions *}
		  {if $properties.type eq 'single' and isset($properties.answers)}
			  {foreach from=$properties.answers key=answer_id value=answer_text}
			  <input type = "radio" 
				  name = "q_{$question_id}" 
				  value = "{$answer_id}" 
				  id = "q_{$question_id}{$answer_id}" 
				  class = "clickable radio answer {$question_id}"
				  {if isset($templatelite[POST][$question_field]) and $templatelite[POST][$question_field] eq $answer_id}checked="checked"{/if}/>
			  <label for="q_{$question_id}{$answer_id}" class = "clickable">
				{$answer_text}
			  </label>
			  <br />
			  {/foreach}
		  
		  {* Multiple answer questions *}
		  {elseif $properties.type eq 'multiple'}
			  {foreach from=$properties.answers key=answer_id value=answer_text}
			  <input type = "checkbox" 
				  name = "q_{$question_id}[]" 
				  value = "{$answer_id}" 
				  id = "q_{$question_id}{$answer_id}" 
				  class = "clickable radio answer {$question_id}"
				{if isset($templatelite[POST][$question_field]) and is_array($templatelite[POST][$question_field]) and in_array($answer_id,$templatelite[POST][$question_field])}checked="checked"{/if} />
			  <label for="q_{$question_id}{$answer_id}" class = "clickable">
				{$answer_text}
			  </label>
			  <br />
			  {/foreach}
		  
		  {* Qualitative answer questions.  Long format is handled above *}
		  	{elseif $properties.type eq 'qualitative'}
				<input type = "text" name = "q_{$question_id}" class = "{$question_id}_text" value = "{if isset($templatelite[POST][$question_field]) and $templatelite[POST][$question_field] != '0'}{$templatelite[POST][$question_field]|escape:"post"}{/if}" style = "width:100%;" />
			{ /if }
		{/if}
			{ if $properties.opt_out|count_characters:true gt 0 }
				{ if $properties.type eq 'qualitative' }
					<br />
					<input type = "checkbox" 
					  name = "q_{$question_id}" 
					  class = "no_answer radio clickable" 
					  value="0" 
					  id = "no_answer_{$question_id}"
					{if isset($templatelite[POST][$question_field]) and $templatelite[POST][$question_field] eq '0'}checked="checked"{/if}/>
	
					<label for = "no_answer_{$question_id}" class = "clickable">
					  { $properties.opt_out }
					</label>	
				{ /if }
			{ /if }
		</td>
      </tr>
      {counter}
	{/foreach}
	 
	{ if $file_request }
		<tr style = "border-top:1px solid #CCC;border-bottom:1px solid #CCC;">
			<td>
			</td>
			<td style = "padding-top:10px;padding-bottom:20px;">
				{ $file_request }
			</td>
			<td style = "padding-top:20px;">
				<input type="hidden" name="MAX_FILE_SIZE" value="1000000000" /><!-- 1 GB should be larger than any practical upload file size limit -->
				{for start = 0 stop=$file_count step=1 }
					<span class = "upload-wrapper">
						<input type = "file" name = "userfile[]" />
					</span>
					<input type = "submit" class = "submit hidden upload-clear" value = "Clear" />
					<br />
				{ /for }
				<div class = "notice small">
					Files must be smaller than { $upload_max_filesize }
				</div>
			</td>
		</tr>
	{ /if }
	
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
{literal}
	/* Uncheck possible answers if user chooses 'I prefer not to answer' */
	$(".no_answer").click(function(){
		var id = $(this).attr('name').substring(2);
		$('.'+id).attr('checked',false);
		$('.'+id+'[]').attr('checked',false);
		
		var rteParent = $(this).siblings('span.mceEditorContainer');
		if(rteParent.length > 0)
		{
			var parentID = rteParent.attr('id');
			var editorID = parentID.substring(0,parentID.length - 7);
			tinyMCE.getInstanceById(editorID).setHTML('');
		}
		
		if($(this).siblings('input[type=text]').length > 0)
		{
			$(this).siblings('input[type=text]').val('');
		}
	});
	
	/* Uncheck 'I prefer not to answer' if user chooses an answer */
	$(".answer").click(function(){
				var id = $(this).attr('name').substring(2);
	
				/* Strip '[]' if necessary */
				if(id.indexOf('[') != -1)
				  id = id.substring(0,id.length-2);
				$("#no_answer_"+id).attr('checked',false);
			  });
	
	/* Uncheck 'I prefer not to answer' if the user types qualitative text */
	$(".textarea, input[type=text]").keydown(function(){
			   var id = $(this).attr('name').substring(2);
			   $("#no_answer_"+id).attr('checked',false);
			 });
	
	/* File upload "clear" button
	   Since the file input element can't be accessed with Javascript, the "clear" button just overwrites part of the DOM,
	   essentially removing the old, populated element & adding a new, empty element.
	*/
	
	$(".upload-clear").removeClass('hidden').click(function(){
		$(this).siblings('.upload-wrapper').html('<input type = "file" name = "userfile[]" />');
		return false;
	})

{/literal}
-->
</script>    
{include file="foot.tpl"}
