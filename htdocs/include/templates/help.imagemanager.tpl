{include file="head.popup.tpl"}
{* Load lightboxing js *}
<script type = "text/javascript" src = "include/templates/js/thickbox/thickbox-compressed.js"></script>

{* Load tinyMCE popup JS so we can interface with the dialog box *}


{if isset($success)}
<div class = "{if $success}success{else}error{/if}">
	{$message}
</div>
{/if}

      <div style = "border:1px solid #ccc;padding:5px;margin-top:10px;margin-bottom:10px;" class = "small">
	<form enctype = "multipart/form-data" action = "imageManager.php" method = "post">
	<div>
	  <input type = "hidden" name = "MAX_FILE_SIZE" value = "20000000" />
	  <input type = "file" name = "userfile" class = "input-field"/>
	  <input type = "submit" class = "submit" name = "upload" value = "Upload file" />
	</div>
	</form>
      </div>

  {if $images === FALSE}
  An error occurred trying to retrieve the images
  {elseif count($images) eq 0}
  No images
  {else}
  <table class = "list">
    <tr class = "plain-header">
      <th>
	Filename
      </th>
      <th style = "width:70px;">
	Size (KB)
      </th>
      <th style = "width:110px;">
	Last modified
      </th>
      <th style = "width:175px;">
	Preview
      </th>
      <th style = "width:60px;">
	Delete
      </th>
    </tr>
	{counter print=false assign="counter"}
    {foreach from=$images value=properties}
	{counter}
    <tr class = "{if $counter is odd}odd{else}even{/if}">
      <td>
	    <div title = "Click to choose image" class = "image_name clickable" style = "padding-top:10px;padding-bottom:10px;">
	      {$properties.filename}
	    </div>
      </td>
      <td>
	{$properties.size}
      </td>
      <td>
      	<?php 
	      /* The TemplateLite way of doing this was creating really wacky dates for no discernable reason.
	       * "1407440239" got rendered as 05/03/39 instead of 07/08/14.  So, raw PHP is used
	       */
	      echo date($this->_vars['date_format_short'],$this->_vars['properties']['last_modified']);
	    ?>
      </td>
      <td>
	    <div title = "Click to view">
	      <a href = "{$web_help_image_dir}{$properties.filename}" class = "thickbox" title = "{$properties.filename|escape:"quotes"}">
		<img src = "{$web_help_image_dir}thumbs/{$properties.filename}" style = "border-width:0px;" alt = "{$properties.filename|escape:"quotes"}"/>
	      </a>
	    </div>
      </td>
      <td>
	    <form method = "post" action = "imageManager.php" onsubmit = "return(confirm('Are you sure you want to delete this image?'));">
	      <div>
	      <input type = "hidden" name = "delete" value = "{$properties.filename|escape}" />
	      <input type = "image" class = "image" src = "include/templates/images/bin.png" name = "delete" value = "{$properties.filename|escape:"quotes"}" title = "Click to delete image..." />
	      </div>
	    </form>
      </td>
    </tr>
    {/foreach}
  </table>
  {/if}

<script type = "text/javascript">
var web_help_image_dir = '{$web_help_image_dir}';
{literal}
$(".image_name").hover(function(){
			 $(this).toggleClass('hover')},
		       function(){
			 $(this).toggleClass('hover')});

$(".image_name").click(function(){
			 var URL = web_help_image_dir + $(this).text().replace(/^\s+|\s+$/g, '') ;
			 var win = window.opener.tinyMCE.getWindowArg("window");
			 win.document.getElementById('src').value = URL;
			 if(win.getImageData)
			   win.getImageData();
			 window.close();

		       });
{/literal}
</script>
{include file="foot.popup.tpl"}
      
