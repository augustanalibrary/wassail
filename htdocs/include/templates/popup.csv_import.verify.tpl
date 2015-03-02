    {include file="head.popup.tpl"}
      {if isset($error)}
      <div class = "error">
	{$error}
      </div>
      {/if}

      {if isset($file_contents) and is_array($file_contents)}
      <form method = "post" action = "popup.csv_import.php">
      <input type = "hidden" name = "filename" value = "{$filename}" />
      <input type = "submit" class = "submit" value = "Import data" name = "import">
      </form>
    <br />
    <br />
      <table class = "list">
	<tr class = "plain-header">
	  <th>
	    Instance ID
	  </th>
	  <th>
	    Number
	  </th>
	  <th>
	    Template ID
	  </th>
	  <th>
	    Course ID
	  </th>
	  <th>
	    Term ID
	  </th>
	  <th>
	    Type ID
	  </th>
	  <th>
	    School year
	  </th>
	  <th>
	    Question ID
	  </th>
	  <th>
	    Answer ID
	  </th>
	</tr>
	{counter print=false assign = "counter"}
	{foreach from=$file_contents value=line}
	{counter}
	<tr class = "{if $counter is odd}odd{else}even{/if}">
	  {foreach from=$line value=value}
	  <td>
	    {$value}
	  </td>
	  {/foreach}
	</tr>
	{/foreach}
      </table>
      {/if}
      {include file="foot.popup.tpl"}