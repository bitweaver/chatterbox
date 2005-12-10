<?php
require_once( '../bit_setup_inc.php' );
require_once( CHATTERBOX_PKG_PATH.'Chatterbox.php' );

$gChatterbox = new Chatterbox();
$gChatterbox->store( $_REQUEST );
?>
