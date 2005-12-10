<?php
// $Header: /cvsroot/bitweaver/_bit_chatterbox/admin/admin_chatterbox_inc.php,v 1.1 2005/12/10 00:20:15 squareing Exp $

require_once( CHATTERBOX_PKG_PATH.'Chatterbox.php' );

$gChatterbox = new Chatterbox();

if( !empty( $_REQUEST['chatterbox_settings'] ) && !empty( $_REQUEST['clear_logs'] ) ) {
	$gChatterbox->pruneList( 0 );
}

// get the chatterbox data
$listHash = array(
	'page' => !empty( $_REQUEST['curPage'] ) ? $_REQUEST['curPage'] : 1,
	'max_records' => !empty( $_REQUEST['max_records'] ) ? $_REQUEST['max_records'] : 60,
	'last_id' => !empty( $_REQUEST['last_id'] ) ? $_REQUEST['last_id'] : -1,
);
$chatterbox = $gChatterbox->getList( $listHash );
$gBitSmarty->assign( 'chatterbox', $chatterbox );

// pagination
$offset = !empty( $_REQUEST['offset'] ) ? $_REQUEST['offset'] : 0;
$gBitSmarty->assign( 'curPage', $curPage = !empty( $_REQUEST['curPage'] ) ? $_REQUEST['curPage'] : 1 );

// calculate page number
$numPages = ceil( $chatterbox['cant'] / $listHash['max_records'] );
$gBitSmarty->assign( 'numPages', $numPages );

$pruneThreshold = array(
	'0'         => tra( 'None' ),
	'3600'      => tra( 'Hour' ),
	'86400'     => tra( 'Day' ),
	'604800'    => tra( 'Week' ),
	'2629743'   => tra( 'Month' ),
	'31556926'  => tra( 'Year' ),
	'999999999' => tra( 'Unlimited' ),
);
$gBitSmarty->assign( 'pruneThreshold', $pruneThreshold );

if( !empty( $_REQUEST['chatterbox_settings'] ) ) {
	simple_set_value( 'prune_threshold', CHATTERBOX_PKG_NAME );
}
?>
