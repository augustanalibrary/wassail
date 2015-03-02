<?php /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2014-04-20 15:39:58 MDT */ ?>

<?php if (count ( $this->_vars['forms'] )): ?>
	<ul>
		<?php if (count((array)$this->_vars['forms'])): foreach ((array)$this->_vars['forms'] as $this->_vars['form']): ?>
			<li>
				<a href = "#" class = "edit-web-form" rel = "<?php echo $this->_vars['form']['id']; ?>
"><?php if (strlen ( $this->_vars['form']['name'] )):  echo $this->_vars['form']['name'];  else:  echo $this->_vars['form']['id'];  endif; ?></a>
			</li>
		<?php endforeach; endif; ?>
	</ul>
<?php else: ?>
	No web forms have been generated for this template.
<?php endif; ?>