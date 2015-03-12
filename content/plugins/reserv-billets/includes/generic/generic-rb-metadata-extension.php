<?php

/**
 * Module d'extension de RB_Metadata.
 */
abstract class RB_Metadata_Extension extends RB_Metadata
{
	// TODO la classe.
	
	/** @var Array La liste d'arguments pour le constructeur. */
	public $construct_args;
	
	/**
	 * Constructeur de l'extension de la Metadata.
	 *
	 * @throws \ErrorException
	 */
	public function __construct()
	{
		parent::__construct( $this->construct_args );
	}
	
	/**
	 * Retourne le type du post.
	 * 
	 * @return String Le type du post.
	 */
	abstract protected function get_post_type();
	
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
	public function update( $post_id, $val = null ) {
		return parent::update($post_id, $val);
	}
	
	/**
	 * Effectue le rendu de la metadata dans le panneau d'administration.
	 *
	 * @param Bool $echo Vrai si le rendu doit être retourné, faux s'il doit être echoé.
	 *
	 * @return Void|String Soit rien, soit le rendu.
	 */
	abstract public function render($echo = true);
	
	/**
	 * Ajoute l'action pour l'echo dans le thème.
	 */
	abstract public function add_echo_action();
	
	/**
	 * Valide la donnée entrée pour le post-meta.
	 *
	 * @param Mixed $val La nouvelle valeur à valider.
	 *
	 * @return Bool|\WP_Error Vrai si la validation fut un succès, <br/>
	 *                       ou un objet WP_Error sinon.
	 */
	abstract public function valider_nouvelle_valeur( $val );
}
