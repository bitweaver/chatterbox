<?php
$tables = array(
	'chatterbox' => "
		chatterbox_id I4 AUTO PRIMARY,
		user_id I4 NULL,
		channel C(40),
		author C(40),
		created I8 NOTNULL,
		data X
	",
);

global $gBitInstaller;

foreach( array_keys( $tables ) AS $tableName ) {
	$gBitInstaller->registerSchemaTable( CHATTERBOX_PKG_NAME, $tableName, $tables[$tableName] );
}

$gBitInstaller->registerPackageInfo( CHATTERBOX_PKG_NAME, array(
	'description' => "An AJAX based online chatting system. Based on <a href=\"http://www.plasticshore.com/projects/chat/\">XHTML live Chat by plasticshore</a>",
	'license' => '<a href="http://creativecommons.org/licenses/by-nc-sa/2.0/">Creative Commons</a>',
) );

// ### Default UserPermissions
$gBitInstaller->registerUserPermissions( CHATTERBOX_PKG_NAME, array(
	array( 'p_chatterbox_use', 'Can use the online chat', 'registered', CHATTERBOX_PKG_NAME ),
) );

$gBitInstaller->registerPreferences( CHATTERBOX_PKG_NAME, array(
	array( CHATTERBOX_PKG_NAME, 'chatterbox_prune_threshold', 604800 ),
) );
?>
