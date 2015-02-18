<?php

	/**
	 * functions.php
	 * =========
	 *
	 * Tous les hooks en lien avec le thème
	 *
	 */


	
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
	add_theme_support("nav-menus");


	
	
	
	if(function_exists('register_nav_menus'))
	{
		register_nav_menus(array('main'=>'Navigation Principale'));
	}



	/** Hook pour enlever la désagréable bar d'Admin dans l'interface de WordPress. Ça non plus je l'aime pas. */
	add_action('get_header', 'remove_admin_login_header');

	function remove_admin_login_header() {
		remove_action('wp_head', '_admin_bar_bump_cb');
	};




?>