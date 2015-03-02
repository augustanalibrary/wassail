{include file="head.popup.tpl"}
<form method = 'post' action = 'popup.create_template_printout.php?id={$template_id}'>
Header: <input type = "text" size = "80" name = "header" style = "position:relative;left:0px;" class = "input-field" /><br />
Footer: <input type = "text" size = "80" name = "footer" style = "position:relative;left:3px;" class = "input-field" /><br /><br />
<input type = "submit" class = "submit" name = "generate-code" value = "Generate printout as XHTML code" />
<input type = "submit" class = "submit" name = "generate-pdf" value = "Generate printout as PDF" />
</form>
{include file="foot.popup.tpl"}