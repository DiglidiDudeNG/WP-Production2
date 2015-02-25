<?php
/**
 * rb-interface-metabox.php
 * 
 * Project: WP-Production2
 * User:    Félix Dion Robidoux
 * Date:    25/02/2015
 * Time:    11:08 AM
 */

/**
 * L'interface des objets RB_Metabox.
 */
interface RB_Interface_Metabox
{
	/**
	 * @return mixed
	 */
	public function add();
	
	/**
	 * Effectue le rendu du contenu de la metabox.
	 *
	 * @param WP_Post $post Instance du post.
	 *
	 * @return bool|mixed|null
	 */
	public function render( $post );
	
	/**
	 * Génère le HTML affiché pour le header.
	 *
	 * @return String Le HTML formé du header de la metabox.
	 */
	public function get_header_html();
	
	/**
	 * Le post-type auquel la metabox est assignée.
	 *
	 * Essentiellement, ça pogne la propriété « Screen » pis ça la retourne.
	 *
	 * @return String|false Le nom du post-type impliqué, faux si la metabox n'est pas reliée à un post-type.
	 */
	public function get_post_type();
	
	
}
