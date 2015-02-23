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
	 * Vérifie si la metadata est celle des billets,
	 * et si oui, éviter la marde.
	 *
	 * @param null   $null       Toujours null. Demandez-moi pas pourquoi, jsais pô!
	 * @param int    $object_id  L'ID de l'objet metadata.
	 * @param string $meta_key   La clé de la metadata.
	 * @param mixed  $meta_value La valeur courante de la metadata.
	 * @param mixed  $prev_value La valeur précédente de la metadata.
	 *
	 * @return bool|int|null     BOOLEAN si la valeur est pas valide.
	 *                           INT     si on doit la changer manuellement.
	 *                           NULL    si la valeur entrée est correcte.
	 *                           
	 * @deprecated
	 */
	public function update_spectacle_nb_billets( $null = null, $object_id, $meta_key, $meta_value, $prev_value )
	{
		if (WP_DEBUG)
			var_dump($meta_key);
		
		// Retourner vrai si ça marche, null sinon.
		return ( $meta_key == "nb_billets" && empty( $meta_value ) ) ? true : null;
	}
}

