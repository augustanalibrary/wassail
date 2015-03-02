<?php /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2014-04-30 13:39:33 MDT */ ?>

<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("head.popup.tpl", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
      <?php if (isset ( $this->_vars['error'] )): ?>
      <div class = "error">
	<?php echo $this->_vars['error']; ?>

      </div>
      <?php endif; ?>

      <?php if (isset ( $this->_vars['sanity_errors'] )): ?>
      <div class = "error">
	Errors were found in the data:<br />
	<?php if (count((array)$this->_vars['sanity_errors'])): foreach ((array)$this->_vars['sanity_errors'] as $this->_vars['line_number'] => $this->_vars['sanity_error']): ?>
	Line #<?php echo $this->_vars['line_number']; ?>
: <?php echo $this->_vars['sanity_error']; ?>
<br />
	<?php endforeach; endif; ?>
      </div>
      <br />
      <?php endif; ?>
      

    <form enctype="multipart/form-data" method = 'post' action = 'popup.csv_import.php'>
      <div>
	<input type = "hidden" name = "MAX_FILE_SIZE" value = "20000000" />
	<input type = "file" name = "userfile" />
	<input type = "submit" class = "submit" value = "Upload..." name = "upload"/>
      </div>
    </form>
    <br />
    <br />
    <div class = "notice small">
      See Help for information on the required CSV format.
    </div>
<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("foot.popup.tpl", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>