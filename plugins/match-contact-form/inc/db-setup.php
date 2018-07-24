<?php

global $wpdb;
$guestbook_table_name = $wpdb->prefix.'matchguestbook';
$contact_table_name = $wpdb->prefix.'matchcontactform';

/**
 * Create the guestbook table if it doesn't exist
 **/
if($wpdb->get_var("SHOW TABLES LIKE '$guestbook_table_name'") != $guestbook_table_name) {
	//table not in database. Create new table
	$charset_collate = $wpdb->get_charset_collate();
	$sql = "
		CREATE TABLE $guestbook_table_name (
			`id`        mediumint(9) NOT NULL AUTO_INCREMENT,
			`firstName` varchar(255) NOT NULL,
			`lastName`  varchar(255) NOT NULL,
			`email`     varchar(255) NOT NULL,
			`message`   text NOT NULL,
			`date`      int(20) NOT NULL,
			`unread`    int(20) NOT NULL,
			`approved`  int(20) NOT NULL,
			`deleted`   int(20) NOT NULL,
			PRIMARY KEY (`id`)
		) $charset_collate;
	";
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );
}

/**
 * Create the contact table if it doesn't exist
 **/
if($wpdb->get_var("SHOW TABLES LIKE '$contact_table_name'") != $contact_table_name) {
	//table not in database. Create new table
	$charset_collate = $wpdb->get_charset_collate();
	$sql = "
		CREATE TABLE $contact_table_name (
			`id`        mediumint(9) NOT NULL AUTO_INCREMENT,
			`firstName` varchar(255) NOT NULL,
			`lastName`  varchar(255) NOT NULL,
			`email`     varchar(255) NOT NULL,
			`message`   text NOT NULL,
			`date`      int(20) NOT NULL,
			`unread`    int(20) NOT NULL,
			`deleted`   int(20) NOT NULL,
			PRIMARY KEY (`id`)
		) $charset_collate;
	";
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );
}