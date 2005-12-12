last_id = -1;
function initChatterbox() {
	checkName( 'chatName' );
	focus( 'chatbarText' );
	checkStatus( '' );
	refreshChat();
	new PeriodicalExecuter( refreshChat, get_timeout );
}
function refreshChat() {
	var data = "&last_id="+last_id;
	new Ajax.Request( get_chat, { parameters: data, onSuccess: insertLines, onFailure: errorResponse } );
	new Ajax.Request( get_id, { onSuccess: setId, onFailure: errorResponse } );
}
function setId( t ) {
	last_id = t.responseText;
}
function insertLines( t ) {
	new Insertion.Top( 'outputChat', t.responseText );
}
function sendComment() {
	var data = "author="+$F( 'chatName' )+"&data="+$F( 'chatbarText' );
	new Ajax.Request( send_chat, { parameters: data, onFailure: errorResponse } );
	$( 'chatbarText' ).value = '';
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
