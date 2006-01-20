<?php
/**
 * @author   xing <xing@synapse.plus.com>
 * @version  $Revision: 1.3 $
 * @package  Pigeonholes
 * @subpackage functions
 */
global $gBitSystem, $gBitUser;
$gBitSystem->registerPackage( 'chatterbox', dirname( __FILE__).'/' );

if( $gBitSystem->isPackageActive( 'chatterbox' ) ) {
	if( $gBitUser->hasPermission( 'bit_p_use_chatterbox' ) ) {
		$gBitSystem->registerAppMenu( CHATTERBOX_PKG_NAME, ucfirst( CHATTERBOX_PKG_DIR ), CHATTERBOX_PKG_URL.'index.php', 'bitpackage:chatterbox/menu_chatterbox.tpl', CHATTERBOX_PKG_NAME );
	}
}
?>
