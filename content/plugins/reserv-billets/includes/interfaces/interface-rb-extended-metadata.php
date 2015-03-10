<?php
/**
 * interface-rb-extend-metadata.php
 */

interface RB_Extended_Metadata
{
	const RENDER_ACTION_PREFIX = "rb_";
	const THEME_FILTER_PREFIX = "";
	
	/**
	 * Constructeur d'un objet Metadata.
	 *
	 * @param array  $args      Les arguments de l'objet.
	 * @param string $post_type Le post-type.
	 * @param string $key       La clé.
	 *
	 * @throws \ErrorException
	 */
	public function __construct( array $args, $post_type = 'post', $key = null );
	
	/**
	 * Mets à jour la metadata par rapport à l'ID du post courant.
	 *
	 * @param Int          $post_id   L'ID du post qui va être affecté.
	 * @param String|Int   $val       La nouvelle valeur appliquée.
	 *
	 * @return String|Bool            L'ID de la meta si elle n'existait pas,
	 *                                Vrai si l'update a fonctionné,
	 *                                Faux sinon.
	 */
	public function update( $post_id, $val = null );
	
	/**
	 * Effectue le rendu de la metadata dans les metaboxes.
	 * 
	 * @return mixed
	 */
	public function render();
	
	/**
	 * Ajoute l'action pour l'echo.
	 * 
	 * @return mixed
	 */
	public function add_echo_action();
	
	/**
	 * @return mixed
	 */
	public function validate_data();
}
