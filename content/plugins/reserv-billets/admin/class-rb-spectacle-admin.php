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
	
	/**
	 * Effectue le rendu de rb_spectacle_liste_prestation_id.
	 *
	 * @param             $post_id
	 * @param RB_Metadata $metadata
	 *
	 * @return string
	 */
	public function render_rb_spectacle_liste_prestation_id( $post_id, $metadata )
	{
		// Déclarer variables locales
		$valeur = get_post_meta( $post_id, $metadata->get_key(), true );
		$JSONtoArray = json_decode( false, '' );
		$retour = '';
		
		
		
		return $retour;
	}
	
	/**
	 * 
	 *
	 * @param             $post_id
	 * @param RB_Metadata $metadata
	 *
	 * @return string
	 */
	public function render_rb_spectacle_artiste_site_url( $post_id, $metadata )
	{
		$valeur = get_post_meta( $post_id, $metadata->get_key(), true );
		$retour = '<input type="url" id="' . $metadata->get_key() . '" name="' . $metadata->get_key() . '" value="' . $valeur . '?>" />';
		
		
		
		return $retour;
	}
	
	/**
	 * 
	 *
	 * @param             $post_id
	 * @param RB_Metadata $metadata
	 *
	 * @return string
	 */
	public function render_rb_spectacle_artiste_facebook_url( $post_id, $metadata )
	{
		$valeur = get_post_meta( $post_id, $metadata->get_key(), true );
		$retour = '<input type="url" id="' . $metadata->get_key() . '" name="' . $metadata->get_key() . '" value="' . $valeur . '?>" />';
		
		return $retour;
	}
	
	/**
	 * 
	 * 
	 * @param             $post_id
	 * @param RB_Metadata $metadata
	 *
	 * @return string
	 */
	public function render_rb_spectacle_prix( $post_id, $metadata )
	{
		$valeur = get_post_meta( $post_id, $metadata->get_key(), true );
		$retour = '<input type="number" id="' . $metadata->get_key() . '" name="' . $metadata->get_key() . '" min="1.00" max="999.00" step="0.01" value="' . $valeur . '?>" />';
		
		
		
		return $retour;
	}
	
	/**
	 *
	 *
	 * @param             $post_id
	 * @param RB_Metadata $metadata
	 *
	 * @return string
	 */
	public function render_rb_spectacle_img_mini_url( $post_id, $metadata )
	{
		$valeur = get_post_meta( $post_id, $metadata->get_key(), true, true );
		$retour = '<input id="'.$metadata->get_html_type().'" type="file" name="'.$metadata->get_key().'" value="'.$valeur.'" size="5" />' . '<p class="description">';
		
		if ('' == $valeur)
			$retour .= __( "Vous n'avez aucune image miniature attachée à ce spectacle." );
		else
			$retour .= $valeur;
		
		$retour .= '</p>';
		
		return $retour;
		
		// https://tommcfarlin.com/wordpress-upload-meta-box/
	}
	
	/**
	 *
	 *
	 * @param             $post_id
	 * @param RB_Metadata $metadata
	 *
	 * @return string
	 */
	public function render_rb_spectacle_img_caroussel_url( $post_id, $metadata )
	{
		$valeur = get_post_meta( $post_id, $metadata->get_key(), true );
		$retour = '<input id="'.$metadata->get_key().'" type="file" name="'.$metadata->get_key().'" value="'.$valeur.'" size="5" />' . '<p class="description">';
		
		if ('' == $valeur)
			$retour .= __( "Vous n'avez aucune image miniature attachée à ce spectacle." );
		else
			$retour .= $valeur;
		
		$retour .= '</p>';
		
		return $retour;
	}
	
	/**
	 *
	 *
	 * @param             $post_id
	 * @param RB_Metadata $metadata
	 *
	 * @return string
	 */
	public function render_rb_spectacle_img_bandeau_url( $post_id, $metadata )
	{
		$valeur = get_post_meta( $post_id, $metadata->get_key(), true );
		$retour = '<input id="' . $metadata->get_key() . '" type="file" name="' . $metadata->get_key() . '" value="' . $valeur . '" size="5" />' . '<p class="description">';
		
		if ( '' == $valeur )
			$retour .= __( "Vous n'avez aucune image miniature attachée à ce spectacle." );
		else
			$retour .= $valeur;
		
		$retour .= '</p>';
		
		return $retour;
	}
}

