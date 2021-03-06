<?php
require_once( '../kernel/setup_inc.php' );
$gBitSystem->verifyPermission( 'p_chatterbox_use' );
// we'll do the pruning here - no need to clear out the db on *every* js triggered page load
require_once( CHATTERBOX_PKG_PATH.'Chatterbox.php' );
$gChatterbox = new Chatterbox();
$gChatterbox->pruneList( $gBitSystem->getConfig( 'chatterbox_prune_threshold', 604800 ) );

// Load common ajax library
$gBitSmarty->assign( 'loadAjax', 'prototype' );
// display template
$gBitSystem->display( 'bitpackage:chatterbox/chatterbox.tpl', tra( 'Chat' ) , array( 'display_mode' => 'display' ));
?>
