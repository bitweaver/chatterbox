<?php
/**
 * @version $Header: /cvsroot/bitweaver/_bit_chatterbox/get_id.php,v 1.5 2009/10/01 14:16:59 wjames5 Exp $
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
 * @version  $Revision: 1.5 $
 * @package  chatterbox
 */

/**
 * required setup
 */
require_once( '../bit_setup_inc.php' );
echo $gBitSystem->mDb->getOne( "SELECT MAX( `chatterbox_id` ) FROM `".BIT_DB_PREFIX."chatterbox`" );
?>
