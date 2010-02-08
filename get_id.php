<?php
/**
 * @version $Header: /cvsroot/bitweaver/_bit_chatterbox/get_id.php,v 1.6 2010/02/08 21:27:22 wjames5 Exp $
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
 * @version  $Revision: 1.6 $
 * @package  chatterbox
 */

/**
 * required setup
 */
require_once( '../kernel/setup_inc.php' );
echo $gBitSystem->mDb->getOne( "SELECT MAX( `chatterbox_id` ) FROM `".BIT_DB_PREFIX."chatterbox`" );
?>
