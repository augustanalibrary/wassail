<?php /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2014-04-20 14:28:33 MDT */ ?>

<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("head.popup.tpl", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
    <div class = "no-print">
      <div class = "success">
	Web questionnaire created/updated.
      </div>
      <br />
      The URL to fill in this questionnaire is:
      <br />
      <br />
    </div>
    <div style = "text-align:center;font-weight:bold;font-size:16pt;">
      <?php if ($this->_vars['https_on']): ?>https<?php else: ?>http<?php endif; ?>://<?php echo $_SERVER['HTTP_HOST'];  echo constant('WEB_PATH'); ?>
web/<?php if (strlen ( $this->_vars['form_name'] ) > 0):  echo $this->_vars['form_name'];  else:  echo $this->_vars['form_id'];  endif; ?>/
    </div>
<?php if (! $this->_vars['public']): ?>
    <div class = "no-print">
      <br />
      The following accounts have been created for this questionnaire.  Give each of the respondents one of these account passwords to allow them to fill out the questionnaire.
      <br />
      <br />
    </div>
    <div class = "notice small">
      Note: passwords are case sensitive and there is no zero.
    </div>
    <div style = "text-align:left;margin-left:0;margin-right:0;font-family:monospace;">
      <ol>
	<?php if (count((array)$this->_vars['respondent_accounts'])): foreach ((array)$this->_vars['respondent_accounts'] as $this->_vars['password']): ?>
	<li>
	  <?php echo $this->_vars['password']; ?>

	</li>
      <?php endforeach; endif; ?>
    </ol>
    </div>
<?php endif;  $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("foot.popup.tpl", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>