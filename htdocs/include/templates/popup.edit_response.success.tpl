<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <title>
      WASSAIL: Response successfully {$action}.
    </title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
      <script type = "text/javascript">
	alert('Response successfully {$action}');
	window.opener.document.getElementById('response-added-note').className = 'success';
	window.opener.fadeNote();
	{if $do eq 'close'}
	window.close();
	{else}
	window.location = "{$url}";
	{/if}
      </script>
  </head>
  <body>
  </body>
</html>