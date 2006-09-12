<?php
/**
 * @author   xing <xing@synapse.plus.com>
 * @version  $Revision: 1.7 $
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
		$menuHash = array(
			'package_name'  => CHATTERBOX_PKG_NAME,
			'index_url'     => CHATTERBOX_PKG_URL.'index.php',
			'menu_template' => 'bitpackage:chatterbox/menu_chatterbox.tpl',
		);
		$gBitSystem->registerAppMenu( $menuHash );
	}
}
?>
