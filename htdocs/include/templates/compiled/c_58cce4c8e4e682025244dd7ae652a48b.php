<?php /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2014-06-12 08:48:49 MDT */ ?>

<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("head.tpl", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
    <div style = "width:50%;margin-left:auto;margin-right:auto;">
      <?php if (isset ( $this->_vars['intro'] )): ?>
        <?php echo $this->_vars['intro']; ?>

      <?php endif; ?>
    </div>
    <div class = "dialog" id = "login-box" style = "margin-bottom:50px;text-align:center;">
      <?php if (isset ( $this->_vars['error_message'] )): ?>
      <div class = "error small">
	<?php echo $this->_vars['error_message']; ?>

      </div>
	<br />
      <?php endif; ?>
      <form method = "post" action = "<?php echo constant('WEB_PATH'); ?>
form/<?php echo $this->_vars['id']; ?>
/">
      <div>
	<input type = "hidden" name = "id" value = "<?php echo $this->_vars['id']; ?>
" />
	<?php if (! isset ( $this->_vars['public'] ) || ! $this->_vars['public']): ?>
	  Password: <input type = "password" class = "input-field" name = "password" id = "password"/><br />
	  <input type = "submit" name = "login" class = "submit" value = "Login..." style = "margin-top:10px;"/>
	<?php else: ?>
	  <input type = "hidden" name = "password" value = "public" />
	  <input type = "submit" name = "login" class = "submit" value = "Begin"/>
	<?php endif; ?>
      </div>
      </form>
    </div>
    <script type = "text/javascript">
      <?php echo '
      $(document).ready(function(){
        $("#password").focus()
      });
      '; ?>

    </script>
<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("foot.tpl", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>