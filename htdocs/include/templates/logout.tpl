{include file="head.tpl"}
      {if isset($message)}
      <div class = "error">
	<h1>
	  You are NOT logged out.
	</h1>
	<h4>
	  An error occurred: "{$message}"
	  <br />
	  <br />
	  In order to logout, you MUST close all browser windows.
	</h4>
      </div>
      {else}
      <div class = "success" style = "text-align:center;">
	<h1>
	  You are now logged out.
	</h1>
	<h5 style = "text-align:center;">
	  Go to the <a href = "index.php">Login page</a> to log in again.
	</h5>
      </div>
      {/if}

{include file="foot.tpl"}
