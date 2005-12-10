<?php
/**
 * @version $Header: /cvsroot/bitweaver/_bit_chatterbox/Chatterbox.php,v 1.1 2005/12/10 00:20:15 squareing Exp $
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
 * @version  $Revision: 1.1 $
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
		$bindVars = array();
		$ret['data'] = array();
		$ret['cant'] = array();
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
			uu.`login` AS creator_user, uu.`real_name` AS creator_real_name
			FROM `".BIT_DB_PREFIX."bit_chatterbox` tcb
			LEFT JOIN `".BIT_DB_PREFIX."users_users` uu ON ( uu.`user_id` = tcb.`user_id` ) $where $order";
		$result = $this->mDb->query( $query, $bindVars, $pListHash['max_records'], $pListHash['offset'] );

		while( !$result->EOF ) {
			$aux = $result->fields;
			if( !empty( $aux['user_id'] ) ) {
				$aux['author'] = ( isset( $result->fields['creator_real_name'] ) ? $result->fields['creator_real_name'] : $result->fields['creator_user'] );
			}
			$ret['data'][$aux['chatterbox_id']] = $aux;
			$result->MoveNext();
		}

		$query = "SELECT COUNT( tcb.`chatterbox_id` ) FROM `".BIT_DB_PREFIX."bit_chatterbox` tcb";
		$ret['cant'] = $this->mDb->getOne( $query );

		return $ret;
	}

	function convertToString( $pHash ) {
		$ret = array();
		if( !empty( $pHash ) && is_array( $pHash ) ) {
			$ret = $pHash['chatterbox_id'].' ---'.$pHash['author'].' ---'.( $this->mDate->date( " [ H:i ] ", $pHash['created'] ) ).' ---'.$pHash['data'].' ---';
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
			$find[]    = "\'";
			$replace[] = "'";

			$find[]    = "'";
			$replace[] = "\'";

			$find[]    = "---";
			$replace[] = " - - ";

			// tidy up strings from form
			for( $i = 0; $i < count( $find ); $i++ ) {
				$pString = str_replace( $find[$i], $replace[$i], $pString );
			}

			// truncate it too long
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
