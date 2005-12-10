<?php
require_once( '../bit_setup_inc.php' );
$gBitSystem->verifyPermission( 'bit_p_use_chatterbox' );
// we'll do the pruning here - no need to clear out the db on *every* js triggered page load
require_once( CHATTERBOX_PKG_PATH.'Chatterbox.php' );
$gChatterbox = new Chatterbox();
$gChatterbox->pruneList( $gBitSystem->getPreference( 'prune_threshold', 604800 ) );
// display template
$gBitSystem->display( 'bitpackage:chatterbox/chatterbox.tpl', tra( 'Chat' ) );
?>
