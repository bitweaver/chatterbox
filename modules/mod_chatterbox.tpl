{if $smarty.const.ACTIVE_PACKAGE ne "chatterbox" and $gBitUser->hasPermission( "bit_p_use_chatterbox" )}
	{bitmodule title="$moduleTitle" name="chatterbox"}
		{form id="chatForm" onsubmit="return false;" action="#"}
			<input type="text" size="10" maxlength="30" name="name" id="name" {if $gBitUser->isRegistered()}value="{displayname hash=$gBitUser->mInfo nolink=1}" onblur="checkName();" disabled="disabled"{/if} />
			<input type="text" size="20" name="chatbarText" id="chatbarText" onblur="checkStatus('');" onfocus="checkStatus('active');" />
			<input onclick="sendComment();" type="submit" id="submit" name="submit" value="submit" />
		{/form}

		<div class="chathistory">
			<ul id="outputList" class="data">
				<li class="item"></li>
			</ul>
		</div>

		<script type="text/javascript">//<![CDATA[
			initChatterbox();
		//]]></script>
	{/bitmodule}
{/if}
