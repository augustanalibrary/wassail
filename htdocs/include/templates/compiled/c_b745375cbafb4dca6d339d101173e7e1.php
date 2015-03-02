<?php require_once('/var/www/htdocs/include/template_lite/plugins/modifier.date.php'); $this->register_modifier("date", "tpl_modifier_date");  require_once('/var/www/htdocs/include/template_lite/plugins/function.cycle.php'); $this->register_function("cycle", "tpl_function_cycle");  require_once('/var/www/htdocs/include/template_lite/plugins/function.counter.php'); $this->register_function("counter", "tpl_function_counter");  /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2014-04-30 13:38:09 MDT */ ?>

<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("head.tpl", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
      <?php if (isset ( $this->_vars['message'] )): ?>
      <div <?php if ($this->_vars['message']['type'] == 'success'): ?> class = "success" id = "question-deleted-message"<?php else: ?>class = "error"<?php endif; ?>>
	<?php echo $this->_vars['message']['message']; ?>

      </div>
      <?php endif; ?>
      <div style = "margin-bottom:10px;" >
	<img src = "include/templates/images/add.png" style = "vertical-align:top;margin-right:5px;" title = "Click to add a new question..." class = "edit clickable" id = "add_0" alt = "Add new question"/>
      </div>

    
      <?php if (isset ( $this->_vars['list'] ) && count ( $this->_vars['list'] )): ?>
      <?php if ($this->_vars['order_dir'] == 'asc'): ?>
        <?php $this->assign('dir', "asc"); ?>
        <?php $this->assign('dir_other', "desc"); ?>
        <?php $this->assign('dir_arrow', "<img src = 'include/templates/images/arrow_down.png' alt = 'Sort descending' />"); ?>
      <?php else: ?>
        <?php $this->assign('dir', "desc"); ?>
        <?php $this->assign('dir_other', "asc"); ?>
        <?php $this->assign('dir_arrow', "<img src = 'include/templates/images/arrow_up.png' alt = 'Sort ascending' />"); ?>
      <?php endif; ?>

<input type = "hidden" name = "js_order_column" id = "js_order_column" value = "<?php echo $this->_vars['order_column']; ?>
" />
<input type = "hidden" name = "js_order_dir" id = "js_order_dir" value = "<?php echo $this->_vars['order_dir']; ?>
" />
      <table class = "list">
	<tr>
	  <th style = "width:40px;">
	  <span title = "Click to sort by ID">
	    <a href = "questions/id/<?php if ($this->_vars['order_column'] == 'id'):  echo $this->_vars['dir_other'];  else:  echo $this->_vars['dir'];  endif; ?>/">
	      ID<?php if ($this->_vars['order_column'] == 'id'):  echo $this->_vars['dir_arrow'];  endif; ?>
	    </a>
	  </span>
	</th>
	<th>
	  <span title = "Click to sort by Question text">
	    <a href = "questions/text/<?php if ($this->_vars['order_column'] == 'text'):  echo $this->_vars['dir_other'];  else:  echo $this->_vars['dir'];  endif; ?>/">
	      Question<?php if ($this->_vars['order_column'] == 'text'):  echo $this->_vars['dir_arrow'];  endif; ?>
	    </a>
	  </span>
	</th>
	<th style = "width:120px;">
	  <span title = "Click to sort by date">
	    <a href = "questions/date/<?php if ($this->_vars['order_column'] == 'date'):  echo $this->_vars['dir_other'];  else:  echo $this->_vars['dir'];  endif; ?>/">
	      Date Added<?php if ($this->_vars['order_column'] == 'date'):  echo $this->_vars['dir_arrow'];  endif; ?>
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
  <?php if ($this->_vars['right_write_unconditional']): ?>
    <th style = "white-space:pre;">Templates&nbsp;<img src = "include/templates/images/eye.png" id = "templates-show" title = "Show templates" alt = "Show templates" class = "clickable"/><img src = "include/templates/images/eye-closed.png" id = "templates-hide" style = "display:none;" title = "Hide templates" alt = "Hide templates" class = "clickable"/>&nbsp;</th>
    <th style = "white-space:pre;">Stats&nbsp;<img src = "include/templates/images/eye.png" id = "stats-show" title = "Show stats" alt = "Show stats" class = "clickable"/><img src = "include/templates/images/eye-closed.png" id = "stats-hide" style = "display:none;" title = "Hide stats" alt = "Hide stats" class = "clickable"/></th>
  <?php endif; ?>
	<th>
	  <img src = "include/templates/images/page_excel.png" alt = "Generate CSV of questions" title = "Generate CSV (comma separated version) list of questions" id = "csv" class = "clickable"/>
	  <img src = "include/templates/images/printer.png" alt = "Generate printout of all questions" title = "Generate a printout of all questions" id = "print" class = "clickable"/>
	</th>
      </tr>
      
      <?php echo tpl_function_counter(array('name' => "rows",'start' => 0,'print' => false,'assign' => "row_counter"), $this);?>
      <?php if (count((array)$this->_vars['list'])): foreach ((array)$this->_vars['list'] as $this->_vars['row_id'] => $this->_vars['row']): ?>
      <?php echo tpl_function_counter(array('name' => "rows"), $this);?>
      <?php if ($this->_vars['row_counter'] % 10 == 0): ?>
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
          <?php if ($this->_vars['right_write_unconditional']): ?>
            <th>
              Templates
            </th>
            <th>
              Stats
            </th>
          <?php endif; ?>
          <th></th>
        </tr>
      <?php endif; ?>



      <tr class = "<?php echo tpl_function_cycle(array('values' => "even,odd"), $this);?>" style = "vertical-align:top;">
	<td>
	  <?php echo $this->_vars['row']['id']; ?>

	</td>
	<td style = "text-align:left;">
	  <?php echo $this->_vars['row']['text']; ?>

	</td>
	<td>
	  <?php echo $this->_run_modifier($this->_vars['row']['date_added'], 'date', 'plugin', 1, $this->_vars['date_format_short']); ?>

	</td>
	<td class = 'category' style = "text-align:left;">
	<?php if (isset ( $this->_vars['row']['categories'] )): ?>
<ul style = "margin:0;padding:0;">
	  <?php if (count((array)$this->_vars['row']['categories'])): foreach ((array)$this->_vars['row']['categories'] as $this->_vars['category_text']): ?>
	      <li><?php echo $this->_vars['category_text']; ?>
</li>
	  <?php endforeach; endif; ?>
</ul>
	<?php endif; ?>
	</td>
	<td class = "tag" style = "text-align:left;">
	<?php if (count ( $this->_vars['row']['tags'] ) >= 1): ?>
<ul style = "margin:0;margin-left:15px;padding:0;">
	  <?php if (count((array)$this->_vars['row']['tags'])): foreach ((array)$this->_vars['row']['tags'] as $this->_vars['tag_text']): ?>
	  <?php if (strlen ( $this->_vars['tag_text'] ) != 0): ?>
	      <li><?php echo $this->_vars['tag_text']; ?>
</li>
<?php endif; ?>
	  <?php endforeach; endif; ?>
	  </ul>
	  <?php endif; ?>
	</td>
	  <td style = "text-align:left;">
	    <div class = "answers">
	    <?php if (( isset ( $this->_vars['row']['answers'] ) )): ?>
	    <?php if (count((array)$this->_vars['row']['answers'])): foreach ((array)$this->_vars['row']['answers'] as $this->_vars['text']): ?>
	    &bull; <?php echo $this->_vars['text']; ?>
<br />
	    <?php endforeach; endif; ?>
	    <?php endif; ?>
	    </div>
	  </td>
    <?php if ($this->_vars['right_write_unconditional']): ?>
      <td style = "text-align:left;">
        <div class = "templates">
          <?php if (count((array)$this->_vars['row']['templates'])): foreach ((array)$this->_vars['row']['templates'] as $this->_vars['id'] => $this->_vars['name']): ?>
            &bull; [<?php echo $this->_vars['id']; ?>
] <?php echo $this->_vars['name']; ?>
<br />
          <?php endforeach; endif; ?>
        </div>
      </td>
      <td>
        <div class="stats">
            <?php if (count ( $this->_vars['row']['stats'] ) > 1): ?>
              <table class = "question-stats">
                <thead>
                  <tr>
                    <th></th>
                    <?php if (count((array)$this->_vars['terms'])): foreach ((array)$this->_vars['terms'] as $this->_vars['label']): ?>
                      <th><?php echo $this->_vars['label']; ?>
</th>
                    <?php endforeach; endif; ?>
                    <th>
                      Total
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (count((array)$this->_vars['row']['stats'])): foreach ((array)$this->_vars['row']['stats'] as $this->_vars['label'] => $this->_vars['year']): ?>
                    <tr>
                      <th>
                        <?php echo $this->_vars['label']; ?>

                      </th>
                      <?php if (count((array)$this->_vars['terms'])): foreach ((array)$this->_vars['terms'] as $this->_vars['term']): ?>
                        <td>
                          <?php if (isset ( $this->_vars['year'][$this->_vars['term']] )): ?>
                            <?php echo $this->_vars['year'][$this->_vars['term']]; ?>

                          <?php endif; ?>
                        </td>
                      <?php endforeach; endif; ?>
                      <td>
                        <?php echo $this->_vars['year']['Total']; ?>

                      </td>
                    </tr>
                  <?php endforeach; endif; ?>
                </tbody>
              </table>
          <?php else: ?>
            Question not yet in use
          <?php endif; ?>
        </div>
      </td>
    <?php endif; ?>
	<td style = "text-align:left;width:50px;whitespace:pre;vertical-align:top;">
	  <?php if (( $this->_vars['row']['asked'] == 0 && $this->_vars['right_write'] || $this->_vars['right_write_unconditional'] ) || $this->_vars['right_write_unconditional']): ?>
	  <img src = "include/templates/images/pencil.png" title = "Edit..." class = "edit clickable" id = "edit_<?php echo $this->_vars['row']['id']; ?>
" alt = "Edit"/>
	  <?php endif; ?>
	    <?php if ($this->_vars['row']['asked'] == 0 && ( $this->_vars['right_write'] || $this->_vars['right_write_unconditional'] )): ?>
	  <form method = 'post' action = 'questions/<?php echo $this->_vars['order_column']; ?>
/<?php echo $this->_vars['dir']; ?>
/' onsubmit = "return(confirm('Are you sure you want to delete this question?\n\nThis action is NOT undo-able.'));">
	  <div style = "display:inline;">
	    <input type = "hidden" name = "delete_id" value = "<?php echo $this->_vars['row']['id']; ?>
" /><input type = "image" class = "image" src = "include/templates/images/bin.png" title = "Delete" name = "delete" />
	  </div>
	    </form>
	    <?php endif; ?>
	</td>
      </tr>
      <?php endforeach; endif; ?>
    </table>
    <?php endif; ?>
    



<script type = "text/javascript">
<?php echo '
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

$(\'.edit\').click(function()
{
      var element_id = new String(this.id);
      element_id_broken = element_id.split(\'_\');
      var id = element_id_broken[1];

      editWindow = window.open(\'popup.edit_question.php?id=\'+id,\'editWindow\',\'toolbars=no,scrollbars=yes,resizable=yes,width=1000,height=750\');
      editWindow.focus();
});
$("#csv").click(function()
{
  var order_column = $(\'#js_order_column\').val();
  var order_dir = $(\'#js_order_dir\').val();
  
  printWindow = window.open(\'popup.question_dump.csv.php?o=\'+order_column+\'&d=\'+order_dir,\'csvWindow\',\'resizable=yes,scrollbars=yes,toolbar=no,menubar=yes,width=100,height=100\');
});
$("#print").click(function()
{
  var order_column = $(\'#js_order_column\').val();
  var order_dir = $(\'#js_order_dir\').val();
  
  printWindow = window.open(\'popup.question_dump.printout.php?o=\'+order_column+\'&amp;d=\'+order_dir,\'printWindow\',\'resizable=no,scrollbars=yes,toolbar=yes,menubar=no,width=800,height=500\');
});

$(\'.delete\').click(function()
{
      var conf = confirm("Are you sure you want to delete this question?\\n\\nThis action is NOT reversable.");
});


/**********
 * Filtering functions
 */

/*****
 * Helper functions
 */
function undoFilterEffect()
{
  $(".category").parent().removeClass(\'hidden\');
}
function hideAllRows()
{
  $(".category").parent().addClass(\'hidden\');
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
  $("#"+type+"-filter-field").val(\'\');
}

/*****
/* Toggling the display of the category filter field */
$(\'#category-filter\').click(function()
{
  /* If the user is filtering by tag, undo it */
  if(elementVisible(\'tag-filter-field-wrapper\'))
  {
    undoFilterEffect();
    hideFilterForm(\'tag\');
  }

  if(elementVisible(\'category-title\'))
    showFilterForm(\'category\');
  else
  {
    hideFilterForm(\'category\');
    undoFilterEffect();
  }
});
/* Add the listener */
$(\'#category-filter-field\').keyup(categoryFilter);

/*****
/* Toggling the display of the tag filter field */
$(\'#tag-filter\').click(function()
{
  /* If the user is filtering by category, undo it */
  if(elementVisible(\'category-filter-field-wrapper\'))
  {
    undoFilterEffect();
    hideFilterForm(\'category\');
  }

  if(elementVisible(\'tag-title\'))
    showFilterForm(\'tag\');
  else
  {
    hideFilterForm(\'tag\');
    undoFilterEffect();
  }
});
/* Add the listener */
$(\'#tag-filter-field\').keyup(tagFilter);

function categoryFilter()
{
  /* Get the search terms */
  var searchString = $(\'#category-filter-field\').val();
  /* If there are terms */
  if(searchString.length != 0)
  {
    var searchWords = searchString.split(\' \');

    hideAllRows();
    /* Loop through each search word */
    $.each(searchWords,function(key,word){
	     /* Loop through each element of class "category" that contains the current word */
	     $(".category:contains(\'"+word+"\')").each(function(i){
							/* remove the hiding class */
							$(this).parent().removeClass(\'hidden\');
						 });
	   });
  }
  /* If there are no search terms, remove the \'hidden\' class from all table rows */
  else
    undoFilterEffect();
}

function tagFilter()
{
  /* Get the search terms */
  var searchString = $(\'#tag-filter-field\').val();
  /* If there are terms */
  if(searchString.length != 0)
  {
    var searchWords = searchString.split(\' \');

    hideAllRows();
    /* Loop through each search word */
    $.each(searchWords,function(key,word){
	     /* Loop through each element of class "tag" that contains the current word */
	     $(".tag:contains(\'"+word+"\')").each(function(i){
							/* remove the hiding class */
							$(this).parent().removeClass(\'hidden\');
						 });
	   });
  }
  /* If there are no search terms, remove the \'hidden\' class from all table rows */
  else
    undoFilterEffect();
}



$(document).ready(function(){
      $("#question-deleted-message").animate({
      opacity:0},5000);
});
'; ?>

</script>
<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("foot.tpl", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
