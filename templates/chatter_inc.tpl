{strip}
{foreach from=$chatter item=line}
	<li class="item {if $line.chatterbox_id % 2 == 0}even{else}odd{/if}">
		<span class="date">{$line.created|bit_short_time} </span>
		<span class="username">{$line.author} </span>
		<span class="chatline">{$line.data}</span>
	</li>
{/foreach}
{/strip}
