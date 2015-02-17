<?php

/**
 *
 */
class RB_Prestation_Admin extends RB_Admin
{
	/**
	 * Constructeur. 'Nuff said.
	 *
	 * @param String $version Le numéro de version du plugin.
	 */
	public function __construct( $version )
	{
		parent::__construct( $version );
	}

	public function enqueue_styles()
	{
		wp_enqueue_style(
			'rb-spectacle-admin',   // Le nom de la feuille de style.
			plugin_dir_url( __FILE__ ) . 'css/rb-spectacle-metabox.css', // Source
			array(),                /** Dépendances des handles de style.
		 * @see WP_Dependencies::add() */
			$this->version,         // Version
			FALSE                   // Media query specification
		);

		// TODO faire un wp_dequeue_style durant la désactivation.
	}

	/**
	 * Crée des metabox pour le panneau d'administration.
	 */
	public function add_meta_box()
	{
		// Ajouter un dashicon dans le titre.
		$metabox_title = '<h1>Billets pour le Spectacle '
		                 .'<span class="dashicons dashicons-tickets-alt icone-billets">'
		                 .'</span></h1>';

		// Ajouter la meta-box.
		add_meta_box(
			'rb-spectacle-admin',        // valeur de l'attribut « id » dans la balise.
			$metabox_title, // Titre.
			array( $this, 'render_meta_box' ), // Callback qui va echo l'affichage.
			'spectacle',                 // L'écran où est affiché le meta-box.
			'normal',                    // Le contexte. ex. "side", "normal" ou "advanced".
			'core'                       // La priorité.
		);

		// TODO faire un remove_meta_box() durant la désactivation.
	}
}