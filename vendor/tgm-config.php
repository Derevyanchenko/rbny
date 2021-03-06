<?php

// tgm
require_once dirname( __FILE__ ) . '/class-tgm-plugin-activation.php';


add_action( 'tgmpa_register', 'rbny_register_required_plugins' );

function rbny_register_required_plugins() {
	$plugins = array(
		array(
			'name'      => 'Contact Form 7',
			'slug'      => 'contact-form-7',
			'required' => true,
		),
        array(
			'name'      => 'Elementor Website Builder',
			'slug'      => 'elementor',
			'required' => true,
		),
	);

	$config = array(
		'id'           => 'tgmpa-rbny',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'parent_slug'  => 'plugins.php',            // Parent menu slug.
		'capability'   => 'manage_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => false,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => 'For this plugin and forms to work properly, you must install Contact Form 7',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => true,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
	);

	tgmpa( $plugins, $config );

}