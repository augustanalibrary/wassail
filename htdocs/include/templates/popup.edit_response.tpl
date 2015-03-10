{if !isset($inline) OR $inline eq FALSE }
	{include file="head.popup.tpl"}
{/if}

{if !isset($inline) OR $inline eq FALSE }
<script type = "text/javascript" src = "include/tinyMCE/tiny_mce.js"></script>
	<script type = "text/javascript">

	{literal}
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
	if(e.type == 'keyup')
	{
		$(tinyMCE.selectedInstance.formElement).parent().siblings('div').find('input[type=checkbox]').attr('checked',false);
	}
}
{/literal}

</script>
{/if}

{* ****************************************** *}
{* Display any general success/error messages *}
{if isset($success)}
      <div class = "{if $success eq TRUE}success{else}error{/if}">
	{$message}
      </div>
{/if}


{* ************************************************************** *}
{* Display a specific error if there was a problem with form data *}
{if isset($error_fields)}
<div class = "error">
	Each question must either have a student answer supplied, or have the appropriate "Student provided no response" checkbox checked.
</div>
{/if}

{* ******************************* *}
{* Display the response properties *}
{if !isset($inline) OR $inline eq FALSE }
<div class = "small">
<strong>{$template_name}</strong> &bull; <strong>{$course_name}</strong> &bull; <strong>{$term}</strong> &bull; <strong>{$type}</strong> &bull; <strong>{$year}</strong>
</div>
{/if}
{if count($questions) gt 0}
<form method = "post" action = "{$templatelite.SERVER.REQUEST_URI|escape:"html"}" enctype="multipart/form-data">
<div class = "small" style = "margin-top:10px;margin-bottom:10px;">
<strong>Number:</strong> <input type = "text" name = "number" class = "input-field" size = "3" maxlength = "11" value = "{$number|escape}" id = "number-field"/>
</div>
      <table class = "list">

	{* ******************************** *}
	{* Make a new row for each question *}
	{foreach from=$questions key=position value=question}
	{assign var="answer_name" value="answer_".$question.id}
	<tr class = "{if $position is even}even{else}odd{/if} {if isset($error_fields) and (in_array($answer_name,$error_fields))}input-highlight{/if}">
	  <td style = "vertical-align:top;">
	    <input type = "hidden" name = "question_order[]" value = "{$question.id}" />
	    {math equation="x+1" x=$position})
	  </td>
	  <td style = "vertical-align:top;text-align:left;">
	    {$question.text}
	  </td>
	  <td style = "vertical-align:top;text-align:left;min-width:250px;">

	    {* ******************************************************** *}
	    {* Output a simple textfield if the question is qualitative *}
	    {if $question.type eq "qualitative"}
		<div class = "no_print">
	     <textarea rows = "5" cols = "40" name = "answer_{$question.id}" class = "answer_{$question.id}_text textarea no_print {if $question.qualitative_type eq "long"} tinymce_replace{ /if }">{if isset($question.answers)}{$question.answers}{/if}</textarea>
		</div>
		 <div class = "for_print" style = "width:280px;">{if isset($question.answers)}{$question.answers}{/if}</div>
		 { if strlen($question.opt_out) }
			<div title = "Checking this box will override any other answer for this question">
				<input type = "checkbox" name = "no_answer_{$question.id}" class = "no_answer" id = "no_answer{$question.id}" {if isset($question.no_answer_checked)}checked="checked"{/if}/><label for = "no_answer{$question.id}"><strong>{$question.opt_out}</strong></label>
			</div>
		{ /if }
	    {elseif isset($question.answers)}
	     {foreach from=$question.answers key=answer_id value=answer}
	    
	      {* *************************************************** *}
	      {* Set some variables if the question is single answer *}
	      {if $question.type eq "single"}
	       {assign var="type" value = "radio"}
	       {assign var="name" value = "answer_".$question.id}
	       {assign var="class" value = "answer radio ".$question.id}
	       {assign var="element_id" value = "answer_".$question.id."".$answer_id}

	      {* ***************************************************** *}
	      {* Set some variables if the question is multiple answer *}
	      {elseif $question.type eq "multiple"}
	       {assign var="type" value = "checkbox"}
	       {assign var="name" value = "answer_".$question.id."[]"}
	       {assign var="class" value = "answer radio ".$question.id}
	       {assign var="element_id" value = "answer_".$question.id."".$answer_id}
	      {/if}

	      {* ****************** *}
	      {* Set checked status *}
	      {if isset($answer.checked)}
	       {assign var="checked" value = 'checked = "checked"'}
	      {else}
	       {assign var="checked" value = ''}
	      {/if}
	      <input type="{$type}" name = "{$name}" value = "{$answer_id}" class = "{$class}" id = "{$element_id}" {$checked} /><label for = "{$element_id}" style = "margin-left:10px;">{$answer.text}</label><br />
	     {/foreach}
		 { if strlen($question.opt_out) }
			<div title = "Checking this box will override any other answer for this question">
				<input type = "checkbox" name = "no_answer_{$question.id}" class = "no_answer" id = "no_answer{$question.id}" {if isset($question.no_answer_checked)}checked="checked"{/if}/><label for = "no_answer{$question.id}"><strong>No response was provided</strong></label>
			</div>
		{ /if }
	    {else}
	    No possible answers
	    {/if}
	  </td>
	</tr>
	{/foreach}
      </table>
    { if $possible_correct != 0 }
    	<strong>Correct:</strong> {$actual_correct} / {$possible_correct} ({$correct_percent}%) <small><em>[This only considers questions for which a correct answer has been indicated]</em></small>
    { /if }
	{if $files }
		<p>
			<h4 style = "margin-bottom:5px;">
				Uploaded file(s):
			</h4>
			{ foreach from=$files value=filename}
				<button type = "submit" name = "delete_file" value = "{ $filename }" class = "submit">Delete</button> <a href = "{ $templatelite.CONST.WEB_PATH }file_proxy.php?file={ $filename }">{ $filename }</a><br />
			{ /foreach }
		</p>
	{ /if }	
	<br />
	<br />
		<p>
			If at this time you would like to upload a file, please do so here:
		</p>
		<input type = "file" name = "new_response_file" /><input type = "submit" name = "upload" value = "Upload new file" class = "submit"/>
	<br />

	{if !isset($read_only) OR $read_only eq FALSE }
	      <div style = "text-align:right;">
		{if isset($templatelite.GET.load)}
		<input type = "submit" name = "edit" value = "Save and close" title = "Click this button to save the changes you've made to this response" class = "submit" />
		{else}
		<input type = "submit" name = "add_again" value = "Save and enter another response" title = "Click this button to add this response &lt;br /&gt;&amp; show this form again to add another response" class = "submit" />
		<input type = "submit" name = "add_close" value = "Save and close" title = "Click this button to add this response &amp; close the window" class = "submit" />
		<input type = "submit" name = "cancel" value = "Cancel" title = "Click to close this window" class = "submit" onclick = "window.close();return false;" />
		{/if}
	      </div>
	{/if}
      </form>
{/if}
{if !isset($inline) OR $inline eq FALSE }
<script type = "text/javascript">
{literal}
/* Uncheck possible answers if user chooses 'No student provided response' */
$(".no_answer").click(function(){
			var id = $(this).attr('name').substring(10);
			$('.'+id).attr('checked',false);
			$('.answer_'+id+'_text').val('');

		var rteParent = $(this).parent().siblings('div.no_print').children('span.mceEditorContainer');
		if(rteParent.length > 0)
		{
			var parentID = rteParent.attr('id');
			var editorID = parentID.substring(0,parentID.length - 7);
			tinyMCE.getInstanceById(editorID).setHTML('');
		}


});


/* Uncheck 'No student provided response' if user chooses an answer */
$(".answer").click(function(){
		     var id = $(this).attr('name').substring(7);
		     if(id.indexOf('[') != -1)
		       id = id.substring(0,id.length-id.indexOf('[') + 1);
		     $("#no_answer"+id).attr('checked',false);
		   });
		     

/* Uncheck 'No student provided response' if user chooses an answer */
$(".textarea").keydown(function(){
			 var id = $(this).attr('name').substring(7);
			 $("#no_answer"+id).attr('checked',false);
		       });

/* Auto grow textareas */
$("textarea").each(function(){    
		     if(this.scrollHeight > this.clientHeight)
		       this.style.height = this.scrollHeight+'px';
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
			     

{/literal}
</script>

{include file="foot.popup.tpl"}
{/if}