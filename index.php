<?php
require_once( '../bit_setup_inc.php' );
$gBitSystem->verifyPermission( 'p_chatterbox_use' );
// we'll do the pruning here - no need to clear out the db on *every* js triggered page load
require_once( CHATTERBOX_PKG_PATH.'Chatterbox.php' );
$gChatterbox = new Chatterbox();
$gChatterbox->pruneList( $gBitSystem->getConfig( 'prune_threshold', 604800 ) );

// Load common ajax library
$gBitSmarty->assign( 'loadAjax', TRUE );
// display template
$gBitSystem->display( 'bitpackage:chatterbox/chatterbox.tpl', tra( 'Chat' ) );
?>
