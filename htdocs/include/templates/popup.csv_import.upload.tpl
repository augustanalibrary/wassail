{include file="head.popup.tpl"}
      {if isset($error)}
      <div class = "error">
	{$error}
      </div>
      {/if}

      {if isset($sanity_errors)}
      <div class = "error">
	Errors were found in the data:<br />
	{foreach from=$sanity_errors key=line_number value=sanity_error}
	Line #{$line_number}: {$sanity_error}<br />
	{/foreach}
      </div>
      <br />
      {/if}
      

    <form enctype="multipart/form-data" method = 'post' action = 'popup.csv_import.php'>
      <div>
	<input type = "hidden" name = "MAX_FILE_SIZE" value = "20000000" />
	<input type = "file" name = "userfile" />
	<input type = "submit" class = "submit" value = "Upload..." name = "upload"/>
      </div>
    </form>
    <br />
    <br />
    <div class = "notice small">
      See Help for information on the required CSV format.
    </div>
{include file="foot.popup.tpl"}