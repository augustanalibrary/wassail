<?php /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2014-04-28 09:44:23 MDT */ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title>
      WASSAIL: <?php echo $this->_vars['title']; ?>

    </title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
      <base href = "<?php echo constant('WEB_PATH'); ?>
" />
	  <link rel = "stylesheet" type = "text/css" href = "include/templates/style.css"/>
	<link rel = "stylesheet" type = "text/css" href = "include/templates/print.css" media = "print" />
	<script type = "text/javascript" src = "include/templates/js/jquery-1.2.3.min.js"></script>
<?php if (! isset ( $this->_vars['no_tooltip_load'] ) || $this->_vars['no_tooltip_load'] == FALSE): ?>
	<script type = "text/javascript" src = "include/templates/js/jquery.bgiframe.js"></script>
	<script type = "text/javascript" src = "include/templates/js/jquery.dimensions.pack.js"></script>
	<script type = "text/javascript" src = "include/templates/js/jquery.tooltip.pack.js"></script>
<?php endif; ?>
	<script type = "text/javascript" src = "include/templates/js/funclib.js"></script>
	<script type = "text/javascript">
		var WEB_PATH = '<?php echo constant('WEB_PATH'); ?>
';
	</script>
</head>
<body>
	

    <div id = "body">
      <div id = "header">
		WASSAIL: <?php echo $this->_vars['title']; ?>

		<div id = "session-info">
			<?php echo $this->_vars['instance_name']; ?>
<br />
			<?php echo $this->_vars['username']; ?>

		</div>
		<span id = "header-hide">
			Hide header
		</span>
		
			

      </div>
      <div id = "navigation">
	<?php if (! $this->_vars['hide_navigation']): ?>
	<a href = "main/" <?php if ($this->_vars['title'] == 'Main'): ?>class = "active"<?php endif; ?>>
	  Main
	</a>
	<a href = "courses/" <?php if ($this->_vars['title'] == 'Courses'): ?>class = "active"<?php endif; ?>>
	  Courses/Events
	</a>
	<a href = "questions/" <?php if ($this->_vars['title'] == 'Questions'): ?>class = "active"<?php endif; ?>>
	  Questions
	</a>
	<a href = "templates/" <?php if ($this->_vars['title'] == 'Templates'): ?>class = "active"<?php endif; ?>>
	  Templates
	</a>
	<a href = "responses/" <?php if ($this->_vars['title'] == 'Responses'): ?>class = "active"<?php endif; ?>>
	  Responses
	</a>
	<a href = "reports/" <?php if ($this->_vars['title'] == 'Reports'): ?>class = "active"<?php endif; ?>>
	  Reports
	</a>
	<?php if ($this->_vars['right_account']): ?>
	<a href = "accounts/" <?php if ($this->_vars['title'] == 'Account management'): ?>class = "active"<?php endif; ?>>
	  Accounts
	</a>
	<?php endif; ?>
	<a href = "gains/" <?php if ($this->_vars['title'] == 'Gains Analysis'): ?>class = "active"<?php endif; ?>>
	  Gains Analysis
	</a>
	<div style = "float:right;">
		<?php if ($this->_vars['feedback_enabled']): ?>
			<a href = "<?php echo $this->_vars['feedback_url']; ?>
">
				Feedback
			</a>
		<?php endif; ?>
		<a href = "logout/" <?php if ($this->_vars['title'] == 'Logout'): ?>class = "active"<?php endif; ?> >
		  Logout
		</a>
	</div>
	<?php endif; ?>
      </div>
	<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("iconbar.tpl", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
      <div id = "content">
	<!-- Mask -->
	<div style = "background-color:#000;opacity:0.7;z-index:1000;width:100%;height:100%;position:absolute;top:0;left:0;display:none;" id = "mask">
	</div>
