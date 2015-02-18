<?php

	/**
	 * functions.php
	 * =========
	 *
	 * Tous les hooks en lien avec le thème
	 *
	 */

	define('WP_DEBUG', false);

	// define('TEMPPATH', get_bloginfo('stylesheet_directory'));
	define('TEMPPATH', get_bloginfo('stylesheet_directory'));
	// get_stylesheet_directory_uri();

	/** Dossier par défaut des images. */
	define('IMAGES', TEMPPATH."/images");

	/** Dossier par défaut des scripts. */
	define('SCRIPTS', TEMPPATH."/js");


	/** Désactive le filtre de formatage `wpautop`. Je l'aime pas. */
	remove_filter( 'the_content', 'wpautop' );
	remove_filter( 'the_excerpt', 'wpautop' );


	/** Ajout de la fonctionalité des menus dans l'interface admin de WordPress. */
	/* Theme setup */
	add_action( 'after_setup_theme', 'wpt_setup' );
    if ( ! function_exists( 'wpt_setup' ) ):
        function wpt_setup() {
            register_nav_menu( 'primary', __( 'Primary navigation', 'wptuts' ) );
        } endif;

    // Register custom navigation walker
	    require_once('wp_bootstrap_navwalker.php');

	//Register bootstrap and Jquery
	function wpt_register_js() {
	    wp_register_script('jquery.bootstrap.min', SCRIPTS . '/bootstrap.min.js', 'jquery');
	}

	add_action( 'wp_enqueue_scripts', 'wpt_register_js' );

	function wpt_register_css() {
	    wp_register_style( 'bootstrap.min', get_template_directory_uri() . '/styles/css/bootstrap.min.css' );
	    wp_enqueue_style( 'bootstrap.min' );
	}

	add_action( 'wp_enqueue_scripts', 'wpt_register_css' );



	/** Hook pour enlever la désagréable bar d'Admin dans l'interface de WordPress. Ça non plus je l'aime pas. */
	add_action('get_header', 'remove_admin_login_header');

	function remove_admin_login_header() {
		remove_action('wp_head', '_admin_bar_bump_cb');
	};




?>