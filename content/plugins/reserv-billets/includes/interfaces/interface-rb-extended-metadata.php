<?php
/**
 * interface-rb-extend-metadata.php
 */

interface RB_Extended_Metadata
{
	const RENDER_ACTION_PREFIX = "rb_";
	const THEME_FILTER_PREFIX = "rb_";
	
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
	 * Met à jour la metadata du post.
	 *
	 * @param Int          $post_id   L'ID du post affecté.
	 * @param String|Int   $val       La nouvelle valeur appliquée.
	 *
	 * @return String|Bool            L'ID de la meta si elle n'existait pas,
	 *                                Vrai si l'update a fonctionné,
	 *                                Faux sinon.
	 */
	public function update( $post_id, $val = null );
	
	/**
	 * Effectue le rendu de la metadata dans le panneau d'administration.
	 *
	 * @param Bool $echo Vrai si le rendu doit être retourné, faux s'il doit être echoé.
	 *
	 * @return Void|String Soit rien, soit le rendu.
	 */
	public function render($echo = true);
	
	/**
	 * Ajoute l'action pour l'echo dans le thème.
	 */
	public function add_echo_action();
	
	/**
	 * Valide la donnée entrée pour le post-meta.
	 * 
	 * @return Bool|WP_Error Vrai si la validation fut un succès, <br/>
	 *                       ou un objet WP_Error sinon.
	 */
	public function validate_data();
}
