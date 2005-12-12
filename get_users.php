<?php
require_once( '../bit_setup_inc.php' );
require_once( CHATTERBOX_PKG_PATH.'Chatterbox.php' );

//Headers are sent to prevent browsers from caching.. IE is still resistant sometimes
header( "Expires: Mon, 26 Jul 1997 05:00:00 GMT" ); 
header( "Last-Modified: ".gmdate( "D, d M Y H:i:s" )."GMT" ); 
header( "Cache-Control: no-cache, must-revalidate" ); 
header( "Pragma: no-cache" );
header( "Content-Type: text/html; charset=utf-8" );

$gChatterbox = new Chatterbox();

$listHash = array(
	'max_records' => !empty( $_REQUEST['max_records'] ) ? $_REQUEST['max_records'] : 60,
);
$chatter = $gChatterbox->getList( $listHash );
$gBitSmarty->assign( 'users', $chatter['users'] );
echo $gBitSmarty->fetch( 'bitpackage:chatterbox/users.tpl' );
?>
