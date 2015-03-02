<?php require_once('/var/www/htdocs/include/template_lite/plugins/function.counter.php'); $this->register_function("counter", "tpl_function_counter");  /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2014-04-29 11:03:52 MDT */ ?>

<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("head.popup.tpl", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
<div class = "notice">
Note: Click on the question to choose it.  <input type = "submit" class = "submit" onclick = "window.close()" value = "Close" /> to cancel.
</div>
<br />
<?php if (count ( $this->_vars['list'] ) > 0): ?>
      <?php if ($this->_vars['order_dir'] == 'asc'): ?>
        <?php $this->assign('dir', "asc"); ?>
        <?php $this->assign('dir_other', "desc"); ?>
        <?php $this->assign('dir_arrow', "<img src = '/include/templates/images/arrow_down.png' alt = 'Sort descending' />"); ?>
      <?php else: ?>
        <?php $this->assign('dir', "desc"); ?>
        <?php $this->assign('dir_other', "asc"); ?>
        <?php $this->assign('dir_arrow', "<img src = '/include/templates/images/arrow_up.png' alt = 'Sort ascending' />"); ?>
      <?php endif; ?>
      <table class = "list">
	<tr>
	  <th style = "width:40px;"><a href = "popup.question_list.php?return=<?php echo $_GET['return']; ?>
&amp;o=id&amp;d=<?php if ($this->_vars['order_column'] == 'id'):  echo $this->_vars['dir_other'];  else:  echo $this->_vars['dir'];  endif; ?>">ID<?php if ($this->_vars['order_column'] == 'id'):  echo $this->_vars['dir_arrow'];  endif; ?></a></th>
	  <th><a href = "popup.question_list.php?return=<?php echo $_GET['return']; ?>
&amp;o=text&amp;d=<?php if ($this->_vars['order_column'] == 'text'):  echo $this->_vars['dir_other'];  else:  echo $this->_vars['dir'];  endif; ?>">Text<?php if ($this->_vars['order_column'] == 'text'):  echo $this->_vars['dir_arrow'];  endif; ?></a></th>
	  <th>Categories</th>
	  <th><a href = "popup.question_list.php?return=<?php echo $_GET['return']; ?>
&amp;o=tags&amp;d=<?php if ($this->_vars['order_column'] == 'tags'):  echo $this->_vars['dir_other'];  else:  echo $this->_vars['dir'];  endif; ?>">Tags<?php if ($this->_vars['order_column'] == 'tags'):  echo $this->_vars['dir_arrow'];  endif; ?></a></th>
	</tr>
	<?php echo tpl_function_counter(array('print' => false,'assign' => "counter"), $this);?>
	<?php if (count((array)$this->_vars['list'])): foreach ((array)$this->_vars['list'] as $this->_vars['id'] => $this->_vars['properties']): ?>
	<?php echo tpl_function_counter(array(), $this);?>
	<tr class = "<?php if ((1 & $this->_vars['counter'])): ?>odd<?php else: ?>even<?php endif; ?> clickable question-row" style = "vertical-align:top;" id = "id_<?php echo $this->_vars['id']; ?>
">
	  <td>
	    <?php echo $this->_vars['id']; ?>

	  </td>
	  <td style = "text-align:left;">
	    <?php echo $this->_vars['properties']['text']; ?>

	  </td>
	  <td>
	    <?php if (isset ( $this->_vars['properties']['categories'] )): ?>
	    <?php if (count((array)$this->_vars['properties']['categories'])): foreach ((array)$this->_vars['properties']['categories'] as $this->_vars['category_text']): ?>
	    <?php echo $this->_vars['category_text']; ?>
<br />
	    <?php endforeach; endif; ?>
	    <?php endif; ?>
	  </td>
	  <td>
	    <?php if (count ( $this->_vars['properties']['tags'] ) > 0): ?>
	    <?php if (count((array)$this->_vars['properties']['tags'])): foreach ((array)$this->_vars['properties']['tags'] as $this->_vars['tag_text']): ?>
	    <?php echo $this->_vars['tag_text']; ?>
<br />
	    <?php endforeach; endif; ?>
	    <?php endif; ?>
	  </td>
	</tr>
	<?php endforeach; endif; ?>
      </table>
<?php else: ?>
<div style = "text-align:center;">
There are no questions.  Go to the Questions page to add some.
<br />
<input type = "submit" class = "submit" value = "Close window..." onclick = "window.close();" />
</div>
<?php endif; ?>

<script type = "text/javascript">
var parentWindowElement = "<?php echo $this->_vars['id']; ?>
";

<?php echo '
/* Add the hovering events */
$(".question-row").hover(function(){
	$(this).addClass("hover")},
	function(){
	$(this).removeClass("hover")});

$(".question-row").click(function(){
	var id = $(this).attr("id").substr(3);
	window.opener.$("#add").attr(\'value\',id);
	window.opener.$("#add-form").submit();
	window.close();
});

'; ?>

</script>
</div>
</body>
</html>
