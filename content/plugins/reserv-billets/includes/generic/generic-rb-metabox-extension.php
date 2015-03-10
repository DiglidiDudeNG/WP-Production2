<?php

/**
 * L'interface des objets RB_Metabox.
 */
abstract class RB_Metabox_Extension extends RB_Metabox
{
	
	
	public function __construct()
	{
		
	}
	
	/**
	 * @return mixed
	 */
	abstract public function add();
	
	/**
	 * Effectue le rendu du contenu de la metabox.
	 * 
	 * @param WP_Post $post Instance du post.
	 */
	abstract public function render( $post );
	
	/**
	 * Génère le HTML affiché pour le header.
	 * 
	 * @return String Le HTML formé du header de la metabox.
	 */
	abstract public function get_header_html();
	
	/**
	 * Le post-type auquel la metabox est assignée.
	 * 
	 * Essentiellement, ça pogne la propriété « Screen » pis ça la retourne.
	 * 
	 * @return String|false Le nom du post-type impliqué, faux si la metabox n'est pas reliée à un post-type.
	 */
	abstract public function get_post_type();
}
