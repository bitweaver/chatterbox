<?php
/**
 * @version $Header: /cvsroot/bitweaver/_bit_chatterbox/store_chat.php,v 1.2 2006/10/13 12:43:12 lsces Exp $
 *
 * +----------------------------------------------------------------------+
 * | Copyright ( c ) 2004, bitweaver.org
 * +----------------------------------------------------------------------+
 * | All Rights Reserved. See copyright.txt for details and a complete list of authors.
 * | Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details
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
 * @version  $Revision: 1.2 $
 * @package  chatterbox
 */

/**
 * required setup
 */
require_once( '../bit_setup_inc.php' );
require_once( CHATTERBOX_PKG_PATH.'Chatterbox.php' );

$gChatterbox = new Chatterbox();
$gChatterbox->store( $_REQUEST );
?>
