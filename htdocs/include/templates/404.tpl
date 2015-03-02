    {include file = "head.tpl"}
      <div style = "text-align:center;">
	<h1>
	  Page not found
	</h1>
	<h3>
	  The page you requested "<em>{$templatelite.SERVER.REQUEST_URI}</em>" does not exist.
	</h3>
	<h5>
	  If you were directed to this page from somewhere else in WASSAIL, please contact Nancy Goebel.
	</h5>
{* 
<div style = "text-align:left;">
{foreach from=$templatelite.SERVER key=key value=value}
{$key}: {$value}<br />
{/foreach}
</div>
*}
      </div>
      {include file = "foot.tpl"}