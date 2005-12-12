{strip}
{foreach from=$chatter item=line}
	<li class="item {if $line.chatterbox_id % 2 == 0}even{else}odd{/if}">
		{if $datetime}
			<span class="date">{$line.created|bit_short_datetime} </span>
		{else}
			<span class="date">{$line.created|bit_short_time} </span>
		{/if}
		<span class="username">{$line.author} </span>
		<span class="chatline">{$line.data}</span>
	</li>
{/foreach}
{/strip}
