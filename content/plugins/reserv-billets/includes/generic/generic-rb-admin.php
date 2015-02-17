<?php

/**
 * Class RB_Admin
 *
 * Classe abstraite pour les classes qui crée de quoi dans l
 */
abstract class RB_Admin
{
	/** @var String Le numéro de version du plugin. */
	protected $version;

	/**
	 * Constructeur. 'Nuff said.
	 *
	 * @param String $version Le numéro de version du plugin.
	 */
	public function __construct( $version )
	{
		$this->version = $version;
	}

	/**
	 * Pousse toutes les feuilles de styles requises du plugin pour le panneau d'administration.
	 */
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


}