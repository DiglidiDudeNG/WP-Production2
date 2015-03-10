<?php

/**
 * RB_Metadata ::: rb_prestation_spectacle_id
 */
class RB_Prestation_Spectacle_ID extends RB_Metadata_Extension
{
	
	
	/**
	 * Effectue le rendu de la metadata dans le panneau d'administration.
	 *
	 * @param Bool $echo Vrai si le rendu doit être retourné, faux s'il doit être echoé.
	 *
	 * @return Void|String Soit rien, soit le rendu.
	 */
	public function render( $echo = true ) {
		// TODO: Implement render() method.
	}
	
	/**
	 * Ajoute l'action pour l'echo dans le thème.
	 */
	public function add_echo_action() {
		// TODO: Implement add_echo_action() method.
	}
	
	/**
	 * Valide la donnée entrée pour le post-meta.
	 *
	 * @return Bool|WP_Error Vrai si la validation fut un succès, <br/>
	 *                       ou un objet WP_Error sinon.
	 */
	public function validate_data() {
		// TODO: Implement validate_data() method.
	}
	
	/**
	 * Retourne le type du post.
	 *
	 * @return String Le type du post.
	 */
	protected function get_post_type() {
		// TODO: Implement get_post_type() method.
	}
}
