{include file="head.tpl"}
      {if isset($message)}
      <div {if $message.type == 'success'} class = "success" id = "question-deleted-message"{else}class = "error"{/if}>
	{$message.message}
      </div>
      {/if}
      <div style = "margin-bottom:10px;" >
	<img src = "include/templates/images/add.png" style = "vertical-align:top;margin-right:5px;" title = "Click to add a new question..." class = "edit clickable" id = "add_0" alt = "Add new question"/>
      </div>

    {* Question list table *}
      {if isset($list) && count($list)}
      {if $order_dir == 'asc'}
        {assign var = "dir" value = "asc"}
        {assign var = "dir_other" value = "desc"}
        {assign var = "dir_arrow" value = "<img src = 'include/templates/images/arrow_down.png' alt = 'Sort descending' />"}
      {else}
        {assign var = "dir" value = "desc"}
        {assign var = "dir_other" value = "asc"}
        {assign var = "dir_arrow" value = "<img src = 'include/templates/images/arrow_up.png' alt = 'Sort ascending' />"}
      {/if}
{*  These exist so JS can properly pass the order information to a new window when the print icon is clicked *}
<input type = "hidden" name = "js_order_column" id = "js_order_column" value = "{$order_column}" />
<input type = "hidden" name = "js_order_dir" id = "js_order_dir" value = "{$order_dir}" />
      <table class = "list">
	<tr>
	  <th style = "width:40px;">
	  <span title = "Click to sort by ID">
	    <a href = "questions/id/{if $order_column == 'id'}{$dir_other}{else}{$dir}{/if}/">
	      ID{if $order_column == 'id'}{$dir_arrow}{/if}
	    </a>
	  </span>
	</th>
	<th>
	  <span title = "Click to sort by Question text">
	    <a href = "questions/text/{if $order_column == 'text'}{$dir_other}{else}{$dir}{/if}/">
	      Question{if $order_column == 'text'}{$dir_arrow}{/if}
	    </a>
	  </span>
	</th>
	<th style = "width:120px;">
	  <span title = "Click to sort by date">
	    <a href = "questions/date/{if $order_column == 'date'}{$dir_other}{else}{$dir}{/if}/">
	      Date Added{if $order_column == 'date'}{$dir_arrow}{/if}
	    </a>
	  </span>
	</th>
	<th style = "width: 115px;">
	  <span id = "category-title">
	    Categories
	  </span>
	  &nbsp;&nbsp;
	  <span id = "category-filter-field-wrapper" style = "display:none;">
	    <input type = "text" class = "input-field" id = "category-filter-field" style = "font-weight:normal;font-size:10px;" title = "Enter any number of filter words.&lt;br /&gt;Only rows matching ALL search terms will be visible."/>
	  </span>
	  <img src = "include/templates/images/filter.png" title = "Filter on Categories..." alt = "Filter" style = "vertical-align:top;" id = "category-filter"/>
	</th>
	<th style = "width:150px;">
	  <span id = "tag-title">
	    Tags
	  </span>
	  &nbsp;&nbsp;
	  <span id = "tag-filter-field-wrapper" style = "display:none;">
	    <input type = "text" class = "input-field" id = "tag-filter-field" style = "font-weight:normal;font-size:10px;" title = "Enter any number of filter words.&lt;br /&gt;Only rows matching ALL search terms will be visible.&lt;br /&gt;Tags are case sensitive."/>
	  </span>
	  <img src = "include/templates/images/filter.png" title = "Filter on Tags..." alt = "Filter" style = "vertical-align:top;" id = "tag-filter" />
	</th>
	<th style = "white-space:pre;">Answers&nbsp;<img src = "include/templates/images/eye.png" id = "answers-show" title = "Show answers" alt = "Show answers" class = "clickable"/><img src = "include/templates/images/eye-closed.png" id = "answers-hide" style = "display:none;" title = "Hide answers" alt = "Hide answers" class = "clickable"/>&nbsp;</th>
  { if $right_write_unconditional}
    <th style = "white-space:pre;">Templates&nbsp;<img src = "include/templates/images/eye.png" id = "templates-show" title = "Show templates" alt = "Show templates" class = "clickable"/><img src = "include/templates/images/eye-closed.png" id = "templates-hide" style = "display:none;" title = "Hide templates" alt = "Hide templates" class = "clickable"/>&nbsp;</th>
    <th style = "white-space:pre;">Stats&nbsp;<img src = "include/templates/images/eye.png" id = "stats-show" title = "Show stats" alt = "Show stats" class = "clickable"/><img src = "include/templates/images/eye-closed.png" id = "stats-hide" style = "display:none;" title = "Hide stats" alt = "Hide stats" class = "clickable"/></th>
  { /if }
	<th>
	  <img src = "include/templates/images/page_excel.png" alt = "Generate CSV of questions" title = "Generate CSV (comma separated version) list of questions" id = "csv" class = "clickable"/>
	  <img src = "include/templates/images/printer.png" alt = "Generate printout of all questions" title = "Generate a printout of all questions" id = "print" class = "clickable"/>
	</th>
      </tr>
      
      {counter name = "rows" start=0 print=false assign="row_counter"}
      {foreach from=$list key=row_id value=row}
      {counter name = "rows"}
      { if $row_counter%10 eq 0 }
        <tr>
          <th>
            ID
          </th>
          <th>
            Question
          </th>
          <th>
            Date Added
          </th>
          <th>
            Categories
          </th>
          <th>    
            Tags
          </th>
          <th>
            Answers
          </th>
          { if $right_write_unconditional}
            <th>
              Templates
            </th>
            <th>
              Stats
            </th>
          { /if }
          <th></th>
        </tr>
      {/if}



      <tr class = "{cycle values = "even,odd"}" style = "vertical-align:top;">
	<td>
	  {$row.id}
	</td>
	<td style = "text-align:left;">
	  {$row.text}
	</td>
	<td>
    <?php 
      /* The TemplateLite way of doing this was creating really wacky dates for no discernable reason.
       * "1407440239" got rendered as 05/03/39 instead of 07/08/14.  So, raw PHP is used
       */
      echo date($this->_vars['date_format_short'],$this->_vars['row']['date_added']);
    ?>
	</td>
	<td class = 'category' style = "text-align:left;">
	{if isset($row.categories)}
<ul style = "margin:0;padding:0;">
	  {foreach from=$row.categories value=category_text}
	      <li>{$category_text}</li>
	  {/foreach}
</ul>
	{/if}
	</td>
	<td class = "tag" style = "text-align:left;">
	{if count($row.tags) gte 1}
<ul style = "margin:0;margin-left:15px;padding:0;">
	  {foreach from=$row.tags value=tag_text}
	  {if strlen($tag_text) != 0}
	      <li>{$tag_text}</li>
{/if}
	  {/foreach}
	  </ul>
	  {/if}
	</td>
	  <td style = "text-align:left;">
	    <div class = "answers">
	    {if (isset($row.answers))}
	    {foreach from=$row.answers value=text}
	    &bull; {$text}<br />
	    {/foreach}
	    {/if}
	    </div>
	  </td>
    { if $right_write_unconditional }
      <td style = "text-align:left;">
        <div class = "templates">
          { foreach from=$row.templates value=name key=id}
            &bull; [{$id}] {$name}<br />
          {/foreach}
        </div>
      </td>
      <td>
        <div class="stats">
            { if count($row.stats) gt 1 }
              <table class = "question-stats">
                <thead>
                  <tr>
                    <th></th>
                    { foreach from=$terms value=label }
                      <th>{ $label }</th>
                    {/foreach}
                    <th>
                      Total
                    </th>
                  </tr>
                </thead>
                <tbody>
                  {foreach from=$row.stats value=year key=label }
                    <tr>
                      <th>
                        { $label }
                      </th>
                      { foreach from=$terms value=term }
                        <td>
                          { if isset($year[$term]) }
                            {$year[$term]}
                          { /if }
                        </td>
                      {/foreach}
                      <td>
                        { $year.Total }
                      </td>
                    </tr>
                  {/foreach}
                </tbody>
              </table>
          { else }
            Question not yet in use
          { /if }
        </div>
      </td>
    {/if}
	<td style = "text-align:left;width:50px;whitespace:pre;vertical-align:top;">
	  {if ($row.asked == 0 and $right_write or $right_write_unconditional) or $right_write_unconditional }
	  <img src = "include/templates/images/pencil.png" title = "Edit..." class = "edit clickable" id = "edit_{$row.id}" alt = "Edit"/>
	  {/if}
	    {if $row.asked == 0 and ($right_write or $right_write_unconditional)}
	  <form method = 'post' action = 'questions/{$order_column}/{$dir}/' onsubmit = "return(confirm('Are you sure you want to delete this question?\n\nThis action is NOT undo-able.'));">
	  <div style = "display:inline;">
	    <input type = "hidden" name = "delete_id" value = "{$row.id}" /><input type = "image" class = "image" src = "include/templates/images/bin.png" title = "Delete" name = "delete" />
	  </div>
	    </form>
	    {/if}
	</td>
      </tr>
      {/foreach}
    </table>
    {/if}
    {* /If there are questions to list *}



<script type = "text/javascript">
{literal}
var editWindow;
$("#answers-show").click(function()
{
    $(".answers").toggle();
    $("#answers-show").toggle();
    $("#answers-hide").toggle();
});
$("#answers-hide").click(function()
{
    $(".answers").toggle();
    $("#answers-show").toggle();
    $("#answers-hide").toggle();
});

$("#templates-show").click(function()
{
    $(".templates").toggle();
    $("#templates-show").toggle();
    $("#templates-hide").toggle();
});
$("#templates-hide").click(function()
{
    $(".templates").toggle();
    $("#templates-show").toggle();
    $("#templates-hide").toggle();
});

$("#stats-show").click(function()
{
    $(".stats").toggle();
    $("#stats-show").toggle();
    $("#stats-hide").toggle();
});
$("#stats-hide").click(function()
{
    $(".stats").toggle();
    $("#stats-show").toggle();
    $("#stats-hide").toggle();
});

$('.edit').click(function()
{
      var element_id = new String(this.id);
      element_id_broken = element_id.split('_');
      var id = element_id_broken[1];

      editWindow = window.open('popup.edit_question.php?id='+id,'editWindow','toolbars=no,scrollbars=yes,resizable=yes,width=1000,height=750');
      editWindow.focus();
});
$("#csv").click(function()
{
  var order_column = $('#js_order_column').val();
  var order_dir = $('#js_order_dir').val();
  
  printWindow = window.open('popup.question_dump.csv.php?o='+order_column+'&d='+order_dir,'csvWindow','resizable=yes,scrollbars=yes,toolbar=no,menubar=yes,width=100,height=100');
});
$("#print").click(function()
{
  var order_column = $('#js_order_column').val();
  var order_dir = $('#js_order_dir').val();
  
  printWindow = window.open('popup.question_dump.printout.php?o='+order_column+'&amp;d='+order_dir,'printWindow','resizable=no,scrollbars=yes,toolbar=yes,menubar=no,width=800,height=500');
});

$('.delete').click(function()
{
      var conf = confirm("Are you sure you want to delete this question?\n\nThis action is NOT reversable.");
});


/**********
 * Filtering functions
 */

/*****
 * Helper functions
 */
function undoFilterEffect()
{
  $(".category").parent().removeClass('hidden');
}
function hideAllRows()
{
  $(".category").parent().addClass('hidden');
}
function elementVisible(id)
{
  if($("#"+id).css("display") == "none")
    return false;
  else
    return true;
}
function showFilterForm(type)
{
  $("#"+type+"-title").hide();
  $("#"+type+"-filter-field-wrapper").show();
  $("#"+type+"-filter-field").focus();
}
function hideFilterForm(type)
{
  $("#"+type+"-title").show();
  $("#"+type+"-filter-field-wrapper").hide();
  $("#"+type+"-filter-field").val('');
}

/*****
/* Toggling the display of the category filter field */
$('#category-filter').click(function()
{
  /* If the user is filtering by tag, undo it */
  if(elementVisible('tag-filter-field-wrapper'))
  {
    undoFilterEffect();
    hideFilterForm('tag');
  }

  if(elementVisible('category-title'))
    showFilterForm('category');
  else
  {
    hideFilterForm('category');
    undoFilterEffect();
  }
});
/* Add the listener */
$('#category-filter-field').keyup(categoryFilter);

/*****
/* Toggling the display of the tag filter field */
$('#tag-filter').click(function()
{
  /* If the user is filtering by category, undo it */
  if(elementVisible('category-filter-field-wrapper'))
  {
    undoFilterEffect();
    hideFilterForm('category');
  }

  if(elementVisible('tag-title'))
    showFilterForm('tag');
  else
  {
    hideFilterForm('tag');
    undoFilterEffect();
  }
});
/* Add the listener */
$('#tag-filter-field').keyup(tagFilter);

function categoryFilter()
{
  /* Get the search terms */
  var searchString = $('#category-filter-field').val();
  /* If there are terms */
  if(searchString.length != 0)
  {
    var searchWords = searchString.split(' ');

    hideAllRows();
    /* Loop through each search word */
    $.each(searchWords,function(key,word){
	     /* Loop through each element of class "category" that contains the current word */
	     $(".category:contains('"+word+"')").each(function(i){
							/* remove the hiding class */
							$(this).parent().removeClass('hidden');
						 });
	   });
  }
  /* If there are no search terms, remove the 'hidden' class from all table rows */
  else
    undoFilterEffect();
}

function tagFilter()
{
  /* Get the search terms */
  var searchString = $('#tag-filter-field').val();
  /* If there are terms */
  if(searchString.length != 0)
  {
    var searchWords = searchString.split(' ');

    hideAllRows();
    /* Loop through each search word */
    $.each(searchWords,function(key,word){
	     /* Loop through each element of class "tag" that contains the current word */
	     $(".tag:contains('"+word+"')").each(function(i){
							/* remove the hiding class */
							$(this).parent().removeClass('hidden');
						 });
	   });
  }
  /* If there are no search terms, remove the 'hidden' class from all table rows */
  else
    undoFilterEffect();
}



$(document).ready(function(){
      $("#question-deleted-message").animate({
      opacity:0},5000);
});
{/literal}
</script>
{include file="foot.tpl"}
