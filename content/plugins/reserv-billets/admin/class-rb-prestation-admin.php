<?php

/**
 * Le gestionnaire de tout ce qui a rapport avec le panneau administration
 * et l'entité « Prestation ».
 */
class RB_Prestation_Admin extends RB_Admin
{
	const BASE_SLUG = 'rb_spectacle';
	public $dashicon = 'dashicons-tickets-alt';
	
	/**
	 * @var array Une liste d'arrays.
	 * TODO automatiser le rendu et la sauvegarde des metadata.
	 */
//	private $metadatas = array(
//		'date' => array(
//			'nope' => 'nope',
//		),
//		'' => array(
//
//		),
//		'd' => array(
//
//		),
//		'e' => array(
//
//		),
//	);
	
	public $metadatas = array( 
		'rb_prestation_spectacle_id', 
		'rb_prestation_date', 
		'rb_prestation_heure' 
	);
	
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
	 * Effectue un rendu de la metabox des informations.
	 *
	 * @param WP_Post $prestation
	 */
	public function render_prestation_info_metabox( $prestation )
	{
		// Éviter que quelqu'un puisse éditer s'il a pas les droits.
		if ( ! current_user_can( 'edit_posts' ) ) {
			return;
		}
		
		// Pogner toutes les metadonnées.
		$prestation_metas = get_post_meta( $prestation->ID );
		
		// Afficher le debugger si on en a besoin.
		if ( WP_DEBUG_DISPLAY ) :
			var_dump( $prestation_metas );
		endif;
		
		?>
		<table width="100%">
		<tr>
		<td style="width: 25%"><label for="rb_spectacle_id"><?=__( 'Spectacle' )?> :</label></td>
		<td>
		<select style="width: 95%" name="rb_spectacle_id" id="rb_spectacle_id">
		<?php
		/** @var WP_Query $loop_spectacles */
		$loop_spectacles = new WP_Query( [ 'post_type' => 'spectacle' ] );
		
		while ( $loop_spectacles->have_posts() ) :
			$loop_spectacles->the_post(); ?>
			<option value="<?php the_ID(); ?>" <?php
			selected( $prestation_metas['rb_spectacle_id'][0], get_the_ID() );
			?>><?php the_title(); ?></option>
		<?php endwhile; ?>
		</select>
		</td>
		<td rowspan="3" style="width: 50%; background-color: #aaa; border-radius: 8px;" id="rb_preview_spectacle">
		
		</td>
		</tr>
		<tr>
			<td><label for="rb_date"></label><?=__( 'Date de la Prestation' )?> :</td>
			<td><input type="date" id="rb_date" name="rb_date"
			           value="<?=$prestation_metas['rb_date'][0]?>" /></td>
		</tr>
		<tr>
			<td><label for="rb_heure"></label><?=__( 'Heure de la Prestation' )?> :</td>
			<td><input type="time" id="rb_heure" name="rb_heure"
			           value="<?=$prestation_metas['rb_heure'][0]?>" /></td>
		</tr>
		</table>
	<?php
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
	// * Modifie les colonnes affichées dans la liste de prestations sur le panneau d'admin.
	// *
	// * @filter manage_prestation_posts_columns
	// *
	// * @param array $columns Les colonnes.
	// *
	// * @return array La nouvelle liste de colonnes.
	// */
	//public function set_post_list_columns($columns)
	//{
	//	unset( $columns['date'], /* $columns['title'], */ $columns['categories'],
	//		$columns['author'], $columns['tags'], $columns['comments'] );
	//
	//	return array_merge( $columns,
	//		array(
	//			'rb_spectacle' => __('Spectacle'),
	//			'rb_date' => __('Date'),
	//			'rb_heure' => __('Heure'),
	//		)
	//	);
	//}

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
	
	///**
	// * Assigne la posibilité de trier des posts par rapport aux colonnes personnalisées.
	// * 
	// * @param Array $columns Les colonnes déjà triables.
	// *                       
	// * @return Array Les colonnes triables, incluant nos colonnes personnalisées.
	// */
	//public function sort_custom_columns( $columns )
	//{
	//	$columns['rb_prestation_spectacle_id'] = 'rb_prestation_spectacle_id';
	//	$columns['rb_prestation_date'] = 'rb_prestation_date';
	//	$columns['rb_prestation_heure'] = 'rb_prestation_heure';
	//	
	//	return $columns;
	//}
	//
	///**
	// * Ajoute la requête de triage pour chaque type.
	// * 
	// * @filter request
	// * 
	// * @param $vars
	// *
	// * @return array
	// */
	//public function orderby_custom_columns( $vars )
	//{
	//	foreach ( $this->get_metadatas() as $metadata )
	//	{
	//		if ( isset( $vars['orderby'] ) && $metadata == $vars['orderby'] ) {
	//			
	//			$args = array(
	//				'meta_key' => $metadata,
	//				'orderby' => 'meta_value_num'
	//			);
	//			
	//			$vars = array_merge( $vars, $args );
	//		}
	//	}
	//	
	//	return $vars;
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
		return ( get_post( $id )->post_type == 'spectacle' ? true : false );
	}
}
