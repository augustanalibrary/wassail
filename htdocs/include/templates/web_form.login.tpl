{include file="head.tpl"}
    <div style = "width:50%;margin-left:auto;margin-right:auto;">
      { if isset($intro) }
        { $intro }
      { /if }
    </div>
    <div class = "dialog" id = "login-box" style = "margin-bottom:50px;text-align:center;">
      {if isset($error_message)}
      <div class = "error small">
	{$error_message}
      </div>
	<br />
      {/if}
      <form method = "post" action = "{$templatelite.CONST.WEB_PATH}form/{$id}/">
      <div>
	<input type = "hidden" name = "id" value = "{$id}" />
	{ if !isset($public) or !$public }
	  Password: <input type = "password" class = "input-field" name = "password" id = "password"/><br />
	  <input type = "submit" name = "login" class = "submit" value = "Login..." style = "margin-top:10px;"/>
	{ else }
	  <input type = "hidden" name = "password" value = "public" />
	  <input type = "submit" name = "login" class = "submit" value = "Begin"/>
	{ /if }
      </div>
      </form>
    </div>
    <script type = "text/javascript">
      {literal}
      $(document).ready(function(){
        $("#password").focus()
      });
      {/literal}
    </script>
{include file="foot.tpl"}