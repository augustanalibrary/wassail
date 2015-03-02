<?php /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2014-04-20 14:45:02 MDT */ ?>

<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("head.tpl", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
      <?php if (isset ( $this->_vars['message'] )): ?>
      <div class = "error">
	<h1>
	  You are NOT logged out.
	</h1>
	<h4>
	  An error occurred: "<?php echo $this->_vars['message']; ?>
"
	  <br />
	  <br />
	  In order to logout, you MUST close all browser windows.
	</h4>
      </div>
      <?php else: ?>
      <div class = "success" style = "text-align:center;">
	<h1>
	  You are now logged out.
	</h1>
	<h5 style = "text-align:center;">
	  Go to the <a href = "index.php">Login page</a> to log in again.
	</h5>
      </div>
      <?php endif; ?>

<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("foot.tpl", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
