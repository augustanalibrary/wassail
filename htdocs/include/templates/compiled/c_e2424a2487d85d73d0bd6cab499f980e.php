<?php require_once('/var/www/htdocs/include/template_lite/plugins/function.counter.php'); $this->register_function("counter", "tpl_function_counter");  /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2014-04-15 10:47:44 MDT */ ?>

<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("head.popup.tpl", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
  if (isset ( $this->_vars['unauthed'] )): ?>
  This template has been asked &amp; cannot be modified by you.
  <?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("foot.popup.tpl", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
  <?php 
    exit();
    endif; ?>

      <?php if (isset ( $this->_vars['success'] )): ?>
      <div class = "<?php if ($this->_vars['success']): ?>success<?php else: ?>error<?php endif; ?>" id = "message">
	<?php echo $this->_vars['message']; ?>

      </div>
      <?php endif; ?>

    <form method = "post" action = "popup.edit_template_questions.php?id=<?php echo $this->_vars['id']; ?>
">
      <div style = "text-align:left;margin-top:2px;font-size:8pt;margin-bottom:1em;">
	<input type = "hidden" name = "unsetdelete" id = "hidden-delete" value = "0" />
	<input type = "image" value = "Add" id = "add-icon" class = "image spawn-question-popup" src = "<?php echo constant('WEB_PATH'); ?>
include/templates/images/add.png" title = "Add a new question..." onclick = "return false" style = "vertical-align:middle;"/>
<label for = "add-icon" style = "vertical-align:middle;" class = "clickable">Add a question</label>
      </div>
      <?php if (isset ( $this->_vars['questions'] )): ?>
<div>
<input type = "submit" name = "save" class = "submit clickable" value = "Save questions" style = "float:left;"/>
<input type = "submit" name = "cancel" class = "submit clickable" value = "Close" onclick = "window.close();" />
	<ol id = "questions-list" style = "font-size:8pt;">
	<?php echo tpl_function_counter(array('print' => false,'assign' => "counter"), $this);?>
	  <?php if (count((array)$this->_vars['questions'])): foreach ((array)$this->_vars['questions'] as $this->_vars['question']): ?>
	  <?php echo tpl_function_counter(array(), $this);?>
	<li class = "<?php if (!(1 & $this->_vars['counter'])): ?>even<?php else: ?>odd<?php endif; ?>" style = "padding:5px;">
	  <img src = "<?php echo constant('WEB_PATH'); ?>
include/templates/images/arrow-up-down.png" 
	    style = "cursor: n-resize;vertical-align:top;"
	    alt = "Re-order"
	    title = "Drag up and down to re-order.&lt;br /&gt;Note: You must click the save icon to preserve your changes." />
	  <input type = "image" 
	    src = "<?php echo constant('WEB_PATH'); ?>
include/templates/images/bin.png"
	    style = "vertical-align:top;"
	    class = "image delete-icon"
	    name = "delete"
	    value = "<?php echo $this->_vars['question']['id']; ?>
"
	    title = "Remove this question from this template"/>

	  <input type = "hidden" 
	    name = "questions[]" 
	    value = "<?php echo $this->_vars['question']['id']; ?>
" />

		[<?php echo $this->_vars['question']['id']; ?>
]
	  
	   <?php echo $this->_vars['question']['text']; ?>

	  
      </li>
	<?php endforeach; endif; ?>
      </ol>
<input type = "submit" name = "save" class = "submit clickable" value = "Save questions" style = "float:left;" />
<input type = "submit" name = "cancel" class = "submit clickable" value = "Close" onclick = "window.close();" />
</div>
    <?php endif; ?>
    </form>
    <!-- This is a hidden form that gets populated & submitted when a user chooses a question from the question list popup -->
    <form method = "post" action = "popup.edit_template_questions.php?id=<?php echo $this->_vars['id']; ?>
" id = "add-form">
      <div>
	<input type = "hidden" name = "add" value = "" id = "add"/>
      </div>
    </form>
    <script type = "text/javascript">
      <?php echo '
$(".spawn-question-popup").click(function(){
				   window.open(\'popup.question_list.php?return=add\',\'questionList\',\'width=900,height=500,resizable=yes,scrollbars=yes,status=no,toolbars=no\');
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
			  var confirmResult = confirm(\'Are you sure you want to remove this question from the template?\\n\\nThis action is permanent and may not be reversed.\');
			  if(confirmResult)
			    $("#hidden-delete").val($(this).val()).attr(\'name\',\'delete\');
			  else
			    return false;
			});

'; ?>

</script>
</div>
</body>
</html>
