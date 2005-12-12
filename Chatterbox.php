<?php
/**
 * @version $Header: /cvsroot/bitweaver/_bit_chatterbox/Chatterbox.php,v 1.4 2005/12/12 17:31:09 squareing Exp $
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
 * @version  $Revision: 1.4 $
 * @package  chatterbox
 */

/**
 * required setup
 */
require_once( KERNEL_PKG_PATH.'BitBase.php' );
include_once( KERNEL_PKG_PATH.'BitDate.php' );

/**
 * Chatterbox
 *
 * @package  chatterbox
 */
class Chatterbox extends BitBase {
	/**
	* initiate class
	* @return none
	* @access public
	**/
	function Chatterbox() {
		BitBase::BitBase();
		$this->mDate = new BitDate(0);
	}

	function store( &$pParamHash ) {	
		if( $this->verify( $pParamHash ) ) {
			$result = $this->mDb->associateInsert( BIT_DB_PREFIX."bit_chatterbox", $pParamHash['chatterbox_store'] );
		}
	}

	function getList( &$pListHash ) {
		global $gBitUser;
		$bindVars = array();
		$ret['users'] = array();
		$ret['data'] = array();
		// deal with sort_mode before prepGetList();
		if( !empty( $pListHash['sort_mode'] ) ) {
			$order = " ORDER BY ".$this->mDb->convert_sortmode( $pListHash['sort_mode'] );
		} else {
			$order = " ORDER BY tcb.`chatterbox_id` DESC";
		}

		$this->prepGetList( $pListHash );

		$where = " WHERE chatterbox_id > ? ";
		if( !empty( $pListHash['last_id'] ) ) {
			$bindVars[] = $pListHash['last_id'];
		} else {
			$bindVars[] = -1;
		}

		$query = "SELECT tcb.*,
			uu.`login`, uu.`real_name`
			FROM `".BIT_DB_PREFIX."bit_chatterbox` tcb
			LEFT JOIN `".BIT_DB_PREFIX."users_users` uu ON ( uu.`user_id` = tcb.`user_id` ) $where $order";
		$result = $this->mDb->query( $query, $bindVars, $pListHash['max_records'], $pListHash['offset'] );

		while( !$result->EOF ) {
			// logout grace period of 2 mins
			$aux = $result->fields;
			if( !empty( $aux['user_id'] ) ) {
				$aux['author'] = $gBitUser->getDisplayName( FALSE, $aux );
			}
			if( $aux['created'] >= ( $this->mDate->getUTCTime() - 180 ) ) {
				$ret['users'][] = $aux['author'];
			}
			$time = $this->mDate->getUTCTime() - 180;
			$ret['data'][$aux['chatterbox_id']] = $aux;
			$result->MoveNext();
		}

		$ret['users'] = array_unique( $ret['users'] );

		if( !empty( $pListHash['get_count'] ) ) {
			$query = "SELECT COUNT( tcb.`chatterbox_id` ) FROM `".BIT_DB_PREFIX."bit_chatterbox` tcb";
			$ret['cant'] = $this->mDb->getOne( $query );
		}

		return $ret;
	}

	function verify( &$pParamHash ) {
		global $gBitUser;

		// if user is logged in, use the user_id, otherwise just use custom name
		$pParamHash['chatterbox_store']['user_id'] = NULL;
		$pParamHash['chatterbox_store']['author'] = NULL;
		if( $gBitUser->isRegistered() ) {
			$pParamHash['chatterbox_store']['user_id'] = $gBitUser->mUserId;
		} elseif( !empty( $pParamHash['author'] ) ) {
			$pParamHash['chatterbox_store']['author'] = Chatterbox::cleanupString( $pParamHash['author'], 30 );
		}

		// timestamp
		$pParamHash['chatterbox_store']['created'] = $this->mDate->getUTCTime();

		// data string
		if( !empty( $pParamHash['data'] ) ) {
			$pParamHash['chatterbox_store']['data'] = Chatterbox::cleanupString( $pParamHash['data'], 500 );
		} else {
			$pParamHash['chatterbox_store']['data'] = NULL;
			$this->mErrors['data'] = 'You need to enter some data to store';
		}

		return( count( $this->mErrors ) == 0 );
	}

	// remove all entries older than duration
	// defaults to one week
	function pruneList( $pPeriod=604800 ) {
		$result = $this->mDb->query( "DELETE FROM ".BIT_DB_PREFIX."bit_chatterbox WHERE created < ?", array( $this->mDate->getUTCTime() - $pPeriod ) );
	}

	function cleanupString( $pString=NULL, $pStrlen=500 ) {
		if( !empty( $pString ) ) {
			// truncate if it's too long
			if( strlen( $pString ) > $pStrlen ) {
				$pString = substr( $pString, 0, $pStrlen ); 
			}

			//to allow for linebreaks a space is inserted every 50 letters
			$pString = preg_replace( "/([^\s]{50})/", "$1 ",$pString );

		}
		return $pString;
	}
}
?>
