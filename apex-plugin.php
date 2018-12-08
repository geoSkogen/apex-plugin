<?php

/**

 * Plugin Name: Apex-Plugin

 */


include 'class-apex-menu.php';

include 'class-apex-api.php';

include 'class-apex-settings.php';

add_action( 'init', function(){

	$assets_url = plugin_dir_url( __FILE__ );

	//Setup menu

	if( is_admin() ){

		new Apex_Menu( $assets_url );

	}

	//Setup REST API

    $api = new Apex_API();

    $api->add_routes();

});


