<?php
require_once( '../bit_setup_inc.php' );
echo $gBitSystem->mDb->getOne( "SELECT MAX( `chatterbox_id` ) FROM `".BIT_DB_PREFIX."chatterbox`" );
?>
