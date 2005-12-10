<div class="floaticon">{bithelp}</div>

<div class="display chatterbox">
	<div class="header">
		<h1>{tr}Chat{/tr}</h1>
	</div>

	<div class="body">
		<a name="chat"></a>
		{form id="chatForm" onsubmit="return false;" action="#"}
			<input type="text" size="12" maxlength="30" name="name" id="name" {if $gBitUser->isRegistered()}value="{displayname hash=$gBitUser->mInfo nolink=1}" onblur="checkName();" disabled="disabled"{/if} />
			<input type="text" size="55" name="chatbarText" id="chatbarText" onblur="checkStatus('');" onfocus="checkStatus('active');" />
			<input onclick="sendComment();" type="submit" id="submit" name="submit" value="submit" />
			{formhelp note="After submitting, your message might take a couple of seconds before it appears."}
		{/form}

		<div class="chathistory">
			<ul id="outputList" class="data">
				<li class="item"></li>
			</ul>
		</div>

		<script type="text/javascript">//<![CDATA[
			initChatterbox();
		//]]></script>
	</div><!-- end .body -->
</div><!-- end .chat -->
