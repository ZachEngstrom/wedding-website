<?php

/**
 * Create the RSVP table if it doesn't exist
 **/
global $wpdb;
$rsvp_table_name = $wpdb->prefix.'rsvpform';
if($wpdb->get_var("SHOW TABLES LIKE '$rsvp_table_name'") != $rsvp_table_name) {
	//table not in database. Create new table
	$charset_collate = $wpdb->get_charset_collate();
	$sql = "
		CREATE TABLE $rsvp_table_name (
			`id`            mediumint(9) NOT NULL AUTO_INCREMENT,
			`firstName`     varchar(255) NOT NULL,
			`lastName`      varchar(255) NOT NULL,
			`primary_email` varchar(255) NOT NULL,
			`message`       text NOT NULL,
			`party_total`   int(20) NOT NULL,
			`attending`     int(20) NOT NULL,
			`food_choice`   varchar(255) NOT NULL,
			`song_request`  text NOT NULL,
			`date`          int(20) NOT NULL,
			`unread`        int(20) NOT NULL,
			`deleted`       int(20) NOT NULL,
			PRIMARY KEY (`id`)
		) $charset_collate;
	";
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );
}