<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title>
      WASSAIL: {$title}
    </title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<base href = "{ $templatelite.CONST.WEB_PATH }" />
<script type = "text/javascript" src = "include/templates/js/jquery-1.2.3.min.js"></script>
<script type = "text/javascript" src = "include/templates/js/jquery.pngfix.js"></script>
      <link rel = "stylesheet" type = "text/css" href = "include/templates/style.css"/>
      <link rel = "stylesheet" type = "text/css" href = "include/templates/print.css" media = "print" />
      <style type = "text/css">
{ literal }

body{
   background:#000 url(include/templates/images/login-background.jpg) no-repeat top center;
color:#fff;
}
#body{
background-color:transparent;
position:relative;   
font-family:Verdana,Tahoma,Arial,Helvetica,sans-serif;
}
#login-box{
    margin:0px;
color:#000;
float:right;
}
#login-box td{
font-size:0.75em;
}
#intro-box{
width:1000px;
height:125px;
margin:0px auto 0px auto;
padding-top:150px;
color:#FFF;
}
#intro-box h1{
margin:0;
float:left;
width:400px;
}
#intro-box h2{
font-weight:normal;
font-size:18px;
margin:0;
float:left;
}
#about-box{
width:1000px;
margin: 0 auto;
color:#FFF;
font-weight:bold;
font-size:0.875em;/* 14px */
}
#logo-box{
width:750px;
margin: 50px auto 0 auto;
text-align:center;
}
#logo-box a{
float:left;
width:33%;
}
#logo-box a img{
border-width:0px;
}
.error{
font-size:0.75em;
}
{ /literal }
</style>
</head>
<body>
    <div id = "body">
      <div id = "intro-box">
	<div id = "login-box" class = "dialog">
	  {if isset($error)}
	  <div class = "error">
	    {$error}
	  </div>
	  {/if}
	  <form method = 'post' action = 'index.php' style = "z-index:100;">
	    <table>
	      <tr>
		<td>
		  Username:
		</td>
		<td>
		  <input type = "text" name = "username" id = "username"  value = "{$username}" maxlength = "255" class = "input-field"/>
		</td>
	      </tr>
	      <tr>
		<td>
		  Password:
		</td>
		<td>
		  <input type = "password" name = "password" maxlength = "255" class = "input-field"/>
		</td>
	      </tr>
	      <tr>
		<td colspan = "2" style = "text-align:center;">
		  <input type = "submit" name = "login" value = "Login" class = "submit"/>
		</td>
	      </tr>
	    </table>
	  </form>
	</div><!-- end of login box -->
	<h1>
		Welcome to WASSAIL
	</h1>
	<h2 style = "clear:left;">
	  What's <a href = "http://www.library.ualberta.ca/augustana/infolit/wassail/">WASSAIL</a>?
	</h2>
      </div><!-- end of intro box -->
    <div class = "error hidden" style = "width:710px;text-align:justify;margin-left:auto;margin-right:auto;margin-bottom: 20px;color:#000;" id = "standards-crapout">
WASSAIL has been designed for use with the minimum requirement of the Firefox 2.0 browser because of its high ability to properly display standards-compliant webpages.  Please upgrade your browser to <a href = "http://www.getfirefox.com">Firefox</a>.
    </div>
<div id = "about-box">
WASSAIL originally stood for "Web-Based Augustana Student Survey Assessment of Information Literacy." This acronym has lost some of its relevance, because WASSAIL's functionality and applications have expanded since it was created. However, WASSAIL still pays homage to the hot apple drink often enjoyed at Augustana in recognition of Augustana's Scandinavian heritage. 
<br />
<br />
WASSAIL, from its origins in Old Norse, means "be in good health."
</div>
<div id = "logo-box">
<a href = "http://www.augustana.ualberta.ca">
<img src = "include/templates/images/augustana.logo.png" alt = "Augustana Campus, University of Alberta" />
</a>
<a href = "http://www.library.ualberta.ca/augustana/infolit/">
<img src = "include/templates/images/infolit.logo.jpg" alt = "Information Literacy at Augustana" />
</a>
<a href = "http://www.library.ualberta.ca/">
<img src = "include/templates/images/ualibraries.logo.png" alt = "University of Alberta Libraries" />
</a>
</div>
    <div style = "clear:both;">
    </div>
<script type = "text/javascript">
{literal}
$(document).ready(function(){
		    $("#username").focus();
		    if($.browser.msie)
{
		      $("#standards-crapout").removeClass('hidden');
		      $("#login-box").addClass('hidden');
		      $("img").pngfix();
}
});
{/literal}
</script>
{include file="foot.tpl"}
