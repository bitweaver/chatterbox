function initChatterbox() {
	checkName( 'chatName' );
	focus( 'chatbarText' );
	checkStatus( '' );
	refreshChat();
	//$( 'chatbarText' ).value = "------- has joined the chat -------";
	sendComment();
	new PeriodicalExecuter( refreshChat, refresh_timeout );
}
function refreshChat() {
	var data = "&last_id="+$F( 'last_id' );
	new Ajax.Request( get_chat, { parameters: data, onSuccess: insertLines, onFailure: errorResponse } );
	new Ajax.Updater( 'outputUsers', get_users, { parameters: data } );
}
function insertLines( t ) {
	if( t.responseText != '' ) {
		res = t.responseText.split( '||||' );
		$( 'last_id' ).value = res[0];
		new Insertion.Top( 'outputChat', res[1] );
	}
}
function sendComment() {
	var data = "author="+$F( 'chatName' )+"&data="+$F( 'chatbarText' );
	new Ajax.Request( send_chat, { parameters: data, onFailure: errorResponse } );
	$( 'chatbarText' ).value = '';
	$( 'chatbarText' ).focus();
}
function checkStatus( focusState ) {
	if ($F( 'chatbarText' ) != '' || focusState == 'active') {
		$( 'chatSubmit' ).disabled = false;
	} else {
		$( 'chatSubmit' ).disabled = true;
	}
}
function checkName( id ) {
	if( $F( id ) == '' ) {
		$( id ).value = 'guest-'+ Math.floor( Math.random() * 10000 );
	}
}
function errorResponse( t ) {
	alert( 'Error ' + t.status + ' -- ' + t.statusText );
}
