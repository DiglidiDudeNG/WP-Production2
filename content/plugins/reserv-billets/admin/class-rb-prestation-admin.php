<?php

/**
 * Le gestionnaire de tout ce qui a rapport avec le panneau administration
 * et l'entité « Prestation ».
 */
class RB_Prestation_Admin extends RB_Admin
{
	const BASE_SLUG = 'rb_spectacle';
	
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
	 * Effectue le rendu de L'ID du spectacle.
	 *
	 * @param             $post_id
	 * @param RB_Metadata $metadata
	 *
	 * @return string
	 */
	public function render_rb_prestation_spectacle_id( $post_id, $metadata )
	{
		$valeur = get_post_meta( $post_id, $metadata->get_key() );
		
		return '';
	}
	
	/**
	 * Effectué après la sauvegarde des metadatas du post.
	 *
	 * @global $wpdb
	 *
	 * @param int $post_id L'ID du post.
	 */
	public function post_saved( $post_id )
	{
		/** @var  */
		global $wpdb;
		
		$titre = __("Prestation")." #".$post_id . ' - ' . _draft_or_post_title(get_post_meta($post_id, 'rb_prestation_spectacle_id'));
		
		$wpdb->update( $wpdb->posts, array( 'post_title' => $titre ), array( 'p' => $post_id ) );
	}
	
	//	/**
	//	 * Sauvegarde les données des meta-data du post.
	//	 *
	//	 * Va utiliser les données $_POST envoyées par Wordpress lors de la sauvegarde.
	//	 *
	//	 * @action save_post
	//	 *
	//	 * @param int     $prestation_id    L'ID de la prestation.
	//	 * @param WP_Post $prestation       Une instance de la prestation.
	//	 */
	//	public function save_custom_post( $prestation_id, $prestation )
	//	{
	//		global $wpdb;
	//		
	//		// Checks save status
	//		$is_autosave = wp_is_post_autosave( $prestation_id );
	//		$is_revision = wp_is_post_revision( $prestation_id );
	//		// TODO effectuer la validation par NOnce.
	//		// $is_valid_nonce = ( isset( $_POST[ 'rb_nonce' ] ) && wp_verify_nonce( $_POST[ 'rb_nonce' ], basename( __FILE__ ) ) ) ? true : false;
	//		$is_valid_nonce = true;
	//		
	//		// S'en va du script dépendamment si ça passe ou non.
	//		if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
	//			return;
	//		}
	//		
	//		// Checker si on a toutes les valeurs requises pour la prestation.
	//		if ( array_key_exists( 'rb_prestation_spectacle_id', $_POST ) && array_key_exists( 'rb_prestation_date', $_POST ) 
	//		        && array_key_exists( 'rb_prestation_heure', $_POST ) ) 
	//		{	
	//			// Mettre l'ID du Spectacle si celui-ci est valide.
	//			if ( $this->valider_spectacle_id( $_POST['rb_prestation_spectacle_id'] ) ) // Updater le post_meta.
	//				update_post_meta( $prestation_id, 'rb_prestation_spectacle_id', $_POST['rb_prestation_spectacle_id'] );
	//			else return;
	//			
	//			// Mettre la date si elle est valide.
	//			if ( ! empty( $_POST['rb_prestation_date'] ) ) // Updater le post_meta.
	//				update_post_meta( $prestation_id, 'rb_prestation_date', $_POST['rb_prestation_date'] );
	//			else return;
	//			
	//			// Mettre l'heure si elle est valide.
	//			if ( ! empty( $_POST['rb_prestation_heure'] ) ) // Updater le post_meta.
	//				update_post_meta( $prestation_id, 'rb_prestation_heure', $_POST['rb_prestation_heure'] );
	//			else return;
	//			
	//			// Mettre le titre du post dans une variable.
	////			$titre = get_the_title( $_POST['rb_prestation_spectacle_id'] ) . " - " .  ;
	//			$titre = __("Prestation")." #".$prestation->ID;
	//			
	//			// Le titre.
	//			$wpdb->update( $wpdb->posts, array( 'post_title' => $titre ), array( 'ID' => $prestation_id ) );
	//		}
	//		else // Sinon
	//		{
	//			// Retourner sans rien faire. Duh.
	//			return;
	//		}
	//	}

	///**
	// * Afficher les colonnes personnalisés qui montrent les données
	// *
	// * @action manage_prestation_posts_custom_column
	// *
	// * @param String $column    Le nom de la colonne.
	// * @param int    $post_id   L'ID du post courant dans la loop d'affichage de la liste.
	// */
	//public function display_custom_columns_data( $column, $post_id )
	//{
	//	global $post;
	//
	//	switch ( $column ) {
	//		// Le spectacle relié.
	//		case 'rb_spectacle':
	//			$spec_id = get_post_meta( $post_id, 'rb_prestation_spectacle_id', true );
	//			
	//			// Chercher le spectacle au ID spécifié.
	//			$spectacle = get_the_title( $spec_id );
	//			
	//			// Checker si y'a un spectacle qui correspond.
	//			if ( empty( $spectacle ) ) // Afficher que le message n'a pas été trouvé.
	//				echo __( 'SPECTACLE INCONNU' );
	//			else // Afficher le titre du spectacle.
	//				print $spectacle;
	//			break;
	//
	//		// La date de la prestation
	//		case 'rb_date':
	//			echo self::date_string_format(get_post_meta( $post_id, 'rb_prestation_date', true ));
	//			break;
	//
	//		// L'heure de la prestation.
	//		case 'rb_heure':
	//			echo get_post_meta( $post_id, 'rb_prestation_heure', true );
	//			break;
	//	}
	//}

	/**
	 * Valide la date entrée.
	 *
	 * @param $date
	 *
	 * @return bool Vrai si ça marche, faux si non.
	 */
	private static function valider_date( $date )
	{
		$valide = true; // TODO à false
		$date = explode( '-', $date );
		
		for ( $i = 0; $i < count( $date ); $i ++ ) {
			$date[ $i ] = intval( $date[ $i ] );
		}

		if ( $date[0] ) {
			// TODO checker la date.
		}

		return $valide;
	}

	/**
	 * Formate la date pour l'affichage.
	 */
	private static function date_string_format( $date )
	{
		$finalDate = $date;

		// TODO formater la date.
		
		return $finalDate;
	}

	/**
	 * Valider l'ID du spectacle
	 *
	 * @param int $id L'Id du spectacle.
	 *
	 * @return bool Vrai si l'ID du spectacle est correct,
	 *              Faux sinon.
	 */
	private function valider_spectacle_id( $id )
	{
		return ( get_post_type( $id ) == 'spectacle' );
	}
}
