{include file="head.popup.tpl"}
    <div class = "no-print">
      <div class = "success">
	Web questionnaire created/updated.
      </div>
      <br />
      The URL to fill in this questionnaire is:
      <br />
      <br />
    </div>
    <div style = "text-align:center;font-weight:bold;font-size:16pt;">
      {if $https_on}https{else}http{/if}://{$templatelite.SERVER.HTTP_HOST}{$templatelite.CONST.WEB_PATH}web/{if strlen($form_name) gt 0}{ $form_name }{else}{$form_id}{/if}/
    </div>
{if !$public }
    <div class = "no-print">
      <br />
      The following accounts have been created for this questionnaire.  Give each of the respondents one of these account passwords to allow them to fill out the questionnaire.
      <br />
      <br />
    </div>
    <div class = "notice small">
      Note: passwords are case sensitive and there is no zero.
    </div>
    <div style = "text-align:left;margin-left:0;margin-right:0;font-family:monospace;">
      <ol>
	{foreach from=$respondent_accounts value=password}
	<li>
	  {$password}
	</li>
      {/foreach}
    </ol>
    </div>
{/if}
{include file="foot.popup.tpl"}