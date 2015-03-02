{ include file = "head.popup.tpl" }
<div style = "min-width:795px;">
      <div id = "tabs">
	<div style = "float:left;width:50%;">
	<ul>
	  <li class = "active">
	    <a href = "#" id = "tab-type">1. Type</a>
	  </li>
	  <li>
	    <a href = "#" id = "tab-text">2. Text</a>
	  </li>
	  <li>
	    <a href = "#" id = "tab-categories">3. Categories</a>
	  </li>
	  <li>
	    <a href = "#" id = "tab-tags">4. Tags</a>
	  </li>
	  <li>
	    <a href = "#" id = "tab-answers">5. Answers</a>
	  </li>
	</ul>
	</div>
	<ul id = "summary" style = "float:left;margin-left:11px;">
	  <li style = "border:1px solid #000;padding:5px;">
	    Summary/Save
	  </li>
	</ul>
      </div>
      <form method = 'post' action = "popup.edit_question.php?id={ $id }" id = "form">
      <div id = "panel-type" class = "panel">
	Choose which type of question you want:
	<br />
	<br />
	<div class = "odd question">
	  <input type = "radio" name = "type" value = "single" { if {$question_type == 'single' }checked="checked"{ /if }/>
	  <div>
	    Single Answer
	    <label>
	      Users will be able to select only one response from the provided answers.
	    </label>
	  </div>
	</div>
	<div class = "even question">
	  <input type = "radio" name = "type" value = "multiple" { if $question_type == 'multiple' }checked="checked"{ /if }/>
	  <div>
	    Multiple Answer
	    <label>
	      Users will be able to select more than one response from the provided answers.
	    </label>
	  </div>
	</div>
	<div class = "odd question">
	  <input type = "radio" name = "type" value = "qualitative_short" { if $question_type == 'qualitative' and $question_qualitative_type == 'short' }checked="checked"{ /if } />
	  <div>
	    Qualitative (Short)
	    <label>
	      A single line text field will be provided for users to enter their responses.
	    </label>
	  </div>
	</div>
	<div class = "even question">
	  <input type = "radio" name = "type" value = "qualitative_long"  { if $question_type == 'qualitative' and $question_qualitative_type == 'long' }checked="checked"{ /if } />
	  <div>
	    Qualitative (Long)
	    <label>
	      A multiple line text field will be provided for users to enter their responses.
	    </label>
	  </div>	  
	</div>
	<div class = "button-holder">
	  <a href = "#" class = "next">Next</a>
	</div>
      </div>


      <div id = "panel-text" class = "panel hidden">
	<textarea name = "content" cols="100" rows = "20" style = "width:100%;" id = "editor-area">{$text}</textarea>
	<div class = "button-holder">
	  <a href = "#" class = "previous">Previous</a> | <a href = "#" class = "next">Next</a>
	</div>
      </div>

      <div id = "panel-categories" class = "panel hidden">
	Hold Ctrl while clicking to select multiple categories
	<br />
	<br />
	<select multiple="multiple" name = "categories[]" size = "28" id = "categories">
	  {foreach from=$categories key=category_id value=properties}
	  <option value = "{$category_id}" {if $properties.selected === TRUE}selected="selected"{/if} id = "category-{$category_id}">{ if in_array($category_id,$indent_categories) }&nbsp;&nbsp;{ /if }{$properties.text}</option>
	{/foreach}
      </select>
	<div class = "button-holder">
	  <a href = "#" class = "previous">Previous</a> | <a href = "#" class = "next">Next</a>
	</div>
      </div>




      <div id = "panel-tags" class = "panel hidden">
	Separate tags with commas.  All tags will be converted to lowercase.
	<br />
	<input type = "text" class = "input-field" name = "tags" id = "tags" value = "{$tags|escape}" style = "width:100%; margin-right:5px;"/>
	<div class = "button-holder">
	  <a href = "#" class = "previous">Previous</a> | <a href = "#" class = "next">Next</a>
	</div>
      </div>


      <div id = "panel-answers" class = "panel hidden">
	<div id = "panel-answers-inside">
	  <div style = "vertical-align:middle;">
	    { if isset($likert) }
			<select name = "likert" id = "likert" style = "vertical-align:middle;cursor:pointer;">
			  <option value = "-1">Add scaled answers...</option>
			{foreach from=$likert key=index value=answer}
			<option value = "{$index}">{$answer.title}</option>
			{/foreach}
		  </select>
	    { /if }
	    { if isset($common_answers) }
			<select name = "common_answers" id = "common_answers" style = "vertical-align:middle;cursor:pointer;">
			  <option value = "-1">Add commonly used responses</option>
			  { foreach from=$common_answers key=index value=answer }
			<option value = "{ $index} ">{ $answer }</option>
			{ /foreach }
			</select>
	    {/if}

	    <br />
	    <input type = "text" id = "new-answer-text" style = "vertical-align:middle;width:350px;" />&nbsp;<span style = "vertical-align:middle;cursor:pointer;" id = "add-answer"><img src = "include/templates/images/add.png" style = "vertical-align:top;margin-top:2px;" alt = "Add answer" />Add new answer</span>
	  </div>
	  
	  <ol type = "a" id = "answer-list-clone-original" style = "display:none;">
	    <li id = "answer-clone-original">
	      <img src = "include/templates/images/arrow-up-down.png" style = "vertical-align:middle;cursor:n-resize;" alt = "Re-order" class = "re-order"/>
	      <img src = "include/templates/images/check-grey.png" alt = "Set answer as correct" title = "Set answer as correct" style = "vertical-align:middle;" class = "status incorrect clickable" />
	      <input type = "hidden" class = "answer-id"/>
	      <input type = "text" value = "" class = "input-field notooltip" size = "60"/>
	      <img src = "include/templates/images/bin.png" alt = "Delete" title = "Delete" style = "vertical-align:middle;" class = "answer-delete clickable" />
	    </li>
	  </ol>
	  <div id = "answer-list-wrapper">
	    { if isset($answers) && count($answers) gt 0}
	    <ol type = "a" id = "answer-list">
	      { foreach from=$answers key=answer_id value=answer }
		<li>
		<img src = "include/templates/images/arrow-up-down.png" style = "vertical-align:middle;cursor:n-resize;" alt = "Re-order" class = "re-order"/>
		{ if $answer.correct == 0 }
		<img src = "include/templates/images/check-grey.png" alt = "Set answer as correct" title = "Set answer as correct" style = "vertical-align:middle;" class = "status incorrect clickable" />
		{ else }
		<img src = "include/templates/images/check.png" alt = "Set answer as incorrect" title = "Set answer as incorrect" style = "vertical-align:middle;" class = "status correct clickable" />
		{ assign var="correct" value = $answer_id }
		{ /if }
		<input type = "hidden" name = "answer_ids[]" value = "{ $answer_id }"/>
		&nbsp;|&nbsp;
		<input type = "text" name = "answers[]" value = "{ $answer.text|escape }" class = "input-field" size = "60" />
		<img src = "include/templates/images/bin.png" alt = "Delete" title = "Delete" style = "vertical-align:middle;" class = "answer-delete clickable" />

	      </li>
	    { /foreach }
	  </ol>
	    { /if }
	  </div>
	  {* semantically, this should be inside the </div> the line above.  However, to make JS work well, it's here *}
	<input type = "hidden" name = "correct" value = "{ if isset($correct) }{ $correct }{ /if }" id = "correct"/>	    


	  <div class = "button-holder">
	    <a href = "#" class = "previous">Previous</a>
	  </div>
	</div>





	<div id = "panel-answers-qualitative-text" class = "hidden">
	Choose the text to accompany the checkbox users can click if they don't want to or can't answer the question.
	<br />
	<br />
	If left blank, the opt out checkbox will not be shown and the question will become required.
	<br />
	<br />
	
	 { if isset($common_answers) }
	 	{* This will always be in the form which will result in `opt_out` always being the default if not set *}
		<input type = "text" id = "qualitative-opt-out-text" name = "qualitative_opt_out" value = "{ if $id neq 0 }{$opt_out|escape:"html"}{ else }I prefer not to answer or not applicable{ /if }" size = "60"/>
		<select id = "qualitative-opt-out" style = "vertical-align:middle;cursor:pointer;">
			<option value = "-1">&larr; Add commonly used options</option>
			{ foreach from=$common_answers key=index value=answer }
				<option value = "{ $index }">{ $answer }</option>
			{ /foreach }
		</select>
	    {/if}
	</div>
      </div>
      <div id = "panel-summary" class = "summary-panel">
	<div id = "type-error-holder" class = "hidden">
	  <div class = "error">
	    <a href = "#" class = "no-type-fix">
	      Please choose a question type. 
	    </a>
	  </div>
	</div>
	<div id = "text-error-holder" class = "hidden">
	  <div class = "error">
	    <a href = "#" class = "no-text-fix">
	      Please enter some question text. 
	    </a>
	  </div>
	</div>
	<div id = "answer-error-holder" class = "hidden">
	  <div class = "error">
	    <a href = "#" class = "no-answer-fix">
	      Please enter some answers.  
	    </a>
	  </div>
	</div>
	<fieldset>
	  <legend>
	    Type
	  </legend>
	  <div id = "summary-type">	    
	  </div>
	</fieldset>
	<fieldset>
	  <legend>
	    Text
	  </legend>
	  <div id = "summary-text">
	  </div>
	</fieldset>
	<fieldset>
	  <legend>
	    Categories
	  </legend>
	  <div id = "summary-categories">
	  </div>
	</fieldset>
	<fieldset>
	  <legend>
	    Tags
	  </legend>
	  <div id = "summary-tags">
	  </div>
	</fieldset>
	<fieldset>
	  <legend>
	    Answers
	  </legend>
	  <div id = "summary-answers">
	  </div>
	</fieldset>
	<div id = "save" style = "text-align:right;">
	  <input type = "submit" class = "submit" value = "Save question &amp; close" name = "save_close"/>
	  <input type = "submit" class = "submit" value = "Save question &amp; enter another" name = "save_again"/>
	  <br />
	  <br />
	</div>
	<div style = "text-align:right;padding-right:4px;">
	  <input type = "submit" class = "submit" value = "Cancel" id = "cancel" />
	</div>
      </div>
      </form>
</div>
<script type = "text/javascript">
// Build a JS array from the Likert answers
var likert = new Array({ count target=$likert });
{ foreach from=$likert key=key value=answers }
      likert[{ $key }] = new Array({ count target=$answers.values });
      { foreach from=$answers.values key=answer_key value=answer_text}
      likert[{ $key }][{ $answer_key }] = '{ $answer_text}';
      { /foreach }
{ /foreach }
</script>
<script type = "text/javascript" src = "include/templates/js/edit_question.js"></script>
{ include file = "foot.popup.tpl" }