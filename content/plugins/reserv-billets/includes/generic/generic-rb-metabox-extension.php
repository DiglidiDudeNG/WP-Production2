<?php

/**
 * L'interface des objets RB_Metabox.
 */
abstract class RB_Metabox_Extension extends RB_Metabox
{
	// TODO la classe.
	
	/**
	 * Constructeur de l'élément RB_Metabox.
	 *
	 * @param Array  $args Les paramètres de l'objet RB_Metabox.
	 * @param String $post_type Le nom unique du post_type.
	 */
	function __construct( array $args, $post_type ) {
		parent::__construct( $args, $post_type );
	}
	
	/**
	 * Ajoute la Metabox dans l'environement Wordpress.
	 *
	 * @return bool Vrai si l'ajout a été un succès, faux sinon.
	 */
	public function add() {
		parent::add();
	}
	
	/**
	 * Effectue le rendu du contenu de la metabox.
	 *
	 * @param WP_Post $post Instance du post.
	 */
	public function render( $post ) {
		parent::render( $post );
	}
	
	/**
	 * Génère le HTML affiché pour le header.
	 *
	 * @return String Le HTML formé du header de la metabox.
	 */
	public function get_header_html() {
		return parent::get_header_html();
	}
	
	/**
	 * Le post-type auquel la metabox est assignée.
	 *
	 * Essentiellement, ça pogne la propriété « Screen » pis ça la retourne.
	 *
	 * @return String|false Le nom du post-type impliqué, faux si la metabox n'est pas reliée à un post-type.
	 */
	public function get_post_type() {
		return parent::get_post_type();
	}
}
