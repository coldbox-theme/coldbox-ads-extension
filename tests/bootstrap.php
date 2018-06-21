<?php
/**
 * PHPUnit bootstrap file
 *
 * @package Coldbox_Ads_Extension
 */

$_tests_dir = getenv( 'WP_TESTS_DIR' );

if ( ! $_tests_dir ) {
	$_tests_dir = rtrim( sys_get_temp_dir(), '/\\' ) . '/wordpress-tests-lib';
}

if ( ! file_exists( $_tests_dir . '/includes/functions.php' ) ) {
	throw new Exception( "Could not find $_tests_dir/includes/functions.php, have you run bin/install-wp-tests.sh ?" );
}

// Give access to tests_add_filter() function.
require_once $_tests_dir . '/includes/functions.php';

/**
 * Manually load the plugin being tested.
 */
function _manually_load_plugin() {
	require dirname( dirname( __FILE__ ) ) . '/coldbox-ads-extension.php';
}
tests_add_filter( 'muplugins_loaded', '_manually_load_plugin' );

/**
 * Manually load the environment being tested.
 */
function _manually_load_environment() {

	// Switch to the Coldbox theme.
	switch_theme( 'coldbox' );

	// Update array with plugins to include.
	$plugins_to_active = array(
		'coldbox-ads-extension/coldbox-ads-extension.php',
	);

	update_option( 'active_plugins', $plugins_to_active );

}
tests_add_filter( 'muplugins_loaded', '_manually_load_environment' );

// Start up the WP testing environment.
require $_tests_dir . '/includes/bootstrap.php';
