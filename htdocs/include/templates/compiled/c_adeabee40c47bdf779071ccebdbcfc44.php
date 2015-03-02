<?php /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2014-04-24 11:12:48 MDT */ ?>

<ol style = "margin-top:0px;">
<?php if (count((array)$this->_vars['questions'])): foreach ((array)$this->_vars['questions'] as $this->_vars['text']): ?>
<li><?php echo $this->_vars['text']; ?>
</li>
<?php endforeach; endif; ?>
</ol>