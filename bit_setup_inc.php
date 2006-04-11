<?php
/**
 * @author   xing <xing@synapse.plus.com>
 * @version  $Revision: 1.6 $
 * @package  Pigeonholes
 * @subpackage functions
 */
global $gBitSystem, $gBitUser;

$registerHash = array(
	'package_name' => 'chatterbox',
	'package_path' => dirname( __FILE__ ).'/',
);
$gBitSystem->registerPackage( $registerHash );

if( $gBitSystem->isPackageActive( 'chatterbox' ) ) {
	if( $gBitUser->hasPermission( 'p_chatterbox_use' ) ) {
		$gBitSystem->registerAppMenu( CHATTERBOX_PKG_NAME, ucfirst( CHATTERBOX_PKG_DIR ), CHATTERBOX_PKG_URL.'index.php', 'bitpackage:chatterbox/menu_chatterbox.tpl', CHATTERBOX_PKG_NAME );
	}
}
?>
