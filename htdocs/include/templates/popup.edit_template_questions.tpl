{include file="head.popup.tpl"}
{if isset($unauthed)}
  This template has been asked &amp; cannot be modified by you.
  {include file="foot.popup.tpl"}
  {php}
    exit();
  {/php}
{/if}

      {if isset($success)}
      <div class = "{if $success}success{else}error{/if}" id = "message">
	{$message}
      </div>
      {/if}

    <form method = "post" action = "popup.edit_template_questions.php?id={$id}">
      <div style = "text-align:left;margin-top:2px;font-size:8pt;margin-bottom:1em;">
	<input type = "hidden" name = "unsetdelete" id = "hidden-delete" value = "0" />
	<input type = "image" value = "Add" id = "add-icon" class = "image spawn-question-popup" src = "{ $templatelite.CONST.WEB_PATH }include/templates/images/add.png" title = "Add a new question..." onclick = "return false" style = "vertical-align:middle;"/>
<label for = "add-icon" style = "vertical-align:middle;" class = "clickable">Add a question</label>
      </div>
      {if isset($questions)}
<div>
<input type = "submit" name = "save" class = "submit clickable" value = "Save questions" style = "float:left;"/>
<input type = "submit" name = "cancel" class = "submit clickable" value = "Close" onclick = "window.close();" />
	<ol id = "questions-list" style = "font-size:8pt;">
	{counter print=false assign="counter"}
	  {foreach from=$questions value=question}
	  {counter}
	<li class = "{if $counter is even}even{else}odd{/if}" style = "padding:5px;">
	  <img src = "{ $templatelite.CONST.WEB_PATH }include/templates/images/arrow-up-down.png" 
	    style = "cursor: n-resize;vertical-align:top;"
	    alt = "Re-order"
	    title = "Drag up and down to re-order.&lt;br /&gt;Note: You must click the save icon to preserve your changes." />
	  <input type = "image" 
	    src = "{ $templatelite.CONST.WEB_PATH }include/templates/images/bin.png"
	    style = "vertical-align:top;"
	    class = "image delete-icon"
	    name = "delete"
	    value = "{$question.id}"
	    title = "Remove this question from this template"/>

	  <input type = "hidden" 
	    name = "questions[]" 
	    value = "{$question.id}" />

		[{$question.id}]
	  
	   {$question.text}
	  
      </li>
	{/foreach}
      </ol>
<input type = "submit" name = "save" class = "submit clickable" value = "Save questions" style = "float:left;" />
<input type = "submit" name = "cancel" class = "submit clickable" value = "Close" onclick = "window.close();" />
</div>
    {/if}
    </form>
    <!-- This is a hidden form that gets populated & submitted when a user chooses a question from the question list popup -->
    <form method = "post" action = "popup.edit_template_questions.php?id={$id}" id = "add-form">
      <div>
	<input type = "hidden" name = "add" value = "" id = "add"/>
      </div>
    </form>
    <script type = "text/javascript">
      {literal}
$(".spawn-question-popup").click(function(){
				   window.open('popup.question_list.php?return=add','questionList','width=900,height=500,resizable=yes,scrollbars=yes,status=no,toolbars=no');
      });
$(document).ready(function(){
		    $("#questions-list").sortable({
		      containment : "parent",
			  hoverclass : "sort-hover"
			  })


      $("#message").animate({
      opacity:0},5000);


});
$(".delete-icon").click(function(){
			  var confirmResult = confirm('Are you sure you want to remove this question from the template?\n\nThis action is permanent and may not be reversed.');
			  if(confirmResult)
			    $("#hidden-delete").val($(this).val()).attr('name','delete');
			  else
			    return false;
			});

{/literal}
</script>
</div>
</body>
</html>
