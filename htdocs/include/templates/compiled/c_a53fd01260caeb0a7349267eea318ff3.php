<?php /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2014-04-29 11:15:35 MDT */ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <title>
      WASSAIL: Response successfully <?php echo $this->_vars['action']; ?>
.
    </title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
      <script type = "text/javascript">
	alert('Response successfully <?php echo $this->_vars['action']; ?>
');
	window.opener.document.getElementById('response-added-note').className = 'success';
	window.opener.fadeNote();
	<?php if ($this->_vars['do'] == 'close'): ?>
	window.close();
	<?php else: ?>
	window.location = "<?php echo $this->_vars['url']; ?>
";
	<?php endif; ?>
      </script>
  </head>
  <body>
  </body>
</html>