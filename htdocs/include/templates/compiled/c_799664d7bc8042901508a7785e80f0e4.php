<?php /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2014-04-22 16:48:48 MDT */ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <title>
      Closing
    </title>
    <script type = "text/javascript">
	<?php if (isset ( $this->_vars['alert'] )): ?>
	alert("<?php echo $this->_vars['alert']; ?>
");
	<?php endif; ?>
      window.close();
      <?php if ($this->_vars['reload_parent']): ?>
      window.opener.location = window.opener.location;
<?php endif; ?>
    </script>
  </head>
  <body>
  </body>
</html>
  
