{strip}
{form legend="Chatterbox Settings"}
	<input type="hidden" name="page" value="{$page}" />
	<div class="form-group">
		{formlabel label="Keep Chat Logs" for="chatterbox_prune_threshold"}
		{forminput}
			{html_options name="chatterbox_prune_threshold" options=$pruneThreshold values=$pruneThreshold selected=$gBitSystem->getConfig('chatterbox_prune_threshold') id=chatterbox_prune_threshold}
			{formhelp note="Specify how far back you want to keep your chat logs for. Any entries older than the specified time will automatically be removed from the database."}
		{/forminput}
	</div>

	<div class="form-group">
		{formlabel label="Online User Timeout" for="timeout"}
		{forminput}
			<input type="text" size="5" name="online_user_timeout" id="timeout" value="{$gBitSystem->getConfig('online_user_timeout')|default:180}" /> {tr}seconds{/tr}
			{formhelp note="If a user is inactive for this number of seconds, he will be removed from the active users list."}
		{/forminput}
	</div>

	<div class="form-group">
		{forminput label="checkbox"}
			<input type="checkbox" name="clear_logs" id="clear_logs" />Clear Logs
			{formhelp note="Checking this box will remove all entries recorded in your database so far."}
		{/forminput}
	</div>

	<div class="form-group submit">
		<input type="submit" class="btn btn-default" name="chatterbox_settings" value="{tr}Change preferences{/tr}" />
	</div>
{/form}

number of items: {$chatterbox.cant}
<ul class="data">
	{include file="bitpackage:chatterbox/chatter_inc.tpl" chatter=$chatterbox.data datetime=TRUE}
</ul>

{pagination curPage=$curPage numPages=$numPages offset=$offset page=$page}
{/strip}
