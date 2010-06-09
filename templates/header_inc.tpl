{if $smarty.const.ACTIVE_PACKAGE eq "chatterbox"}
	<script type="text/javascript">
		var refresh_timeout = 4;
		var get_chat  = "{$smarty.const.CHATTERBOX_PKG_URL}get_chat.php";
		var get_users = "{$smarty.const.CHATTERBOX_PKG_URL}get_users.php";
		var send_chat = "{$smarty.const.CHATTERBOX_PKG_URL}store_chat.php";
	</script>
	<script type="text/javascript" src="{$smarty.const.CHATTERBOX_PKG_URL}js/chat.js"></script>
	<style type="text/css">
		.chathistory	{ldelim}height:30em; overflow:auto; width:80%; float:left;{rdelim}
		.userslist		{ldelim}height:30em; overflow:auto; width:18%; float:right;{rdelim}
	</style>
{/if}
