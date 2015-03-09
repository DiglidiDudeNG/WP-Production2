<?php

/**
 * RB_Spectacle_Admin
 * ===========
 *
 * Le gestionnaire de tout ce qui a rapport avec le panneau administration
 * et l'entité « Spectacle ».
 *
 * @package RB
 * @see RB_Spectacle::define_admin_hooks()
 */
class RB_Spectacle_Admin extends RB_Admin
{
	const BASE_SLUG = 'rb_prestation';
	public $dashicon = 'dashicons-store';
	
	/**
	 * Constructeur.
	 *
	 * @param string $post_type L'identifiant du Post-Type.
	 * @param array  $args      Les arguments.
	 */
	public function __construct( $post_type, $args )
	{
		parent::__construct( $post_type, $args );
	}

	/**
	 * Ajoute un submenu dans le menu des Spectacles.
	 */
	public function add_option_menu_spectacle()
	{
		// Ajouter le sous-menu "Configurations" dans le menu des Spectacles.
		add_submenu_page (
			'edit.php?post_type=spectacle', // Slug du parent.
			'Options des Spectacles',
			'Configurations', // Titre sur les menus
			'manage_options', // Seulement accessible si le user peut changer les options.
			'rb_spectacle_options', // Le slug de la page.
			'my_admin_page_function', // La fonction reliée à l'affichage de la page.
									  // TODO faire une fonction pour l'affichage de la page.
			'none', // Aucune icône.
			'25'
		);
	}
}

