<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title>
      WASSAIL: {$title}
    </title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
      <base href = "{ $templatelite.CONST.WEB_PATH }" />
	  <link rel = "stylesheet" type = "text/css" href = "include/templates/style.css"/>
	<link rel = "stylesheet" type = "text/css" href = "include/templates/print.css" media = "print" />
	<script type = "text/javascript" src = "include/templates/js/jquery-1.2.3.min.js"></script>
{if !isset($no_tooltip_load) or $no_tooltip_load eq FALSE}
	<script type = "text/javascript" src = "include/templates/js/jquery.bgiframe.js"></script>
	<script type = "text/javascript" src = "include/templates/js/jquery.dimensions.pack.js"></script>
	<script type = "text/javascript" src = "include/templates/js/jquery.tooltip.pack.js"></script>
{/if}
	<script type = "text/javascript" src = "include/templates/js/funclib.js"></script>
	<script type = "text/javascript">
		var WEB_PATH = '{ $templatelite.CONST.WEB_PATH }';
	</script>
</head>
<body>
	

    <div id = "body">
      <div id = "header">
		WASSAIL: {$title}
		<div id = "session-info">
			{$instance_name}<br />
			{$username}
		</div>
		<span id = "header-hide">
			Hide header
		</span>
		
			

      </div>
      <div id = "navigation">
	{if !$hide_navigation}
	<a href = "main/" {if $title == 'Main'}class = "active"{/if}>
	  Main
	</a>
	<a href = "courses/" {if $title == 'Courses'}class = "active"{/if}>
	  Courses/Events
	</a>
	<a href = "questions/" {if $title == 'Questions'}class = "active"{/if}>
	  Questions
	</a>
	<a href = "templates/" {if $title == 'Templates'}class = "active"{/if}>
	  Templates
	</a>
	<a href = "responses/" {if $title == 'Responses'}class = "active"{/if}>
	  Responses
	</a>
	<a href = "reports/" {if $title == 'Reports'}class = "active"{/if}>
	  Reports
	</a>
	{if $right_account}
	<a href = "accounts/" {if $title == 'Account management'}class = "active"{/if}>
	  Accounts
	</a>
	{/if}
	<a href = "gains/" {if $title == 'Gains Analysis'}class = "active"{/if}>
	  Gains Analysis
	</a>
	<div style = "float:right;">
		{ if $feedback_enabled }
			<a href = "{ $feedback_url }">
				Feedback
			</a>
		{ /if }
		<a href = "logout/" {if $title == 'Logout'}class = "active"{/if} >
		  Logout
		</a>
	</div>
	{/if}
      </div>
	{include file="iconbar.tpl"}
      <div id = "content">
	<!-- Mask -->
	<div style = "background-color:#000;opacity:0.7;z-index:1000;width:100%;height:100%;position:absolute;top:0;left:0;display:none;" id = "mask">
	</div>
