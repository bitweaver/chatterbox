<?php
/**
 * @version $Header$
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
 * @version  $Revision$
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
		parent::__construct();
		$this->mDate = new BitDate(0);
	}

	function store( &$pParamHash ) {
		if( $this->verify( $pParamHash ) ) {
			$result = $this->mDb->associateInsert( BIT_DB_PREFIX."chatterbox", $pParamHash['chatterbox_store'] );
		}
	}

	function getList( &$pListHash ) {
		global $gBitUser, $gBitSystem;
		$ret['users'] = array();
		$ret['data'] = array();
		// deal with sort_mode before prepGetList();
		if( !empty( $pListHash['sort_mode'] ) ) {
			$order = " ORDER BY ".$this->mDb->convertSortmode( $pListHash['sort_mode'] );
		} else {
			$order = " ORDER BY cb.`chatterbox_id` DESC";
		}

		$this->prepGetList( $pListHash );

		if( !@$this->verifyId( $pListHash['last_id'] ) ) {
			$pListHash['last_id'] = -1;
		}

		$query = "SELECT cb.*,
			uu.`login`, uu.`real_name`
			FROM `".BIT_DB_PREFIX."chatterbox` cb
			LEFT JOIN `".BIT_DB_PREFIX."users_users` uu ON ( uu.`user_id` = cb.`user_id` ) $order";
		$result = $this->mDb->query( $query, array(), $pListHash['max_records'], $pListHash['offset'] );

		while( !$result->EOF ) {
			$aux = $result->fields;
			if( @$this->verifyId( $aux['user_id'] ) ) {
				$aux['author'] = $gBitUser->getDisplayName( FALSE, $aux );
			}
			if( $aux['created'] >= ( $this->mDate->getUTCTime() - $gBitSystem->getConfig( 'online_user_timeout', 180 ) ) ) {
				$ret['users'][] = $aux['author'];
			}
			if( $aux['chatterbox_id'] > $pListHash['last_id'] ) {
				$ret['data'][$aux['chatterbox_id']] = $aux;
			}
			$result->MoveNext();
		}

		$ret['users'] = array_unique( $ret['users'] );
		asort( $ret['users'] );

		if( !empty( $pListHash['get_count'] ) ) {
			$query = "SELECT COUNT( cb.`chatterbox_id` ) FROM `".BIT_DB_PREFIX."chatterbox` cb";
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
		$result = $this->mDb->query( "DELETE FROM `".BIT_DB_PREFIX."chatterbox` WHERE `created` < ?", array( $this->mDate->getUTCTime() - $pPeriod ) );
	}

	function cleanupString( $pString=NULL, $pStrlen=500 ) {
		if( !empty( $pString ) ) {
			// truncate if it's too long
			if( strlen( $pString ) > $pStrlen ) {
				$pString = substr( $pString, 0, $pStrlen );
			}

			//to allow for linebreaks a space is inserted every 50 letters
			$pString = htmlspecialchars( preg_replace( "/([^\s]{50})/", "$1 ",$pString ) );

		}
		return $pString;
	}
}
?>
