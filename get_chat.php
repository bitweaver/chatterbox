<?php
/**
 * @version $Header: /cvsroot/bitweaver/_bit_chatterbox/get_chat.php,v 1.9 2010/02/08 21:27:22 wjames5 Exp $
 *
 * +----------------------------------------------------------------------+
 * | Copyright ( c ) 2004, bitweaver.org
 * +----------------------------------------------------------------------+
 * | All Rights Reserved. See below for details and a complete list of authors.
 * | Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See http://www.gnu.org/copyleft/lesser.html for details
 * |
 * | For comments, please use phpdocu.sourceforge.net documentation standards!!!
 * | -> see http://phpdocu.sourceforge.net/
 * +----------------------------------------------------------------------+
 * | Authors: xing <xing@synapse.plus.com>
 * +----------------------------------------------------------------------+
 *
 * Chatterbox class
 *
 * @author   xing <xing@synapse.plus.com>
 * @version  $Revision: 1.9 $
 * @package  chatterbox
 */

/**
 * required setup
 */
require_once( '../kernel/setup_inc.php' );
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
	'last_id' => !empty( $_REQUEST['last_id'] ) ? $_REQUEST['last_id'] : -1,
);
$chatter = $gChatterbox->getList( $listHash );
$gBitSmarty->assign( 'chatter', $chatter['data'] );
$gBitSmarty->assign( 'users', $chatter['users'] );

if( !empty( $chatter['data'] ) ) {
	$ids = array_keys( $chatter['data'] );
	echo $ids[0];
	echo '||||';
	echo $gBitSmarty->fetch( 'bitpackage:chatterbox/chatter_inc.tpl' );
	echo '||||';
	echo $gBitSmarty->fetch( 'bitpackage:chatterbox/users_inc.tpl' );
}
?>
